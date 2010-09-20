<?php
/*	This filter calculates the ADX for all the scrips in NSE database.
	This script must be run after the CM database is updated. This script
	does the following:
	
	1) Calculate ADX for all the stocks.
	2) Calculate the first TR, ATR, ADX values for new scrips.
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
	// Close the connection to the database.
	mysql_close($con);
	return false;
}

$tableStatusADXQuery = "SELECT timestamp FROM updatestatus WHERE tablename='filter_adx'";
$tableStatusADX = mysql_fetch_array(mysql_query($tableStatusADXQuery));
if(strstr($tableStatusADX['timestamp'],date("Y-m-d"))){
	echo "Nothing to update...";
	// Close the connection to the database.
	mysql_close($con);
	return false;
}
// Initialize variables
$plusDM = 0;
$minusDM = 0;

// Initiate variables for report generation
$reportSuccess = 0;
$reportFailure = 0;
$reportMoved = 0;
$reportNew = 0;
$scripAddedFlg = false;

// Get all the scrips and corresponding close values from CM table
$todaysScripsQuery = "SELECT symbol, high, low, close, prevclose FROM cmbhav WHERE timestamp='".date("Y-m-d")."'";
$todaysScripsValues = mysql_query($todaysScripsQuery);

if ($todaysScripsValues) {
	// Cycle through all the scrips and UPDATE or CREATE the ADX entries in filter_adx table
	while ( $scrip = mysql_fetch_array($todaysScripsValues)) {
		// calculate +DM and -DM values.
		// Calculation:
		// A = Today's High – Yesterday's High
		// B = Yesterday's Low – Today's Low
		//
		// Depending upon the values of A and B, three possible scenarios are:
		// ------------------------------------------
		// | Values				|	Scenarios		|
		// ------------------------------------------
		// |					|					|
		// | Both A and B < 0	| +DM=0, -DM=0		|
		// | A > B				| +DM=A, -DM=0		|
		// | B > A				| +DM=0, -DM=B		|
		// ------------------------------------------
		//
		// So we need to fetch yesterday's data to calculate +DM and -DM
		$yesterdaysScripQuery = "SELECT high, low FROM cmbhav WHERE symbol='".$scrip['symbol']."' AND timestamp<'".date("Y-m-d")."' ORDER BY timestamp DESC LIMIT 1";
		$yesterdaysScrip = mysql_query($yesterdaysScripQuery);
		if ($yesterdaysScrip) {
			// Check whether we have yesterday's data
			if (mysql_num_rows($yesterdaysScrip)) {
				// Get yesterday's data.
				$yesterdaysData = mysql_fetch_array($yesterdaysScrip);
				
				// First get old values of plusDM14, minusDM14, TR14 and ADX.
				$getOldValuesQuery = "SELECT plusDM14, minusDM14, TR14, ADX, ADX1 FROM filter_adx WHERE symbol='".$scrip['symbol']."'";
				$getOldValues = mysql_query($getOldValuesQuery);
				if ($getOldValues) {
					if (mysql_num_rows($getOldValues)) {
						$oldValues = mysql_fetch_array($getOldValues);
						
						// Calculate A and B
						$A = $scrip['high'] - $yesterdaysData['high'];
						$B = $yesterdaysData['low'] - $scrip['low'];
						
						// Now calculate +DM and -DM
						if ($A < 0 && $B < 0) {
							$plusDM = 0;
							$minusDM = 0;
						}else if ($A > $B) {
							$plusDM = $A;
							$minusDM = 0;
						}else if ($B > $A) {
							$plusDM = 0;
							$minusDM = $B;
						}else if ($A = $B) {
							$plusDM = 0;
							$minusDM = 0;
						}
						/* Now calculate TR
							 Calculation:
							 True range is the largest of: 
								1) Today's High - Today's Low,
								2) Today's High - Yesterday's Close, and
								3) Yesterday's Close - Today's Low */
						$TR = $scrip['high'] - $scrip['low'];
						if ($scrip['high'] - $scrip['prevclose'] > $TR) {
							$TR = $scrip['high'] - $scrip['prevclose'];
						}
						if ($scrip['prevclose'] - $scrip['low'] > $TR) {
							$TR = $scrip['prevclose'] - $scrip['low'];
						}
				
						// Calculate EMAs
						$plusDM14 = filter_ema_calculateNewEma($plusDM, $oldValues['plusDM14'], 14);
						$minusDM14 = filter_ema_calculateNewEma($minusDM, $oldValues['minusDM14'], 14);
						$TR14 = filter_ema_calculateNewEma($TR, $oldValues['TR14'], 14);
						
						// Now calculate +DI and -DI
						$plusDI = $plusDM14/$TR14;
						$minusDI = $minusDM14/$TR14;
						
						// Now calculate DIDiff
						if ($plusDI > $minusDI) {
							$DIDiff = $plusDI - $minusDI;
						}else{
							$DIDiff = $minusDI - $plusDI;
						}
						
						// Now calculate DX
						$DX = ($DIDiff/($plusDI + $minusDI))*100;
						$ADX = round(filter_ema_calculateNewEma($DX, $oldValues['ADX'], 14));
						
						//UPDATE filter_adx table.
						$updateADXQuery = "UPDATE filter_adx SET plusDM14=".$plusDM14.", minusDM14=".$minusDM14.", TR14=".$TR14.", ADX=".$ADX.", ADX1=".$oldValues['ADX'].", ADX2=".$oldValues['ADX1'].", date=NOW() WHERE symbol='".$scrip['symbol']."'";
						$updateADX = mysql_query($updateADXQuery);
						if(!$updateADX){
							// Update failed.
                                                        echo $updateADXQuery."<br/>";
							$reportFailure++;
						}
						$reportSuccess++;
					}else{
						// This is a new scrip
						// Try to get data for last 15 periods in order to calculate first DM and TR values.
						$getPastDataQuery = "SELECT low, high, close FROM cmbhav WHERE symbol='".$scrip['symbol']."' ORDER BY timestamp DESC LIMIT 15";
						$getPastData = mysql_query($getPastDataQuery);
						if ($getPastData) {
							if (mysql_num_rows($getPastData)) {
								$sumPlusDM = 0;
								$sumMinusDM = 0;
								$sumTR = 0;
								// Get first two rows.
								$row = mysql_fetch_array($getPastData);
								$prevRow = mysql_fetch_array($getPastData);
								while ($prevRow) {
									// Calculate A and B
									$A = $row['high'] - $prevRow['high'];
									$B = $prevRow['low'] - $row['low'];
									
									// Now calculate +DM and -DM
									if ($A < 0 && $B < 0) {
										$plusDM = 0;
										$minusDM = 0;
									}else if ($A > $B) {
										$plusDM = $A;
										$minusDM = 0;
									}else if ($B > $A) {
										$plusDM = 0;
										$minusDM = $B;
									}else if ($A = $B) {
										$plusDM = 0;
										$minusDM = 0;
									}
									/* Now calculate TR
										 Calculation:
										 True range is the largest of: 
											1) Today's High - Today's Low,
											2) Today's High - Yesterday's Close, and
											3) Yesterday's Close - Today's Low */
									$TR = $row['high'] - $row['low'];
									if ($row['high'] - $prevRow['close'] > $TR) {
										$TR = $row['high'] - $prevRow['close'];
									}
									if ($prevRow['close'] - $row['low'] > $TR) {
										$TR = $prevRow['close'] - $row['low'];
									}
									$sumPlusDM = $sumPlusDM + $plusDM;
									$sumMinusDM = $sumMinusDM + $minusDM;
									$sumTR = $sumTR + $TR;
									
									// Move the rows ahead.
									$row = $prevRow;
									$prevRow = mysql_fetch_array($getPastData);
								}
								// To calculate first value we calculate SMA of 14 periods.
								$plusDM14 = $sumPlusDM/14;
								$minusDM14 = $sumMinusDM/14;
								$TR14 = $sumTR/14;
								
								// Now calculate +DI and -DI
								$plusDI = $plusDM14/$TR14;
								$minusDI = $minusDM14/$TR14;
								
								// Now calculate DIDiff
								if ($plusDI > $minusDI) {
									$DIDiff = $plusDI - $minusDI;
								}else{
									$DIDiff = $minusDI - $plusDI;
								}
								
								// Now calculate ADX
								// ADX is a 14 period EMA of DX but we use DX = ADX for first ADX.
								$ADX = round(($DIDiff/($plusDI + $minusDI))*100);
								
								// Now we have first values of plusDM14, minusDM14, TR14 AND ADX.
								// Add a new record to filter_adx table.
								$addADXQuery = "INSERT INTO filter_adx VALUES('".$scrip['symbol']."', ".$plusDM14.", ".$minusDM14.", ".$TR14.", ".$ADX.", 0, 0, date=NOW())";
								$addADX = mysql_query($addADXQuery);
								if (!$addADX) {
									// Insert failed.
                                                                        echo $addADXQuery."<br/>";
									$reportFailure++;
								}
								$reportNew++;
							}else{
								// The scrip is not ready.
								continue;
							}
						}else{
							// The scrip is not ready.
							continue;
						}
					}
				}else{
					// Query failed.
					$reportFailure++;
				}
			}else{
				// We do not have sufficient data.
				continue;
			}
		}else{
			// Query execution failed...
			$reportFailure++;
			continue;
		}
	}
	// We need to check for the scrips which are removed from CM.
	// This can be done by checking the date column in filter_adx table.
	$obsoleteScripsQuery = "SELECT symbol, date FROM filter_adx WHERE date < '".date("Y-m-d")."'";
	$obsoleteScrips = mysql_query($obsoleteScripsQuery);
	if ($obsoleteScrips) {
		if (mysql_num_rows($obsoleteScrips)) {
			// There are obsolete records in filter_adx table. Lets process them
			while ($obsoleteScrip = mysql_fetch_array($obsoleteScrips)) {
				// Obsolete records do not mean that scrips are delisted.
				// The symbol of the scrip might have changed.
				// Hence we can not delete these records. 
				// Lets move these records to filter_adx_obsolete table for manual inspection.
				$addObsoleteQuery = "INSERT INTO filter_adx_obsolete VALUES('".$obsoleteScrip['symbol']."', '".$obsoleteScrip['date']."')";
				$addObsolete = mysql_query($addObsoleteQuery);
				if (!$addObsolete) {
					// Some error occured.
					// Update the report variable.
                                        echo $addObsoleteQuery."<br/>";
					$reportFailure++;
					continue;
				}
				// Now we need to delete the scrip from filter_adx table.
				$deleteFromEmaQuery = "DELETE FROM filter_adx WHERE symbol='".$obsoleteScrip['symbol']."'";
				$deletedScrip = mysql_query($deleteFromEmaQuery);
				if ($deletedScrip) {
					// Scrip is succesfully moved to obsolete table.
					// Update the report variable.
					$reportMoved++;
				}else{
					// Update the report variable.
                                        echo $deleteFromEmaQuery."<br/>";
					$reportFailure++;
				}
			}
		}
	}
}else{
	// Unable to get close values.
	echo "Unable to get values from CM table. Can't continue...";
	// Close the connection to the database.
	mysql_close($con);
	return flase;
}
// Script execution successful!

// Update the time in updatestatus table.
$updateTimeQuery = "UPDATE updatestatus SET timestamp= NOW() WHERE tablename='filter_adx'";
$updatedTime = mysql_query($updateTimeQuery);
if (!$updatedTime) {
	// Status update failed!
	echo "Status update in updatestatus table failed for filter_adx.";
}
// Print the report.
echo "<div id='reportcard'>";
echo "<p>Success:&nbsp;<strong>".$reportSuccess."</strong></p>";
echo "<p>New:&nbsp;<strong>".$reportNew."</strong></p>";
echo "<p>Moved:&nbsp;<strong>".$reportMoved."</strong></p>";
echo "<p>Failure:&nbsp;<strong>".$reportFailure."</strong></p>";
echo "</div>";

// Close the connection to the database.
	mysql_close($con);
	return true;
?>