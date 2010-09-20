<?php
// Load the database script
require_once('dba.php');

// Get the type paramter in the request
$type = $_GET['type'];

// Get the type of portfolio
if(!$type){
	$type = "trading";
}

// Fetch the data from database
$result = mysql_query("select name, scrip, `trigger`, DATEDIFF(NOW(), date) as days from $type where archive=0 order by date desc");
$rowCheck = mysql_num_rows($result);

// Fetch the yahoo scrips
if($rowCheck > 0){
while($row = mysql_fetch_array($result)){
	$args = $args.$row['scrip']."+";
}
mysql_data_seek($result, 0);
}else{
	$response = array("total" => '0', "positions" => '');
	header('Content-type: application/json');
	echo json_encode($response);
	mysql_free_result($result);
	mysql_close($con);
	return;	
}

// Get data from yahoo.
$file   = fopen ("http://finance.yahoo.com/d/quotes.csv?s=$args&f=l1&ex=.csv","r");
$data   = array();
$i = 0;
$days = 0;
$profit = 0;
// Create the data array
if ($file) {
	while($stocks = fgetcsv($file)) {
		$row = mysql_fetch_array($result);
		$scripprofit = round((($stocks[0] - $row['trigger'])/$row['trigger'])*100,2);
		$data[$i] = array("name" => ucwords(strtolower($row['name'])), "profit" => $scripprofit, "scrip" => $row['scrip']);
		$days = $days + $row['days'];
		$profit = $profit + $scripprofit;
		$i++;
	}
	fclose($file);
}
// Create response array
$response = array("total" => $i, "days" => $days/$i, "profit" => $profit, "positions" => $data);

// Create JSON response
header('Content-type: application/json');
echo json_encode($response);
mysql_free_result($result);
mysql_close($con);
?>