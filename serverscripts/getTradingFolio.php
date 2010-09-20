<?php
require_once('dba.php');
$scrip = $_GET['scrip'];
$result = mysql_query("select * from trading where archive=0 AND scrip='".$scrip."' order by date desc");
$rowCheck = mysql_num_rows($result);

if($rowCheck > 0){
	while($row = mysql_fetch_array($result)){
		$args = $args.$row['scrip']."+";
	}
	mysql_data_seek($result, 0);
}

$file   = fopen ("http://finance.yahoo.com/d/quotes.csv?s=$args&f=l1&ex=.csv","r");
$response = "<table><tbody>";
if ($file) {
	$stocks = fgetcsv($file);
	$row = mysql_fetch_array($result);
	$response = $response."<tr><td class=\"legend\">Date of purchase</td><td>".date("j F Y",strtotime($row['date']))."</td></tr>";
	$response = $response."<tr><td class=\"legend\">Purchase price</td><td>".$row['trigger']." Rs.</td></tr>";
	$response = $response."<tr><td class=\"legend\">Stop loss level</td><td>".$row['sl']." Rs.</td></tr>";
	$response = $response."<tr><td class=\"legend\">First target</td><td>".$row['t1']." Rs.</td></tr>";
	$response = $response."<tr><td class=\"legend\">Second target</td><td>".$row['t1']." Rs.</td></tr>";
	$response = $response."<tr><td class=\"legend\">Current market price</td><td>".$stocks[0]." Rs.</td></tr>";
	$profit = round((($stocks[0] - $row['trigger'])/$row['trigger'])*100,2);
	if($profit <0){
		$response = $response."<tr><td class=\"legend\">Current % returns</td><td class=\"red\">".$profit."%</td></tr>";
	}else{
		$response = $response."<tr><td class=\"legend\">Current % returns</td><td class=\"green\">".$profit."%</td></tr>";
	}
	$response = $response."<tr><td class=\"legend\">Realized returns</td><td>".$row['realized']."</td></tr>";
	$response = $response."</tbody></table>";
	//$data[$i] = "report" => $row['report'], "comment" => $row['comment']);
	fclose($file);
}
header('Content-type: text/html');
echo $response;
mysql_free_result($result);
mysql_close($con);
?>