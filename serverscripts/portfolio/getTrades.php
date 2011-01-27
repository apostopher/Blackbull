<?php
/**
* This script is the controller script for Blackbull Portfolio. This script gets the portfolio positions.
*
*	@package	Portfolio
*	@category	getTrades
*	@version	1.0b
*	@author		Rahul Devaskar (apostopher@gmail.com)
*	@copyright	(c) 2010 Blackbull Investment Company
*	@link		http://blackbull.in
*
*	NOTICE: THIS SCRIPT IS A PROPERTY OF BLACKBULL INVESTMENT COMPANY. COPYING, EDMTING OR DELETING THIS SCRIPT IS PROHIBITED WITHOUT THE PERMISSION FROM THE AUTHOR.
*/

/* start the session */
session_start();

/* Load required libraries */
require_once('../dba.php');

/* Get the user id. */
$user_id = mysql_real_escape_string($_GET['user']);

/* Check who wants this information */
if($_SESSION['user_id'] != $user_id){
   /* Somebody else wants someone else's data. not good. */
   header('Content-type: application/json');
    if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
    }
    $response = array("status" => '0', "error" => "Not allowed.");
    echo json_encode($response);
    mysql_close($con);
    return;
}

/* Get the portfolio id. */
$portfolio_id = mysql_real_escape_string($_GET['portfolio']);

$i = 0;
$data = array();
$cash = 0;

/* Get portfolio cash */
$cash_query = "SELECT SUM(cash) as cash from portfolio_cash WHERE portfolio_id=".$portfolio_id." GROUP BY portfolio_id";
$cash_result = mysql_query($cash_query);
if($cash_result){
    if(mysql_num_rows($cash_result) > 0){
      $cashrow = mysql_fetch_array($cash_result);
      $cash = $cashrow['cash'];
    }
    /* Free the result memory */
    mysql_free_result($cash_result);
}else{
    header('Content-type: application/json');
    if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
    }
    $response = array("status" => '0', "error" => "Cash SQL failed.");
    echo json_encode($response);
    mysql_close($con);
    return;
}

$get_trades_query = "SELECT trade_id, scrip_symbol, scrip_name, trade_qty, trade_avg_buy FROM portfolio_trades, portfolio_scrips WHERE portfolio_id=".$portfolio_id." AND end_date IS NULL AND portfolio_trades.scrip_id = portfolio_scrips.scrip_id";
$trade_results = mysql_query($get_trades_query);
if($trade_results){
    if(mysql_num_rows($trade_results) > 0){
        $symbollist ="";
        while($row = mysql_fetch_array($trade_results)) {
            $data[$i] = array("trade_id" => $row['trade_id'], "scrip_symbol" => $row['scrip_symbol'], "scrip_name" => $row['scrip_name'], "trade_qty" => $row['trade_qty'], "trade_avg_buy" => $row['trade_avg_buy']);
            $i = $i +1;
            $symbollist = $symbollist.$row['scrip_symbol']."+";
        }
        
        /* Now we need to fetch data from yahoo */
        $file   = fopen("http://finance.yahoo.com/d/quotes.csv?s=$symbollist&f=l1c1&ex=.csv","r");
        if($file){
            $j = 0;
            while($stocks = fgetcsv($file)) {
               $profitloss = $stocks[0] - $data[$j]["trade_avg_buy"];
               array_push($data[$j],$stocks[0], $stocks[1], $profitloss*$data[$j]["trade_qty"], $profitloss/$data[$j]["trade_avg_buy"]);
               $j = $j +1;
            }
            fclose($file);
        }
    }
    /* Free the result memory */
    mysql_free_result($trade_results);
}else{
    header('Content-type: application/json');
    if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
    }
    $response = array("status" => '0', "error" => "SQL failed.");
    echo json_encode($response);
    mysql_close($con);
    return;
}

header('Content-type: application/json');
if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
    header("Cache-Control: no-cache");
    header("Pragma: no-cache");
}
$response = array("status" => '1', "total" => $i, "data" => $data, "cash" => $cash);
echo json_encode($response);
mysql_close($con);
return;

?>