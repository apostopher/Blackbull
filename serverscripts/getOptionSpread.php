<?php
require_once('dba.php');
if(isset($_REQUEST['autosuggest'])){
$query = "SELECT DISTINCT SYMBOL FROM fobhav";
$result = mysql_query($query);
$i = 0;
while($row = mysql_fetch_array($result)) {
    $data[$i] = array("as" => $row['SYMBOL']);
    $i++;
  }
  $val=0;
}else{
$query = "SELECT SYMBOL, EXPIRY_DT, STRIKE_PR, CLOSE, CONTRACTS, OPEN_INT, OPTION_TYP, TIMESTAMP FROM fobhav WHERE SYMBOL = '";
$query = $query.$_REQUEST['symbol']."' AND EXPIRY_DT LIKE '%";
$query = $query.$_REQUEST['expiry']."' AND (OPTION_TYP LIKE 'C%' OR OPTION_TYP LIKE 'P%') ORDER BY STRIKE_PR, OPTION_TYP";
$result = mysql_query($query);
$i = 0;
while($row = mysql_fetch_array($result)) {
    if($i == 0){
    	$expiry = $row['EXPIRY_DT'];
    	$scripname = $row['SYMBOL'];
    	$timestamp = $row['TIMESTAMP'];
    }
    $data[$i] = array("p" => $row['CLOSE'], "c" => $row['CONTRACTS'], "o" => $row['OPEN_INT'], "s" => $row['STRIKE_PR'], "t" => $row['OPTION_TYP']);
    $i++;
  }
$query1 = "SELECT CLOSE FROM cmbhav WHERE SYMBOL='".$_REQUEST['symbol']."'";
$result1 = mysql_query($query1);
while($row1 = mysql_fetch_array($result1)) {
    $val = $row1['CLOSE'];
  }
}

$query2 = "SELECT DISTINCT EXPIRY_DT FROM `fobhav` WHERE SYMBOL = 'NIFTY' AND INSTRUMENT = 'OPTIDX' ORDER BY EXPIRY_DT ASC";
$result2 = mysql_query($query2);
$j = 0;
while($row2 = mysql_fetch_array($result2)) {
	$exipries[$j] = $row2['EXPIRY_DT'];
	$j++;
}
$response = array("total" => $i, "value" => $val, "positions" => $data, "name" => $scripname, "expiry" => $expiry, "date" => $timestamp);
header('Content-type: application/json');
if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
}
echo json_encode($response);
mysql_free_result($result);
mysql_close($con); 
?>