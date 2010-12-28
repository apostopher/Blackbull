<?php
/**
* This script is the controller script for Blackbull Portfolio. This script gets LTP from yahoo servers.
*
*	@package	Portfolio
*	@category	getLTP
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

$symbollist = mysql_real_escape_string($_GET['scrips']);

$data = array();
$j = 0;

/* Now we need to fetch data from yahoo */
    $file   = fopen("http://finance.yahoo.com/d/quotes.csv?s=$symbollist&f=sl1c1&ex=.csv","r");
    if($file){
        while($stocks = fgetcsv($file)) {
           $data[$j] = array("symbol" => $stocks[0], "ltp" => $stocks[1], "change" => $stocks[2]);
           $j = $j +1;
        }
        fclose($file);
    }
    header('Content-type: application/json');
    if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
    }
    $response = array("status" => '1', "total" => $j, "data" => $data);
    echo json_encode($response);
    mysql_close($con);
    return;
?>