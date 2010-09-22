<?php
require_once('dba.php');

$result = mysql_query("select derive_symbol, derive_expiry from derivatives where derive_active=1");
$rowCheck = mysql_num_rows($result);
$args = "select SYMBOL, CLOSE from fobhav WHERE (";
if($rowCheck > 0){
while($row = mysql_fetch_array($result)){
    $args = $args."(SYMBOL ='".$row['derive_symbol']."' AND EXPIRY_DT='".date("d-M-Y", strtotime($row['derive_expiry']))."') OR ";
}
$args = $args."0) AND OPTION_TYP='XX'";
mysql_data_seek($result, 0);
}
$result2 = mysql_query($args);
while($row2 = mysql_fetch_array($result2)){
         $querystr = "UPDATE derivatives SET derive_cmp=".$row2['CLOSE']." WHERE derive_symbol='".$row2['SYMBOL']."'";
         mysql_query($querystr);
}
mysql_close($con);
echo 'derivatives table updated successfully!';
?>