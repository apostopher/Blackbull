<?php
// Start session to store keys
session_start();
// Include the required scripts
require_once("../dba.php");

// We need to authenticate the user now
$folioname = mysql_real_escape_string($_POST['portfolio']);
$remember = mysql_real_escape_string($_POST['remember']);

// Check whether user has portfolio
$portfolio = 0;
$portresult = mysql_query("SELECT portfolio_id FROM portfolio_portfolios WHERE user_id=".$_SESSION['user_id']);

if($portresult){
  if(mysql_num_rows($portresult)){
    $portrow = mysql_fetch_array($portresult);
    $_SESSION['portfolio_id'] = $portrow['portfolio_id'];
    $portfolio = 1;
  }else{
    // User does not have portfolio.
    $portfolio = 0;
  }
}else{
  // User does not have portfolio.
  $portfolio = 0;
}
if($portfolio == 0){
  // Create a new portfolio
  $new_query = "INSERT into portfolio_portfolios VALUES(null,".$_SESSION['user_id'].",'".$folioname."','')";
  $new_result = mysql_query($new_query);
  if($new_result){
    $portfolio_id = mysql_insert_id();
    if($portfolio_id == 0 || $portfolio_id == false){
      $portfolio_id = 0;
    }
    $_SESSION['portfolio_id'] = $portfolio_id;
    if($remember == '1'){
      setcookie("portid", $_SESSION['portfolio_id'], time()+60*60*24*100, "/","blackbull.in");
    }
    // Create the JSON response
    $response = array("success"=>$portfolio_id);
    header('Content-type: application/json');
    if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
      header("Cache-Control: no-cache");
      header("Pragma: no-cache");
    }
    echo json_encode($response);
  }else{
    $response = array("success"=>'0');
    header('Content-type: application/json');
    if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
      header("Cache-Control: no-cache");
      header("Pragma: no-cache");
    }
    echo json_encode($response);
  }
  	
}else{
  // Portfolio Exists
  $_SESSION['portfolio_id'] = $portrow['portfolio_id'];
  if($remember == '1'){
      setcookie("portid", $_SESSION['portfolio_id'], time()+60*60*24*100, "/","blackbull.in");
    }
  $response = array("success"=>$portrow['portfolio_id']);
  header('Content-type: application/json');
  if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
    header("Cache-Control: no-cache");
    header("Pragma: no-cache");
  }
  echo json_encode($response);	
}
mysql_close($con);
?>