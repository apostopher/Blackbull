<?php
require_once('serverscripts/dba.php');
$datearr = explode(':',date("G:i"));
if($datearr[0] >= 9 && $datearr[0] < 16){
  if($datearr[1] > 40){
     $isClosed = 1;
  }else{
     $isClosed = 0;
  }
}else{
 $isClosed = 1;
}
if($isClosed == 0){
$error = 0;
$scrips = array("ABB","ACC","AMBUJACEM","AXISBANK","BHEL","BPCL","BHARTIARTL","CAIRN","CIPLA","DLF","GAIL","HCLTECH","HDFCBANK","HEROHONDA","HINDALCO","HINDUNILVR","HDFC","ITC","ICICIBANK","IDEA","INFOSYSTCH","IDFC","JPASSOCIAT","JINDALSTEL","KOTAKBANK","LT","M%26M","MARUTI","NTPC","ONGC","POWERGRID","PNB","RANBAXY","RELCAPITAL","RCOM","RELIANCE","RELINFRA","RPOWER","SIEMENS","SBIN","SAIL","STER","SUNPHARMA","SUZLON","TCS","TATAMOTORS","TATAPOWER","TATASTEEL","UNITECH","WIPRO");

$values = "INSERT INTO niftylive VALUES";
for($i=0; $i<count($scrips); $i++){
$url = 'http://www.nseindia.com/marketinfo/equities/ajaxGetQuote.jsp?symbol='.$scrips[$i];
$data = file_get_contents($url,NULL,NULL,0,200);
if(!$data){
echo "Data Error.\n";
return;
}
$dataarray = explode(';',$data);
if($dataarray[0] != "SUCCESS"){
$values = $values."(NULL,'$dataarray[1]','$dataarray[14]','$dataarray[15]','$dataarray[16]'),";
}else{
$error = 1;
}
}
if($error == 0){
$truncate = mysql_query("TRUNCATE TABLE `niftylive`");
if($truncate){
   $result = mysql_query(substr($values, 0, strlen($values)-1));
}
}
echo substr($values, 0, strlen($values)-1);
}else{
  echo "Market Closed";
}
mysql_close($con);
?>