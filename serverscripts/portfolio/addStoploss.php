<?php
/**
* This script is the controller script for Blackbull portfolio. This script communicates with the database. The primary functions of this script are:
*		STEP 0: Validate and Authenticate. check for sql injection.
                STEP 1: Check for existing stop loss in sl table.
                        STEP 1A: Existing stop loss is found. No need to add same stop loss.
                        STEP 1B: Create a new stop loss in stop loss table
                STEP 2: Check for any errors
                STEP 3: Return json response
*
*	@package	Portfolio
*	@category	Stop lass
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
    
    /* Get stop loss and trade_id. */
    $stoploss = mysql_real_escape_string($_POST['stoploss']);
    $trade_id = mysql_real_escape_string($_POST['trade_id']);
    
    /* Check whether we need to update stop loss table */
    $sl_updated = false;
    if($stoploss){
        /* Check whether same stop loss exists for the trade. */
        $sl_check_query = "SELECT sl_id FROM portfolio_sl WHERE stoploss=".$stoploss." AND trade_id=".$trade_id;
        $sl_check_result = mysql_query($sl_check_query);
        if($sl_check_result){
            if(mysql_num_rows($sl_check_result) == 0){
                /* Stop loss at this level is not present. add the new stop loss. */
                $new_sl_query = "INSERT INTO portfolio_sl VALUES(null,".$trade_id.",".$stoploss.", NOW())";
                $new_sl_result = mysql_query($new_sl_query);
                if($new_sl_result){
                    $sl_id = mysql_insert_id();
                    if($sl_id == 0 || $sl_id == false){
		         /* New sl was not created. :-( unable to proceed. */
		         $sl_updated = false;
		    }else{
		        $sl_updated = true;
		    }
                }else{
                    $sl_updated = false;
                }
            }else{
                $sl_updated = false;
            }
            /* Free the result memory */
    	    mysql_free_result($sl_check_result);
        }else{
            $sl_updated = false;
        }
    }
    
    /* Stop loss has been added successfully. Return success */
    header('Content-type: application/json');
    if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
    }
    $response = array("status" => '1', "sl_updated" => $sl_updated);
    echo json_encode($response);
    mysql_close($con);
    return;
?>