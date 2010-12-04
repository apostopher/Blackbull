<?php
/**
* This script is the controller script for AXS1. This script communicates with the database. The primary functions of this script are:
*		STEP 0: Validate and Authenticate. check for sql injection.
                STEP 1: Check for existing trade in trade table.
                        STEP 1A: Existing trade is found
                                 STEP 1AA: Add new transaction using the existing trade
                                 STEP 1B: Existing trade is not found
                        STEP 1BA: Create a new trade in trades table
                        STEP 1BB: Add new transaction to newly created trade
                STEP 2: Check for any errors
                STEP 3: Check whether the trade is over
                STEP 4: Check for any errors
                STEP 5: Return json response
*
*	@package	Portfolio
*	@category	Transaction
*	@version	1.0b
*	@author		Rahul Devaskar (apostopher@gmail.com)
*	@copyright	(c) 2010 Blackbull Investment Company
*	@link		http://blackbull.in
*
*	NOTICE: THIS SCRIPT IS A PROPERTY OF BLACKBULL INVESTMENT COMPANY. COPYING, EDMTING OR DELETING THIS SCRIPT IS PROHIBITED WITHOUT THE PERMISSION FROM THE AUTHOR.
*/
    /* Start the session */
    session_start();
    /* Load required libraries */
    require_once('../dba.php');

    /* Authenticate the requester. */
    if(!isset($_SESSION['csrf']) || $_SESSION['csrf'] !== $_POST['csrf']){
        /* We got CSRF attack. */
        header('Content-type: application/json');
        if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
            header("Cache-Control: no-cache");
            header("Pragma: no-cache");
        }
        $response = array("status" => '0', "error" => "CSRF protection.");
        echo json_encode($response);
        mysql_close($con);
        return;
    }
    
    $user_id = mysql_real_escape_string($_POST['user_id']);

    /* Read the request parameters. */
    $trans_scrip = mysql_real_escape_string($_POST['trans_scrip']);
    $trans_type = mysql_real_escape_string($_POST['trans_type']);
    $trans_price = mysql_real_escape_string($_POST['trans_price']);
    $trans_qty = mysql_real_escape_string($_POST['trans_qty']);
    $trans_date = mysql_real_escape_string($_POST['trans_date']);
    $trans_notes = mysql_real_escape_string($_POST['trans_notes']);
    /* Validation check. */
    $validation_error = 0;
    if(is_numeric($trans_price)){
        if($trans_price < 0){
           $validation_error = 1;
        }
    }else{
        $validation_error = 1;
    }
    if(!is_numeric($trans_qty)){
        $validation_error = 1;
    }
    if($trans_type != -1 && $trans_type != 1){
        $validation_error = 1;
    }
    /* Adjust quantity for BUY/SELL */
    $trans_qty = $trans_qty*$trans_type;
      
    if($validation_error){
        /* We got validation errors. */
        header('Content-type: application/json');
        if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
            header("Cache-Control: no-cache");
            header("Pragma: no-cache");
        }
        $response = array("status" => '0', "error" => $validation_error);
        echo json_encode($response);
        mysql_close($con);
        return;
    }
    
    /* Get stops loss if present. */
    $stoploss = mysql_real_escape_string($_POST['stoploss']);

    /* Check whether the trade is still alive. */
    /* Search in the portfolio_trade table for a row with scrip_name as $trans_scrip and end_date is NULL and user_id is $user_id. */
    $trade_query = "SELECT trade_id, trade_qty FROM portfolio_trades WHERE scrip_name='".$trans_scrip."' AND user_id=".$user_id." AND end_date IS NULL LIMIT 1";
    $trade_result = mysql_query($trade_query);
    if($trade_result){
        if(mysql_num_rows($trade_result)){
    	    while($traderow = mysql_fetch_array($trade_result)){
    	    	$trade_id = $traderow['trade_id'];
    	    	$trade_qty = $traderow['trade_qty'];
    	    }
    	}else{
    	    $trade_id = 0;
    	}
    	/* Free the result memory */
    	mysql_free_result($trade_result);
    }else{
        $trade_id = 0;
    }
    /* Start database transaction. @ means supress any errors. */
    @mysql_query("SET autocommit=0");
    @mysql_query("BEGIN");
    
    if($trade_id == 0){
        /* The trade does not exist. We need to create a new trade. */
        /* before we create a new trade we need to check whether we have a valid scrip */
        $yahoofile   = fopen ("http://finance.yahoo.com/d/quotes.csv?s=".$trans_scrip."&f=l1&ex=.csv","r");
        if($yahoofile){
            while($stock = fgetcsv($yahoofile)){
                $stockfound = $stock[0];
                break;
            }
        }else{
            $stockfound = 0;
        }
        /* Close the file. */
        fclose($yahoofile);
        if($stockfound == 0){
            /* We did not find the stock on yahoo */
            /* Rollback transaction */
            @mysql_query("ROLLBACK");
            
            header('Content-type: application/json');
            if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
                header("Cache-Control: no-cache");
                header("Pragma: no-cache");
            }
            $response = array("status" => '0', "error" => "Unable to find scrip on yahoo.");
            echo json_encode($response);
            mysql_close($con);
            return;
        }
        $new_trade_query = "INSERT INTO portfolio_trades VALUES(null,".$user_id.",NOW(),null,'".$trans_scrip."',0)";
        $new_trade_result = mysql_query($new_trade_query);
        if($new_trade_result){
            $trade_id = mysql_insert_id();
            if($trade_id == 0 || $trade_id == false){
                /* New trade was not created. :-( unable to proceed. */
                /* Rollback transaction */
                @mysql_query("ROLLBACK");
                
                header('Content-type: application/json');
		if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
		    header("Cache-Control: no-cache");
		    header("Pragma: no-cache");
		}
		$response = array("status" => '0', "error" => "Unable to create new trade.");
		echo json_encode($response);
		mysql_close($con);
                return;
            }
            $trade_qty = 0;
        }else{
            /* New trade was not created. :-( unable to proceed. */
            /* Rollback transaction */
            @mysql_query("ROLLBACK");
            
            header('Content-type: application/json');
	    if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
	        header("Cache-Control: no-cache");
		header("Pragma: no-cache");
	    }
	    $response = array("status" => '0', "error" => "Unable to create new trade.");
	    echo json_encode($response);
	    mysql_close($con);
            return;
        }
    }

    /* Now we have a valid trade id. We may now add a transaction */
    $new_trans_query = "INSERT INTO portfolio_trans VALUES(null,".$trade_id.",".$trans_price.",".$trans_qty.",'".$trans_date."','".$trans_notes."')";
    $new_trans_result = mysql_query($new_trans_query);
    if($new_trans_result){
    	$trans_id = mysql_insert_id();
    	if($trans_id == 0 || $trans_id == false){
            /* New trans was not created. :-( unable to proceed. */
            /* Rollback transaction */
            @mysql_query("ROLLBACK");
            
            /* send error message */
            header('Content-type: application/json');
	    if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
	        header("Cache-Control: no-cache");
		header("Pragma: no-cache");
            }
            $response = array("status" => '0', "error" => "Unable to create new transaction.");
            echo json_encode($response);
            mysql_close($con);
            return;
        }
        /* Update the trade quantity */
        $update_qty = $trade_qty + $trans_qty;
        if($update_qty){
            $update_qty_query = "UPDATE portfolio_trades SET trade_qty=".$update_qty." WHERE trade_id=".$trade_id;
        }else{
            $update_qty_query = "UPDATE portfolio_trades SET trade_qty=".$update_qty.", end_date=NOW() WHERE trade_id=".$trade_id;
        }
        $update_qty_result = mysql_query($update_qty_query);
        if(!$update_qty_result){
            /* Rollback transaction */
            @mysql_query("ROLLBACK");
          
            /* send error message */
            header('Content-type: application/json');
	    if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
	        header("Cache-Control: no-cache");
                header("Pragma: no-cache");
            }
	    $response = array("status" => '0', "error" => "Unable to update trade quantity.");
	    echo json_encode($response);
	    mysql_close($con);
            return;
        }
    }else{
        /* New trans was not created. :-( unable to proceed. */
        /* Rollback transaction */
        @mysql_query("ROLLBACK");
        
        /* send error message */
        header('Content-type: application/json');
	if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
	    header("Cache-Control: no-cache");
            header("Pragma: no-cache");
        }
	$response = array("status" => '0', "error" => "Unable to create new transaction.");
	echo json_encode($response);
	mysql_close($con);
        return;
    }
    /* Everything is fine. commit the transaction */
    @mysql_query("COMMIT");
    
    /* Check whether we need to update stop loss table */
    if($stoploss){
        /* Check whether same stop loss exists for the trade. */
        $sl_check_query = "SELECT sl_id FROM portfolio_sl WHERE sl=".$stoploss." AND trade_id=".$trade_id;
        $sl_check_result = mysql_query($sl_check_query);
        if($sl_check_result){
            if(mysql_num_rows($sl_check_result) == 0){
                /* Stop loss at this level is not present. add the new stop loss. */
                $new_sl_query = "INSERT INTO portfolio_sl VALUES(,".trade_id.",".$stoploss.", NOW())";
                $new_sl_result = mysql_query($new_sl_query);
                if($new_sl_result){
                    $sl_id = mysql_insert_id();
                    if($sl_id == 0 || $sl_id == false){
		          /* New sl was not created. :-( unable to proceed. */
		          mysql_close($con);
		    }
                }
            }
            /* Free the result memory */
    	    mysql_free_result($sl_check_result);
        }else{
        }
    }

    /* Transaction has been added successfully. Return success */
    header('Content-type: application/json');
    if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
    }
    $response = array("status" => '1', "trade_qty" => $trade_qty);
    echo json_encode($response);
    mysql_close($con);
    return;
?>