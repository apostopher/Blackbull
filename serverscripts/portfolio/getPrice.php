<?php
/**
* This script is the controller script for Blackbull Portfolio. This script communicates with the yahoo server.
*
*	@package	Portfolio
*	@category	Yahooprice
*	@version	1.0b
*	@author		Rahul Devaskar (apostopher@gmail.com)
*	@copyright	(c) 2010 Blackbull Investment Company
*	@link		http://blackbull.in
*
*	NOTICE: THIS SCRIPT IS A PROPERTY OF BLACKBULL INVESTMENT COMPANY. COPYING, EDMTING OR DELETING THIS SCRIPT IS PROHIBITED WITHOUT THE PERMISSION FROM THE AUTHOR.
*/

$trans_scrip = urlencode($_GET['scrip']);
/* Connect to yahoo server. */
$yahoofile   = fopen ("http://finance.yahoo.com/d/quotes.csv?s=".$trans_scrip."&f=l1&ex=.csv","r");
        if($yahoofile){
            while($stock = fgetcsv($yahoofile)){
                $stockvalue = $stock[0];
                break;
            }
        }else{
            $stockvalue = 0;
        }
        /* Close the file. */
        fclose($yahoofile);
        
        header('Content-type: application/json');
        if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
            header("Cache-Control: no-cache");
            header("Pragma: no-cache");
        }
        $response = array("value" => $stockvalue);
        echo json_encode($response);
?>