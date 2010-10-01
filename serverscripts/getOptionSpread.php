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
$query = "SELECT SYMBOL, EXPIRY_DT, STRIKE_PR, CLOSE, CONTRACTS, OPEN_INT, OPTION_TYP FROM fobhav WHERE SYMBOL = '";
$query = $query.$_REQUEST['symbol']."' AND EXPIRY_DT LIKE '%";
$query = $query.$_REQUEST['expiry']."' AND (OPTION_TYP LIKE 'C%' OR OPTION_TYP LIKE 'P%') ORDER BY STRIKE_PR, OPTION_TYP";
$result = mysql_query($query);
$i = 0;
while($row = mysql_fetch_array($result)) {
    $expiry = $row['EXPIRY_DT'];
    $scripname = $row['SYMBOL'];
    $data[$i] = array("p" => $row['CLOSE'], "c" => $row['CONTRACTS'], "o" => $row['OPEN_INT'], "s" => $row['STRIKE_PR'], "t" => $row['OPTION_TYP']);
    $i++;
  }
$query1 = "SELECT CLOSE FROM cmbhav WHERE SYMBOL='".$_REQUEST['symbol']."'";
$result1 = mysql_query($query1);
while($row1 = mysql_fetch_array($result1)) {
    $val = $row1['CLOSE'];
  }
}

$response = array("total" => $i, "value" => $val, "positions" => $data, "name" => $scripname, "expiry" => $expiry);
echo json_encode($response);
mysql_free_result($result);
mysql_close($con); 
?>