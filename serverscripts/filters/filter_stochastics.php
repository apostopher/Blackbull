<?php
/*	This filter calculates the Stochastics for all the scrips in NSE database.
	This script must be run after the CM database is updated. This script
	does the following:
	
	1) Calculate Stochastics for all the stocks.
	2) Calculate the first Stochastics values for new scrips.
	3) Move changed/delisted scrips to obsolete data table.
	
	Author : Rahul Devaskar
	THIS SCRIPT IS A PROPERTY OF BLACKBULL INVESTMENT COMPANY. COPYING, EDMTING
	OR DELETING THIS SCRIPT IS PROHIBITED WITHOUT THE PERMISSION FROM THE AUTHOR.	
*/

// Load the database.
require_once('../dba.php');

// Load filter functions.
require_once ('filter_functions.php');

// Check whether we can run this script now!
$tableStatusCMQuery = "SELECT timestamp FROM updatestatus WHERE tablename='cmbhav'";
$tableStatusCM = mysql_fetch_array(mysql_query($tableStatusCMQuery));
if(!strstr($tableStatusCM['timestamp'],date("Y-m-d"))){
	echo "Can't Update now... old data";
	// Close the connection to the database
	mysql_close($con);
	return false;
}

$tableStatusStochasticsQuery = "SELECT timestamp FROM updatestatus WHERE tablename='filter_stochastics'";
$tableStatusStochastics = mysql_fetch_array(mysql_query($tableStatusStochasticsQuery));
if(strstr($tableStatusStochastics['timestamp'],date("Y-m-d"))){
	echo "Nothing to update...";
	// Close the connection to the database
	mysql_close($con);
	return flase;
}

//Initialize Variables
$periods = 14;
$oldK = 0;
$oldK1 = 0;

// Initiate variables for report generation
$reportSuccess = 0;
$reportFailure = 0;
$reportMoved = 0;
$reportNew = 0;
$scripAddedFlg = false;

