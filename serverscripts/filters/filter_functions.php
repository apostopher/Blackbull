<?php
/*	These are the common functions used by all the filters.
	
	Author : Rahul Devaskar
	THIS SCRIPT IS A PROPERTY OF BLACKBULL INVESTMENT COMPANY. COPYING, EDMTING
	OR DELETING THIS SCRIPT IS PROHIBITED WITHOUT THE PERMISSION FROM THE AUTHOR.	
*/

// EMA filter functions.
function filter_ema_getFirstEma($symbol='', $periods=26)
{
	//***************** Validations ************************
	if (trim($symbol) == '') {
		return 0;
	}
	if (!is_int($periods)) {
		return 0;
	}
	if (trim($periods) == '0') {
		return 0;
	}
	// Get close values from CM table for a given period range
	$closequery = "SELECT close FROM cmbhav WHERE symbol='".$symbol."' ORDER BY timestamp DESC LIMIT ".$periods;
	$closevalues = mysql_query($closequery);
	if ($closevalues) {
		if (mysql_num_rows($closevalues) < $periods) {
			// There are insufficient close values to calculate EMA.
			return 0;
		}
		// Set the required variable to initial value.
		$count = $periods;
		$sum = 0;
		// Get the weighted sum of all close values.
		while ($row = mysql_fetch_array($closevalues)) {
			$sum = $sum + $row['close']*$count;
			$count--;
		}
		// Calculate weighted time periods: N*(N+1)/2
		$denom = $periods*($periods + 1)/2;
		// Calculate first EMA value.
		$ema = $sum/$denom;
	}else{
		// Some problem.. need to exit.
		return 0;
	}
	// Calculation is successful :-)
	return $ema;
}

function filter_ema_calculateNewEma($closeValue=0, $lastEma=0, $periods=26)
{
	//***************** Validations ************************
	if ($closeValue == 0 && $lastEma == 0) {
		return 0;
	}
	if (!is_int($periods)) {
		return 0;
	}
	if (trim($periods) == '0') {
		return 0;
	}
	
	// Now we calcute the weight for the given period
	$weight = 2/($periods + 1);
	// Calculate the new EMA
	$newEma = ($closeValue*$weight) + $lastEma*(1-$weight);
	return $newEma;
}

// Stochastics filter functions.
function filter_stochastics_calculate_K($symbol='', $close=0, $periods = 14)
{
	//***************** Validations ************************
	if ($close == 0) {
		return 0;
	}
	if (trim($symbol) == '') {
		return 0;
	}
	// Get highest high and lowest low values from CM table.
	$getHighLowQuery = "SELECT max(high) as highestHigh, min(low) as lowestLow FROM (SELECT low, high FROM `cmbhav` WHERE symbol='".$symbol."' ORDER BY timestamp DESC limit ".$periods.") as T1";
	$getHighLow = mysql_query($getHighLowQuery);
	if ($getHighLow) {
		$highLowValues = mysql_fetch_array($getHighLow);
		// Obtain HH and LL values and calculate %K.
		if ($highLowValues['highestHigh'] > $highLowValues['lowestLow']) {
			$K = ($close - $highLowValues['lowestLow'])/($highLowValues['highestHigh'] - $highLowValues['lowestLow']);
			$perK = $K*100;
			return $perK;
		}else{
			// Can't calculate %K.
			return 0;
		}
	}else{
		// Query failed!
		return 0;
	}
}
?>