<?php
/**
* This script will undo last trade transaction.
*
*	@package	Portfolio
*	@category	Transactions
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
    $trans_id = trim(mysql_real_escape_string($_POST['trans_id']));
    $trade_id = trim(mysql_real_escape_string($_POST['trade_id']));
    $old_avg = trim(mysql_real_escape_string($_POST['old_avg']));
    $old_qty = trim(mysql_real_escape_string($_POST['old_qty']));
    
    /* Check whether the input is a number */
    if(!is_numeric($trans_id) || !is_numeric($trade_id) || !is_numeric($old_qty)){
      header('Content-type: application/json');
      if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
      }
      $response = array("status" => '0', "error" => "Trans id is invalid");
      echo json_encode($response);
      mysql_close($con);
      return;
    }
    
    /* get portfolio_id, user_id from session */
    $portfolio_id = $_SESSION['portfolio_id'];
    $user_id = $_SESSION['user_id'];
    
    /* Now we obtain the trans from trans table */
    $trans_query = "SELECT trans_price, trans_qty, portfolio_trans.trade_id FROM portfolio_trans, portfolio_trades, portfolio_portfolios 
    WHERE portfolio_trans.trade_id = portfolio_trades.trade_id AND portfolio_trades.portfolio_id = portfolio_portfolios.portfolio_id 
    AND portfolio_portfolios.user_id=".$user_id." AND trans_id=".$trans_id;
    $trans_results = mysql_query($trans_query);
    if($trans_results){
      if(mysql_num_rows($trans_results)){
        /* This trans entry belongs to correct user and correct portfolio */
        /* Fetch the values */
        $transrow = mysql_fetch_array($trans_results);
        $trans_price = $transrow['trans_price'];
        $trans_qty = $transrow['trans_qty'];
        $trans_trade = $transrow['trade_id'];
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
      $response = array("status" => '0', "error" => "undo failed1.");
      echo json_encode($response);
      mysql_close($con);
      return;
    }
    
    /* Start database transaction. @ means supress any errors. */
    @mysql_query("SET autocommit=0");
    @mysql_query("BEGIN");
    
    /* if it's a new trade then delete the complete trade. if its a new trans then delete only the trans */
    if($trade_id != 0){
      /* This is a new trade */
      $delete_trade_query = "DELETE FROM portfolio_trades WHERE trade_id=".$trade_id;
      $delete_trade_result = mysql_query($delete_trade_query);
      if($delete_trade_result){
        if(mysql_affected_rows() != 1){
         /* delete failed */
         header('Content-type: application/json');
         if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
           header("Cache-Control: no-cache");
           header("Pragma: no-cache");
         }
         $response = array("status" => '0', "error" => "undo failed2.");
         echo json_encode($response);
         mysql_close($con);
         return;
        }
      }
    }else{
      /* This is another trans in a trade. just delete the trans and update average buy and quantity */
      $delete_trans_query = "DELETE FROM portfolio_trans WHERE trans_id=".$trans_id;
      $delete_trans_result = mysql_query($delete_trans_query);
      if($delete_trans_result){
        if(mysql_affected_rows() != 1){
         /* delete failed */
         header('Content-type: application/json');
         if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
           header("Cache-Control: no-cache");
           header("Pragma: no-cache");
         }
         $response = array("status" => '0', "error" => "undo failed3.");
         echo json_encode($response);
         mysql_close($con);
         return;
        }
      }
      /* Update the average buy and quantity columns */
      $update_trade_query = "UPDATE portfolio_trades SET trade_qty=".$old_qty.", trade_avg_buy=".$old_avg." WHERE trade_id=".$trans_trade;
      $update_trade_result = mysql_query($update_trade_query);
      if($update_trade_result){
        if(mysql_affected_rows() != 1){
         /* update failed */
         @mysql_query("ROLLBACK");
         @mysql_query("SET autocommit=1");
         header('Content-type: application/json');
         if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
           header("Cache-Control: no-cache");
           header("Pragma: no-cache");
         }
         $response = array("status" => '0', "error" => "undo failed4.");
         echo json_encode($response);
         mysql_close($con);
         return;
        }
      }
    }
    
    /* Everything went well */
    /* commit the transaction */
    @mysql_query("COMMIT");
    
    header('Content-type: application/json');
    if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
      header("Cache-Control: no-cache");
      header("Pragma: no-cache");
    }
    $response = array("status" => '1', "price" => $trans_price, "qty" => $trans_qty);
    echo json_encode($response);
    mysql_close($con);
    return;
    
?>