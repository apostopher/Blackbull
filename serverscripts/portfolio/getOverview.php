<?php
/**
* This script is the controller script for Blackbull Portfolio. This script gets the overview of user's trade.
*
*	@package	Portfolio
*	@category	overview trade
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

$user_id = mysql_real_escape_string($_GET['uuid']);
$pf_id = mysql_real_escape_string($_GET['pfid']);
$tr_id = mysql_real_escape_string($_GET['trid']);

/* Before I touch the database I first need to check the request parameters.

   TEST1: request specified user_id MUST match session specified user_id.
   TEST2: request specified pf_id MUST match session specified pf_id.
   TEST3: pf_id MUST belong to correct user.
   TEST4: trade must belong to correct portfolio.
   
*/

/* set the foundpage flag */
$pagefound = true;

/*TEST1 */
if(intval($_SESSION['user_id']) != intval($user_id)){
  $pagefound = false;
}

/*TEST2 */
if(intval($_SESSION['portfolio_id']) != intval($pf_id)){
  $pagefound = false;
}

if($pagefound == false){
  header('Content-type: application/json');
  if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
      header("Cache-Control: no-cache");
      header("Pragma: no-cache");
  }
  $response = array("pagefound" => '0', "status" => '0');
  echo json_encode($response);
  mysql_close($con);
  return;
}

/*TEST3 */
$checkfolioquery = "SELECT * FROM portfolio_portfolios WHERE portfolio_id=".$pf_id." AND user_id=".$user_id;
$chechfolioresult = mysql_query($checkfolioquery);
if($chechfolioresult){
  if(mysql_num_rows($chechfolioresult)){
    $pagefound = true;
  }else{
    $pagefound = false;
  }
  /* Free the result memory */
  mysql_free_result($chechfolioresult);
}else{
  $pagefound = false;
}

if($pagefound == false){
  header('Content-type: application/json');
  if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
      header("Cache-Control: no-cache");
      header("Pragma: no-cache");
  }
  $response = array("pagefound" => '0', "status" => '0');
  echo json_encode($response);
  mysql_close($con);
  return;
}

/*TEST4 */
$checktradequery = "SELECT portfolio_scrips.scrip_id as scrip_id, scrip_name, scrip_symbol, exg_symbol, trade_qty, trade_avg_buy FROM portfolio_trades, portfolio_scrips WHERE portfolio_id=".$pf_id." AND trade_id=".$tr_id." AND portfolio_trades.scrip_id = portfolio_scrips.scrip_id";
$chechtraderesult = mysql_query($checktradequery);
if($chechtraderesult){
  if(mysql_num_rows($chechtraderesult)){
    $traderow = mysql_fetch_array($chechtraderesult);
    $scrip_name = $traderow['scrip_name'];
    $scrip_id = $traderow['scrip_id'];
    $trade_avg_buy = $traderow['trade_avg_buy'];
    $trade_qty = $traderow['trade_qty'];
    $trade_symbol = $traderow['scrip_symbol'];
    $trade_exsymbol = $traderow['exg_symbol'];
    $pagefound = true;
  }else{
    $pagefound = false;
  }
  /* Free the result memory */
  mysql_free_result($chechtraderesult);
}else{
  $pagefound = false;
}

if($pagefound == false){
  header('Content-type: application/json');
  if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
      header("Cache-Control: no-cache");
      header("Pragma: no-cache");
  }
  $response = array("pagefound" => '0', "status" => '0');
  echo json_encode($response);
  mysql_close($con);
  return;
}

/* Everything is OK start gathering data
   DATA1: all the transactions
   DATA2: all the targets
   DATA3: all the stop losses
   DATA4: all the close prices for last month
   DATA5: all the fundamental data from yahoo
*/

/*DATA1*/
$trans = array();
$transcount = 0;
$tradetransquery = "SELECT * FROM portfolio_trans WHERE trade_id=".$tr_id." ORDER BY trans_date DESC";
$tradetransresult = mysql_query($tradetransquery);
if($tradetransresult){
  if(mysql_num_rows($tradetransresult) > 0){
    while($transrow = mysql_fetch_array($tradetransresult)) {
      if($transrow['trans_qty'] < 0){
        $trans_qty = $transrow['trans_qty']*(-1);
        $trans_type = -1;
      }else{
        $trans_qty = $transrow['trans_qty'];
        $trans_type = 1;
      }
      $transdate = date("j-M-Y", strtotime($transrow['trans_date']));
      $transjdate = date("F j, Y", strtotime($transrow['trans_date']));
      $trans[$transcount] = array("trans_price" => $transrow['trans_price'], "trans_date" => $transdate, "trans_jdate" =>$transjdate, "trans_qty" => $trans_qty, "trans_type" => $trans_type);
      $transcount = $transcount +1;
    }
  }
  /* Free the result memory */
  mysql_free_result($tradetransresult);
}

