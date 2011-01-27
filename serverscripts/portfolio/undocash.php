<?php
/**
* This script will undo last cash transaction.
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
    
    /* Read request parameters. */
    $cash_id = trim(mysql_real_escape_string($_POST['cash_id']));
    
    /* Check whether the input is a number */
    if(!is_numeric($cash_id)){
      header('Content-type: application/json');
      if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
      }
      $response = array("status" => '0', "error" => "Cash id is invalid");
      echo json_encode($response);
      mysql_close($con);
      return;
    }
    
    /* get portfolio_id, user_id from session */
    $portfolio_id = $_SESSION['portfolio_id'];
    $user_id = $_SESSION['user_id'];
    
    /* Now we obtain the cash from cash table */
    $cash_query = "SELECT cash FROM portfolio_cash, portfolio_portfolios WHERE portfolio_cash.portfolio_id = portfolio_portfolios.portfolio_id 
                   AND portfolio_portfolios.user_id =".$user_id." AND cash_id=".$cash_id;
    $cash_results = mysql_query($cash_query);
    if($cash_results){
      if(mysql_num_rows($cash_results)){
        /* This cash entry belongs to correct user and correct portfolio */
        /* Fetch the amount */
        $cashrow = mysql_fetch_array($cash_results);
        $amount = $cashrow['cash']; 
      }else{
        header('Content-type: application/json');
        if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
          header("Cache-Control: no-cache");
          header("Pragma: no-cache");
        }
        $response = array("status" => '0', "error" => "Unauthorized user.");
        echo json_encode($response);
        mysql_close($con);
        return;
      }
    }else{
      header('Content-type: application/json');
      if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
      }
      $response = array("status" => '0', "error" => "undo failed.");
      echo json_encode($response);
      mysql_close($con);
      return;
    }
    
    $delete_query = "DELETE FROM portfolio_cash WHERE cash_id=".$cash_id." AND portfolio_id=".$portfolio_id;
    $delete_result = mysql_query($delete_query);
    if($delete_result){
      if(mysql_affected_rows() != 1){
        /* delete failed */
        header('Content-type: application/json');
        if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
          header("Cache-Control: no-cache");
          header("Pragma: no-cache");
        }
        $response = array("status" => '0', "error" => "undo failed.");
        echo json_encode($response);
        mysql_close($con);
        return;
      }
    }else{
      header('Content-type: application/json');
      if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
      }
      $response = array("status" => '0', "error" => "undo failed.");
      echo json_encode($response);
      mysql_close($con);
      return;
    }
    /* Everything went well */
    header('Content-type: application/json');
    if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
      header("Cache-Control: no-cache");
      header("Pragma: no-cache");
    }
    $response = array("status" => '1', "cash" => $amount);
    echo json_encode($response);
    mysql_close($con);
    return;
    
?>