<?php
/*	This filter calculates the MACD for all the scrips in NSE database.
	This script must be run after the CM database is updated. This script
	does the following:
	
	1) Calculate MACD for all the stocks.
	2) Calculate the first MACD value for new scrips.
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
$tableStatusCMQuery = "SELECT timestamp FROM updatestatus WHERE tablename='filter_ema'";
$tableStatusCM = mysql_fetch_array(mysql_query($tableStatusCMQuery));
if(!strstr($tableStatusCM['timestamp'],date("Y-m-d"))){
	echo "Can't Update now... old data";
	// Close the connection to the database
	mysql_close($con);
	return false;
}

// Initialize variables.
$periods = 9;

// Initiate variables for report generation
$reportSuccess = 0;
$reportFailure = 0;
$reportMoved = 0;
$reportNew = 0;
$scripAddedFlg = false;

$tableStatusMacdQuery = "SELECT timestamp FROM updatestatus WHERE tablename='filter_macd'";
$tableStatusMacd = mysql_fetch_array(mysql_query($tableStatusMacdQuery));
if(strstr($tableStatusMacd['timestamp'],date("Y-m-d"))){
	echo "Nothing to update...";
	// Close the connection to the database
	mysql_close($con);
	return false;
}
// MACD depends on EMA. So we need to fetch scrips from filter_ema table.
$getScripsQuery = "SELECT symbol, ema26, ema12 FROM filter_ema WHERE 1";
$getScrips = mysql_query($getScripsQuery);
if ($getScrips) {
	while ($scrip = mysql_fetch_array($getScrips)) {
		// Get 26 period EMA and 12 period EMA.
		$ema26 = $scrip['ema26'];
		$ema12 = $scrip['ema12'];
		if($ema12 == 0){
			// The scrip is not ready.
			continue;
		}
		$macd = $ema12 - $ema26;
		// Get old MACDs and signals.
		$getMacdQuery = "SELECT macd, signal, macd1, signal1 FROM filter_macd WHERE symbol='".$scrip['symbol']."'";
		$getMacd = mysql_query($getMacdQuery);
		if ($getMacd) {
			if (mysql_num_rows($getMacd)) {
				// Get old MACD values.
				$oldMacds = mysql_fetch_array($getMacd);
				
				// Update signal value.
				$signal = filter_ema_calculateNewEma($macd, $oldMacds['signal'], $periods);
			}else{
				// This is a new scrip.
				$signal = $macd;
				$scripAddedFlg = true;
			}
			if ($scripAddedFlg) {
				// Reset the flag.
				$scripAddedFlg = false;
				
				// This is a new record. Insert it into filter_macd table.
				$insertMacdQuery = "INSERT INTO filter_macd VALUES('".$scrip['symbol']."', ".$macd.", ".$signal.", 0, 0, 0, 0, NOW())";
				$insertMacd = mysql_query($insertMacdQuery);
				if (!$insertMacd) {
					// Error occured.
					echo "$insertMacdQuery";
					$reportFailure++;
					continue;
				}
				$reportSuccess++;
				$reportNew++;
			}else{
				// Update filter_macd table.
				$updateMacdQuery = "UPDATE filter_macd SET macd=".$macd.", signal=".$signal.", macd1=".$oldMacds['macd'].", signal1=".$oldMacds['signal'].", macd2=".$oldMacds['macd1'].", signal2=".$oldMacds['signal1'].", date=NOW() WHERE symbol='".$scrip['symbol']."'";
				$updateMacd = mysql_query($updateMacdQuery);
				if (!$updateMacd) {
					// Error occured.
					echo "$updateMacdQuery";
					$reportFailure++;
					continue;
				}
				$reportSuccess++;
			}
		}else{
			// Error Occured
			$reportFailure++;
			continue;
		}
	}
	
	// Check for obsolete data in filter_stochastics table.
	$obsoleteScripsQuery = "SELECT symbol, date FROM filter_macd WHERE date < '".date("Y-m-d")."'";
	$obsoleteScrips = mysql_query($obsoleteScripsQuery);
	if ($obsoleteScrips) {
		if (mysql_num_rows($obsoleteScrips)) {
			// There are obsolete records in filter_ema table. Lets process them
			while ($obsoleteScrip = mysql_fetch_array($obsoleteScrips)) {
				// Obsolete records do not mean that scrips are delisted.
				// The symbol of the scrip might have changed.
				// Hence we can not delete these records. 
				// Lets move these records to filter_stochastics_obsolete table for manual inspection.
				$addObsoleteQuery = "INSERT INTO filter_macd_obsolete VALUES('".$obsoleteScrip['symbol']."', '".$obsoleteScrip['date']."')";
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
	// Can't get data from filter_ema table.
	echo "Can't get data from filter_ema. Can't continue...";
	// Close database connection.
	mysql_close($con);
	return false;	
}
// Script execution successful!

// Update the time in updatestatus table.
$updateTimeQuery = "UPDATE updatestatus SET timestamp= NOW() WHERE tablename='filter_macd'";
$updatedTime = mysql_query($updateTimeQuery);
if (!$updatedTime) {
	// Status update failed!
	echo "Status update in updatestatus table failed for filter_macd.";
}
// Print the report.
echo "<div id='reportcard'>";
echo "<p>Success:&nbsp;<strong>".$reportSuccess."</strong></p>";
echo "<p>New:&nbsp;<strong>".$reportNew."</strong></p>";
echo "<p>Moved:&nbsp;<strong>".$reportMoved."</strong></p>";
echo "<p>Failure:&nbsp;<strong>".$reportFailure."</strong></p>";
echo "</div>";

// Close database connection.
mysql_close($con);
return true;
?>