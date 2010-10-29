<?php
//Include the database.
require_once("dba.php");

$query = "SELECT fii,dii,fiidii_date,close FROM fiidii, cmbhav WHERE symbol=\"NIFTY\" AND fiidii_date=timestamp ORDER BY fiidii_date DESC LIMIT 30";
$result = mysql_query($query);
if($result){
	$i = 0;
	while($row = mysql_fetch_array($result)){
		$fii = round($row['fii']/1000, 2);
		$dii = round($row['dii']/1000, 2);
		$total = round(($row['fii'] + $row['dii'])/1000, 2);
		$date = date("d-M", strtotime($row['fiidii_date']));
		$data[$i] = array("date" => $date, "value" => $total, "fii" => $fii, "dii" => $dii, "closeval" => $row['close']);
		$i++;
	}
	$daily_move = "SELECT fiidii_date, fiibuy, fiisell ,diibuy ,diisell FROM fiidii ORDER BY fiidii_date DESC LIMIT 1";
	$dailyresult = mysql_query($daily_move);
	$dailyrow = mysql_fetch_array($dailyresult);
	$response = array("total" => $i, "data" => $data, "fiibuy" => $dailyrow['fiibuy'], "fiisell" => $dailyrow['fiisell'], "diibuy" => $dailyrow['diibuy'], "diisell" => $dailyrow['diisell'], "today" => date("j F Y", strtotime($dailyrow['fiidii_date'])));
	header('Content-type: application/json');
	if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
  		header("Cache-Control: no-cache");
  		header("Pragma: no-cache");
 	}
	echo json_encode($response);
	mysql_close($con);
}else{
	$response = array("total" => 0);
	header('Content-type: application/json');
	if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
  		header("Cache-Control: no-cache");
  		header("Pragma: no-cache");
 	}
	echo json_encode($response);
	mysql_close($con);
}
?>