// Get all the scrips and corresponding close values from CM table
$todaysCloseQuery = "SELECT symbol, close FROM cmbhav WHERE timestamp='".date("Y-m-d")."'";
$todaysCloseValues = mysql_query($todaysCloseQuery);
if ($todaysCloseValues) {
	while ( $todaysClose = mysql_fetch_array($todaysCloseValues)) {
		// Chech whether we have sufficient data to calculate %K.
		$checkRecordsQuery = "SELECT count(timestamp) as num FROM `cmbhav` WHERE symbol='".$todaysClose['symbol']."' GROUP BY symbol";
		$checkRecords = mysql_query($checkRecordsQuery);
		if ($checkRecords) {
			// We must have at least 14 records to calculate 14 period stochastics(%K).
			$numRecords = mysql_fetch_array($checkRecords);
			if ($numRecords['num'] >= $periods) {
				// Try to get the old %K from filter_stochastics table.
				// If we do not find the scrip in filter_stochastics table,
				// it means that this is a new scrip. get first %K.
				$getKQuery = "SELECT k, k1 FROM filter_stochastics WHERE symbol='".$todaysClose['symbol']."'";
				$getK = mysql_query($getKQuery);
				if ($getK) {
					if (mysql_num_rows($getK)) {
						// Reset values.
						$oldK = 0;
						$oldK1 = 0;
						// Get old K, K1, K2.
						$Ks = mysql_fetch_array($getK);
						$oldK = $Ks['k'];
						$oldK1 = $Ks['k1'];
						// Calculate the value of %K.
						$K = filter_stochastics_calculate_K($todaysClose['symbol'], $todaysClose['close'], $periods);
						// Calculate 3 days ema of %K
						$slowK = filter_ema_calculateNewEma($K, $Ks['k'], 3);
					}else{
						// This is a new scrip. get the first %K.
						$slowK = filter_stochastics_calculate_K($todaysClose['symbol'], $todaysClose['close'], $periods);
						// This might prove as new record.
						$scripAddedFlg = true;
					}
					if ($scripAddedFlg) {
						// Reset the flag
						$scripAddedFlg = false;
						
						// Check whether slowK is not zero.
						if ($slowK) {
							// This is a new scrip. Insert it into filter_stochastics table.
							$insertKQuery = "INSERT INTO filter_stochastics VALUES('".$todaysClose['symbol']."', ".$slowK.", 0, 0, NOW())";
							$insertK = mysql_query($insertKQuery);
							if (!$insertK) {
								// Update failed
								$reportFailure++;
								continue;
							}
						}else{
							// K can't be calculated for some reason.
							$reportFailure++;
							continue;
						}
					}else{
						// Check whether slowK is not zero.
						if ($slowK) {
							// Update filter_stochastics table.
							$updateKQuery = "UPDATE filter_stochastics SET k=".$slowK.", k1=".$oldK.", k2=".$oldK1.", date=NOW() WHERE symbol='".$todaysClose['symbol']."'";
							$updateK = mysql_query($updateKQuery);
							if (!$updateK) {
								// Update failed
								$reportFailure++;
								continue;
							}
							// Update report variables.
							$reportSuccess++;
						}else{
							// K can't be calculated for some reason.
							$reportFailure++;
							continue;
						}
					}
				}else{
					// Query did not run properly.
					$reportFailure++;
					continue;
				}
			}else{
				// There is no sufficient data to calculate %K
				$reportFailure++;
				continue;
			}
		}else{
			// Query failed!
			$reportFailure++;
			continue;
		}
	}
	// Check for obsolete data in filter_stochastics table.
	$obsoleteScripsQuery = "SELECT symbol, date FROM filter_stochastics WHERE date < '".date("Y-m-d")."'";
	$obsoleteScrips = mysql_query($obsoleteScripsQuery);
	if ($obsoleteScrips) {
		if (mysql_num_rows($obsoleteScrips)) {
			// There are obsolete records in filter_ema table. Lets process them
			while ($obsoleteScrip = mysql_fetch_array($obsoleteScrips)) {
				// Obsolete records do not mean that scrips are delisted.
				// The symbol of the scrip might have changed.
				// Hence we can not delete these records. 
				// Lets move these records to filter_stochastics_obsolete table for manual inspection.
				$addObsoleteQuery = "INSERT INTO filter_stochastics_obsolete VALUES('".$obsoleteScrip['symbol']."', '".$obsoleteScrip['date']."')";
				$addObsolete = mysql_query($addObsoleteQuery);
				if (!$addObsolete) {
					// Some error occured.
					// Update the report variable.
					$reportFailure++;
					continue;
				}
				// Now we need to delete the scrip from filter_stochastics table.
				$deleteFromEmaQuery = "DELETE FROM filter_stochastics WHERE symbol='".$obsoleteScrip['symbol']."'";
				$deletedScrip = mysql_query($deleteFromEmaQuery);
				if ($deletedScrip) {
					// Scrip is succesfully moved to obsolete table.
					// Update the report variable.
					$reportMoved++;
				}else{
					// Update the report variable.
					$reportFailure++;
				}
			}
		}
	}
}else{
	// Can't retrieve data from CM table.
	echo "Can't retrieve data from CM table. Can't continue...";
	mysql_close($con);
	return false;
}
// Script execution successful!

// Update the time in updatestatus table.
$updateTimeQuery = "UPDATE updatestatus SET timestamp= NOW() WHERE tablename='filter_stochastics'";
$updatedTime = mysql_query($updateTimeQuery);
if (!$updatedTime) {
	// Status update failed!
	echo "Status update in updatestatus table failed for filter_stochastics.";
}
// Print the report.
echo "<div id='reportcard'>";
echo "<p>Success:&nbsp;<strong>".$reportSuccess."</strong></p>";
echo "<p>New:&nbsp;<strong>".$reportNew."</strong></p>";
echo "<p>Moved:&nbsp;<strong>".$reportMoved."</strong></p>";
echo "<p>Failure:&nbsp;<strong>".$reportFailure."</strong></p>";
echo "</div>";

// Close databse connection.
mysql_close($con);
return true;
?>