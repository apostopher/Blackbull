<?php
/**
* This script is the controller script for Blackbull Portfolio. This script communicates with the database. The primary functions of this script are:
*		STEP 0: Validate and Authenticate. check for sql injection.
                STEP 1: Add a cash entry to database.
                STEP 3: Return json response
*
*	@package	Portfolio
*	@category	Cash
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
    
    /* Read request parameters. */
    $portfolio_id = mysql_real_escape_string($_POST['portfolio_id']);
    $cash_date = mysql_real_escape_string($_POST['cash_date']);
    $cash_notes = mysql_real_escape_string($_POST['cash_notes']);
    $amount = mysql_real_escape_string($_POST['amount']);
    $cash_type = mysql_real_escape_string($_POST['cash_type']);
    
    /*Check whether $amount is a number */
    if(!is_numeric($amount)){
      header('Content-type: application/json');
      if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
      }
      $response = array("status" => '0', "error" => "Cash amount is not a number");
      echo json_encode($response);
      mysql_close($con);
      return;
    }
    /* Add entry to cash table. */
    $cash_updated = false;
    if($amount){
        $cash = $amount*$cash_type;
        $addcashquery = "INSERT INTO portfolio_cash VALUES(null,".$portfolio_id.",'".$cash_date."',".$cash.",'".$cash_notes."')";
        $addcashresult = mysql_query($addcashquery);
        if($addcashresult){
          $cash_id = mysql_insert_id();
          if($cash_id == 0 || $cash_id == false){
            $cash_updated = false;
          }else{
            $cash_updated = true;
            if($cash_type == -1){
              $cash_msg = "Cash is successfully deducted from your portfolio.";
            }else{
              $cash_msg = "Cash is successfully added to your portfolio.";
            }
          }
        }else{
          $cash_updated = false;
        }
    }
    
    /* cash has been added successfully. Return success */
    header('Content-type: application/json');
    if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
    }
    if($cash_updated){
      $response = array("status" => '1', "message" => $cash_msg, "cash_id" => $cash_id, "cash" => $cash);
    }else{
      $response = array("status" => '0', "error" => "Cash update failed");
    }
    echo json_encode($response);
    mysql_close($con);
    return;
?>