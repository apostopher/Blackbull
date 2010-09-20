<?php
/*	This filter calculates the TRIX for all the scrips in NSE database.
	This script must be run after the CM database is updated. This script
	does the following:
	
	1) Calculate TRIX for all the stocks.
	2) Calculate the first TRIX values for new scrips.
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
$tableStatusEmaQuery = "SELECT timestamp FROM updatestatus WHERE tablename='filter_ema'";
$tableStatusEma = mysql_fetch_array(mysql_query($tableStatusEmaQuery));
if(!strstr($tableStatusEma['timestamp'],date("Y-m-d"))){
	echo "Can't Update now... old data";
	// Close the connection to the database
	mysql_close($con);
	return false;
}

$tableStatusTrixQuery = "SELECT timestamp FROM updatestatus WHERE tablename='filter_trix'";
$tableStatusTrix = mysql_fetch_array(mysql_query($tableStatusTrixQuery));
if(strstr($tableStatusTrix['timestamp'],date("Y-m-d"))){
	echo "Nothing to update...";
	// Close the connection to the database
	mysql_close($con);
	return flase;
}

// Initiate variables for report generation
$reportSuccess = 0;
$reportFailure = 0;
$reportMoved = 0;
$reportNew = 0;
$scripAddedFlg = false;

// TRIX depends on EMA. So we need to fetch scrips from filter_ema table.
$getScripsQuery = "SELECT symbol, ema14 FROM filter_ema WHERE 1";
$getScrips = mysql_query($getScripsQuery);
if ($getScrips) {
	while ($scrip = mysql_fetch_array($getScrips)) {
		// get 14 period EMA
		$ema14 = $scrip['ema14'];
		if ($ema14 == 0) {
			// The scrip is not ready.
			continue;
		}
		// Get old TRIX data.
		$oldTrixDataQuery = "SELECT * FROM filter_trix WHERE symbol='".$scrip['symbol']."'";
		$oldTrixData = mysql_query($oldTrixDataQuery);
		if ($oldTrixData) {
			if (mysql_num_rows($oldTrixData)) {
				$old = mysql_fetch_array($oldTrixData);
				// Get old EMA14d1 and EMA14d2
				$oldEma14d1 = $old['EMA14d1'];
				$oldEma14d2 = $old['EMA14d2'];
				$oldTrix = $old['trix'];
				$oldSignal = $old['signal'];
				$oldTrix1 = $old['trix1'];
				$oldSignal1 = $old['signal1'];
				
				// Calculate new values.
				$ema14d1 = filter_ema_calculateNewEma($ema14, $oldEma14d1, 14);
				$ema14d2 = filter_ema_calculateNewEma($ema14d1, $oldEma14d2, 14);
				
				// Now calculate TRIX.
				$trix = ($ema14d2 - $oldEma14d2)/$oldEma14d2;
				
				// Calculate signal value.
				$signal = filter_ema_calculateNewEma($trix, $oldSignal, 9);
				// Update the values in filter_trix table.
				$updateTrixQuery = "UPDATE filter_trix SET EMA14d1=".$ema14d1.", EMA14d2=".$ema14d2.", trix=".$trix.", signal=".$signal.", trix1=".$oldTrix.", signal1=".$oldSignal.", trix2=".$oldTrix1.",signal2=".$oldSignal1.", date=NOW() WHERE symbol='".$scrip['symbol']."'";
				$updateTrix = mysql_query($updateTrix);
				if (!$updateTrix) {
					// Update failed.
					$reportFailure++;
					continue;
				}
				$reportSuccess++;
			}else{
				// This is a new entry.
				// Add new entry to filter_trix table.
				$addTrixQuery = "INSERT INTO filter_trix VALUES('".$scrip['symbol']."', ".$ema14.", ".$ema14.", 0, 0, 0, 0, 0, 0, NOW())";
				$addTrix = mysql_query($addTrixQuery);
				if (!$addTrix) {
					// Adding a new scrip failed.
					$reportFailure++;
					continue;
				}
				$reportNew++;
			}
		}else{
			// Query execution failed.
			continue;
		}
	}
	// Check for obsolete data in filter_stochastics table.
	$obsoleteScripsQuery = "SELECT symbol, date FROM filter_trix WHERE date < '".date("Y-m-d")."'";
	$obsoleteScrips = mysql_query($obsoleteScripsQuery);
	if ($obsoleteScrips) {
		if (mysql_num_rows($obsoleteScrips)) {
			// There are obsolete records in filter_ema table. Lets process them
			while ($obsoleteScrip = mysql_fetch_array($obsoleteScrips)) {
				// Obsolete records do not mean that scrips are delisted.
				// The symbol of the scrip might have changed.
				// Hence we can not delete these records. 
				// Lets move these records to filter_stochastics_obsolete table for manual inspection.
				$addObsoleteQuery = "INSERT INTO filter_trix_obsolete VALUES('".$obsoleteScrip['symbol']."', '".$obsoleteScrip['date']."')";
				$addObsolete = mysql_query($addObsoleteQuery);
				if (!$addObsolete) {
					// Some error occured.
					// Update the report variable.
					$reportFailure++;
					continue;
				}
				// Now we need to delete the scrip from filter_stochastics table.
				$deleteFromEmaQuery = "DELETE FROM filter_macd WHERE symbol='".$obsoleteScrip['symbol']."'";
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
	// Unable to get scrips from filter_ema table.
	echo "Unable to read from filter_ema table. Can't continue...";
	// Close the connection to the database
	mysql_close($con);
	return flase;
}
// Script execution successful!

// Update the time in updatestatus table.
$updateTimeQuery = "UPDATE updatestatus SET timestamp= NOW() WHERE tablename='filter_trix'";
$updatedTime = mysql_query($updateTimeQuery);
if (!$updatedTime) {
	// Status update failed!
	echo "Status update in updatestatus table failed for filter_trix.";
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