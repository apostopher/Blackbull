<?php
/*	This filter calculates the EMAs for all the scrips in NSE database.
	This script must be run after the CM database is updated. This script
	does the following:
	
	1) Calculate EMAs for all the stocks.
	2) Calculate the first EMA values for new scrips.
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

$tableStatusEmaQuery = "SELECT timestamp FROM updatestatus WHERE tablename='filter_ema'";
$tableStatusEma = mysql_fetch_array(mysql_query($tableStatusEmaQuery));
if(strstr($tableStatusEma['timestamp'],date("Y-m-d"))){
	echo "Nothing to update...";
	// Close the connection to the database
	mysql_close($con);
	return false;
}

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
	// Cycle through all the scrips and UPDATE or CREATE the EMA entries in filter_ema table
	while ( $todaysClose = mysql_fetch_array($todaysCloseValues)) {
		// Get the last EMA from the filter_ema table
		$lastEmaQuery = "SELECT ema26, ema14, ema12 FROM filter_ema WHERE symbol='".$todaysClose['symbol']."'";
		$lastEmaValues = mysql_query($lastEmaQuery);
		if ($lastEmaValues) {
			// Initialize EMAs
			$ema12 = 0;
			$ema14 = 0;
			$ema26 = 0;
			if (mysql_num_rows($lastEmaValues)) {
				// The scrip was found in the filter_ema table. We now update the values.
				while ( $emaRow = mysql_fetch_array($lastEmaValues)) {

					// Get 12 period EMA
					if ($emaRow['ema12']) {
						// The EMA value is not zero. Update EMA using latest close value.
						$ema12 = filter_ema_calculateNewEma($todaysClose['close'], $emaRow['ema12'], 12);
					}else{
						// The EMA value is zero. get first EMA value if possible
						$ema12 = filter_ema_getFirstEma($todaysClose['symbol'], 12);
					}
					
					// Get 14 period EMA
					// If 12 period EMA is zero, 14 period EMA will also be zero.
					if ($ema12) {
						if ($emaRow['ema14']) {
							// The EMA value is not zero. Update EMA using latest close value.
							$ema14 = filter_ema_calculateNewEma($todaysClose['close'], $emaRow['ema14'], 14);
						}else{
							// The EMA value is zero. get first EMA value if possible
							$ema14 = filter_ema_getFirstEma($todaysClose['symbol'], 14);
						}
					}
					
					// Get 26 period EMA
					// If 14 period EMA is zero, 26 period EMA will also be zero.
					if ($ema14) {
						// Get 26 period EMA
						if ($emaRow['ema26']) {
							// The EMA value is not zero. Update EMA using latest close value.
							$ema26 = filter_ema_calculateNewEma($todaysClose['close'], $emaRow['ema26'], 26);
						}else{
							// The EMA value is zero. get first EMA value if possible
							$ema26 = filter_ema_getFirstEma($todaysClose['symbol'], 26);
						}					
					}	
				}
			}else{
				// The record was not found in the filter_ema table. Which means that
				// we may need to add new record to filter_ema table.
				
				// Get 12 period first EMA
				$ema12 = filter_ema_getFirstEma($todaysClose['symbol'], 12);
				
				// If 12 period EMA is zero, 14 period EMA will also be zero.
				if ($ema12) {
					$ema14 = filter_ema_getFirstEma($todaysClose['symbol'], 14);
				}
				
				// If 14 period EMA is zero, 26 period EMA will also be zero.
				if ($ema14) {
					$ema26 = filter_ema_getFirstEma($todaysClose['symbol'], 26);
				}
				// Set the scrip added flag.
				$scripAddedFlg = true;
			}
			if ($scripAddedFlg) {
				// Reset the flag
				$scripAddedFlg = false;
				
				// This is a new record. Insert it into filter_ema.
				// Check whether 12 day EMA, 14 day EMA and 26 day EMA are not zero
				if ($ema12 || $ema14 || $ema26) {
					$insertEmaQuery = "INSERT INTO filter_ema VALUES('".$todaysClose['symbol']."', ".$ema26.", ".$ema14.", ".$ema12.", NOW())";
					$insertEma = mysql_query($insertEmaQuery);
					if ($insertEma) {
						// Update the report variable.
						$reportSuccess++;
						$reportNew++;
					}else{
						// Update the report variable.
						$reportFailure++;
					}
				}
			}else{
				// Check whether 12 day EMA, 14 day EMA and 26 day EMA are not zero
				if ($ema12 || $ema14 || $ema26) {
					// We have updated the values. INSERT the updated values in filter_ema table;
					$updateEmaQuery = "UPDATE filter_ema SET ema26='".$ema26."', ema14='".$ema14."', ema12='".$ema12."', date=NOW() WHERE symbol='".$todaysClose['symbol']."'";
					$updateResult = mysql_query($updateEmaQuery);
					if ($updateResult) {
						// Update the report variable.
						$reportSuccess++;
					}else{
						// Update the report variable.
						$reportFailure++;
					}
				}
			}	
		}else{
			// Update the report variable.
			$reportFailure++;
		}
	}
	// We need to check for the scrips which are removed from CM.
	// This can be done by checking the date column in filter_ema table.
	$obsoleteScripsQuery = "SELECT symbol, date FROM filter_ema WHERE date < '".date("Y-m-d")."'";
	$obsoleteScrips = mysql_query($obsoleteScripsQuery);
	if ($obsoleteScrips) {
		if (mysql_num_rows($obsoleteScrips)) {
			// There are obsolete records in filter_ema table. Lets process them
			while ($obsoleteScrip = mysql_fetch_array($obsoleteScrips)) {
				// Obsolete records do not mean that scrips are delisted.
				// The symbol of the scrip might have changed.
				// Hence we can not delete these records. 
				// Lets move these records to filter_ema_obsolete table for manual inspection.
				$addObsoleteQuery = "INSERT INTO filter_ema_obsolete VALUES('".$obsoleteScrip['symbol']."', '".$obsoleteScrip['date']."')";
				$addObsolete = mysql_query($addObsoleteQuery);
				if (!$addObsolete) {
					// Some error occured.
					// Update the report variable.
					$reportFailure++;
					continue;
				}
				// Now we need to delete the scrip from filter_ema table.
				$deleteFromEmaQuery = "DELETE FROM filter_ema WHERE symbol='".$obsoleteScrip['symbol']."'";
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
	// The filter_ema table is now up to date!
}else{
	echo "Error obtaining close values from CM table. Can't continue...";
	// Close the connection to the database
	mysql_close($con);
	return false;
}
// Script execution successful!

// Update the time in updatestatus table.
$updateTimeQuery = "UPDATE updatestatus SET timestamp= NOW() WHERE tablename='filter_ema'";
$updatedTime = mysql_query($updateTimeQuery);
if (!$updatedTime) {
	// Status update failed!
	echo "Status update in updatestatus table failed for filter_ema.";
}
// Print the report.
echo "<div id='reportcard'>";
echo "<p>Success:&nbsp;<strong>".$reportSuccess."</strong></p>";
echo "<p>New:&nbsp;<strong>".$reportNew."</strong></p>";
echo "<p>Moved:&nbsp;<strong>".$reportMoved."</strong></p>";
echo "<p>Failure:&nbsp;<strong>".$reportFailure."</strong></p>";
echo "</div>";

// Close the connection to the database
mysql_close($con);
return true;
?>