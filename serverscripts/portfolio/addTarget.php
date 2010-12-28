<?php
/**
* This script is the controller script for Blackbull Portfolio. This script communicates with the database. The primary functions of this script are:
*		STEP 0: Validate and Authenticate. check for sql injection.
                STEP 1: Check for existing target in target table.
                        STEP 1A: Existing target is found. No need to add same target.
                        STEP 1B: Create a new target in targets table
                STEP 2: Check for any errors
                STEP 3: Return json response
*
*	@package	Portfolio
*	@category	Targets
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
    
    /* Get target and trade_id. */
    $target = mysql_real_escape_string($_POST['target']);
    $trade_id = mysql_real_escape_string($_POST['trade_id']);
    
    /* Check whether we need to update target table */
    $target_updated = false;
    if($target){
        /* Check whether same target exists for the trade. */
        $target_check_query = "SELECT target_id FROM portfolio_targets WHERE target=".$target." AND trade_id=".$trade_id;
        $target_check_result = mysql_query($target_check_query);
        if($target_check_result){
            if(mysql_num_rows($target_check_result) == 0){
                /* Target at this level is not present. add the new target. */
                $new_target_query = "INSERT INTO portfolio_targets VALUES(null,".$trade_id.",".$target.", NOW())";
                $new_target_result = mysql_query($new_target_query);
                if($new_target_result){
                    $target_id = mysql_insert_id();
                    if($target_id == 0 || $target_id == false){
		         /* New target was not created. :-( unable to proceed. */
		         $target_updated = false;
		    }else{
		        $target_updated = true;
		    }
                }else{
                    $target_updated = false;
                }
            }else{
                $target_updated = false;
            }
            /* Free the result memory */
    	    mysql_free_result($target_check_result);
        }else{
            $target_updated = false;
        }
    }
    
    /* target has been added successfully. Return success */
    header('Content-type: application/json');
    if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
    }
    $response = array("status" => '1', "target_updated" => $target_updated);
    echo json_encode($response);
    mysql_close($con);
    return;
?>