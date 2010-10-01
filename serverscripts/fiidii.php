<?php
//Include the database.
require_once("dba.php");

$query = "SELECT fii,dii,fiidii_date,close FROM fiidii, cmbhav WHERE symbol=\"NIFTY\" AND fiidii_date=timestamp ORDER BY fiidii_date DESC LIMIT 30";
$result = mysql_query($query);
if($result){
	$i = 0;
	while($row = mysql_fetch_array($result)){
		$total = round(($row['fii'] + $row['dii'])/1000, 1);
		$date = date("d-M", strtotime($row['fiidii_date']));
		$data[$i] = array("date" => $date, "value" => $total, "closeval" => $row['close']);
		$i++;
	}
	$response = array("total" => $i, "data" => $data);
	header('Content-type: application/json');
	echo json_encode($response);
	mysql_close($con);
}else{
	$response = array("total" => 0);
	header('Content-type: application/json');
	echo json_encode($response);
	mysql_close($con);
}
?>