/*DATA2*/
$targets = array();
$targetscount = 0;
$tradetargetsquery = "SELECT * FROM portfolio_targets WHERE trade_id=".$tr_id." ORDER BY target ASC";
$tradetargetsresult = mysql_query($tradetargetsquery);
if($tradetargetsresult){
  if(mysql_num_rows($tradetargetsresult) > 0){
    while($targetrow = mysql_fetch_array($tradetargetsresult)) {
      $targetdate = date("d-M-Y", strtotime($targetrow['target_date']));
      $targets[$targetscount] = array("target" => $targetrow['target'], "target_date" => $targetdate);
      $targetscount = $targetscount +1;
    }
  }
  /* Free the result memory */
  mysql_free_result($tradetargetsresult);
}

/*DATA3*/
$sls = array();
$slscount = 0;
$slsquery = "SELECT * FROM portfolio_sl WHERE trade_id=".$tr_id." ORDER BY stoploss DESC";
$slsresult = mysql_query($slsquery);
if($slsresult){
  if(mysql_num_rows($slsresult) > 0){
    while($slrow = mysql_fetch_array($slsresult)) {
      $sldate = date("d-M-Y", strtotime($slrow['sl_date']));
      $sls[$slscount] = array("stoploss" => $slrow['stoploss'], "sl_date" => $sldate);
      $slscount = $slscount +1;
    }
  }
  /* Free the result memory */
  mysql_free_result($slsresult);
}

/* DATA4 */
/* Get the CLOSE from the bhavcopy tables
 * First we need to get the correct exchange 
 */
$closes = array();
$closecount = 0;
$chart = true;
if(strstr($trade_symbol,".NS")){
  /* Scrip belongs to NSE */
  $tablename = "cmbhav";
}
if(strstr($trade_symbol,".BO")){
  /* Scrip belongs to BSE */
  $tablename = "bobhav";
  $chart = false;
}

if($chart){
$closequery = "SELECT CLOSE, TIMESTAMP FROM ".$tablename." WHERE SYMBOL='".$trade_exsymbol."' ORDER BY TIMESTAMP DESC LIMIT 30";
$closeresult = mysql_query($closequery);
if($closeresult){
  if(mysql_num_rows($closeresult) > 0){
    while($closerow = mysql_fetch_array($closeresult)) {
      $closes[$closecount] = array("c" => $closerow['CLOSE'], "d" => date("j-M-Y", strtotime($closerow['TIMESTAMP'])), "jd" => date("F j, Y", strtotime($closerow['TIMESTAMP'])), "xd" => date("j-M", strtotime($closerow['TIMESTAMP'])));
      $closecount = $closecount +1;
    }
  }
}
}
/* DATA5 */
/* Get the fundamental analysis data from yahoo.
j 52-week low
k 52-week high
e earning/share
r P/E ratio
y dividend
e7 EPS estimate this year
e8 EPS estimate next year
e9 EPS estimate next quarter
f6 float shares
l1 last trade
c change and per change
*/

$yahoofile   = fopen("http://download.finance.yahoo.com/d/quotes.csv?s=".$trade_symbol."&f=l1d1c1ohg&e=.csv","r");
if($yahoofile){
  while($stock = fgetcsv($yahoofile)){
    $lasttrade = $stock[0];
    $datev = $stock[1];
    $valchange = $stock[2];
    $openv = $stock[3];
    $highv = $stock[4];
    $lowv = $stock[5];
    break;
  }
}
/* Close the file. */
fclose($yahoofile);
            
header('Content-type: application/json');
if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
    header("Cache-Control: no-cache");
    header("Pragma: no-cache");
}
$response = array("pagefound" => '1', "trade_symbol" => $trade_symbol, "trade_name" => $scrip_name, "avg_buy" => $trade_avg_buy, "totalqty" => $trade_qty, "trade_symbol" => $trade_symbol,
                  "transtotal" => $transcount, "trans" => $trans, "targetstotal" => $targetscount, "targets" => $targets,
                  "sltotal" => $slscount, "sls" => $sls, "closetotal" => $closecount, "close" => $closes, "last" => $lasttrade, "change" => $valchange,
                  "open" => $openv, "high" => $highv, "low" => $lowv, "date" => $datev);
echo json_encode($response);
mysql_close($con);
return;
?>