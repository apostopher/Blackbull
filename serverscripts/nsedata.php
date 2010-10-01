<?php
//Include the database.
require_once("dba.php");

$query = "SELECT timestamp, close FROM `cmbhav` WHERE symbol=\"NIFTY\" ORDER BY timestamp DESC LIMIT 30";
$result = mysql_query($query);
if($result){
	$i = 0;
	while($row = mysql_fetch_array($result)){
		$date = date("d-M", strtotime($row['timestamp']));
		$data[$i] = array("date" => $date, "value" => $row['close']);
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