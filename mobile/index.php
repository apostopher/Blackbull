<?php
require_once('../serverscripts/dba.php');
$query = "SELECT * FROM niftylive";
$result = mysql_query($query);
echo "<!DOCTYPE html PUBLIC '-//WAPFORUM//DTD XHTML Mobile 1.0//EN' 'http://www.openmobilealliance.org/tech/DTD/xhtml-mobile10.dtd'>";
echo "<html xmlns='http://www.w3.org/1999/xhtml'><head><title>BlackBull Nifty Watch</title></head>";
echo "<body style='margin:0;padding:0;text-align:center'><a id='home' href='http://www.blackbull.in' style='display:block;width:100%;padding:8px 0px;text-decoration:none;background:#404f77;color:white'><b>BlackBull</b> Investment Company</a>";
echo "<div style='padding:5px 0px;background:#ddd'><a href='#bottom'>Bottom</a></div>";
$i=0;
$tag ="";
$notag = 1;
while($row = mysql_fetch_array($result)) {
     if($row['change'] < 0 ){
   $type = "color:red";
   $back ="background:#ffdbf0;";
}else{
   $type ="color:green";
   $back = "background:#eaffd1;";
}
if(strcmp($tag,substr($row['symbol'],0,1))){
$tag = substr($row['symbol'],0,1);
echo "<div id='c".$notag."' style='background:#404f77'><a href='#c".($notag -1)."' style='float:left;text-decoration:none;color:white;font-weight:bold;font-size:100%;padding:4px 0px;width:33%'>&lt;</a><a href='#c".($notag + 1)."' style='float:right;text-decoration:none;color:white;font-weight:bold;font-size:100%;padding:4px 0px;width:33%'>&gt;</a><span style='display:block;padding:4px 0px;margin:0 15px;color:white;font-weight:bold;font-size:100%;'>".$tag."</span></div>";
$notag = $notag +1;
}
echo "<div style='$back font-size:1.1em;border-bottom:1px solid #000;padding-bottom:10px;padding-top:10px'>";
echo "<p style='margin-top:0'>Symbol:&nbsp;<b style='$type'>".$row['symbol']."</b></p>";
echo "<p style='margin:1px'>LTP:&nbsp;<b style='$type'>".$row['ltp']."</b></p>";
echo "<p style='margin:1px'>Change:&nbsp;<b style='$type'>".$row['change']."(".$row['per_chg']."%)</b></p></div>"; 
$i = $i + 1;
}
echo "<div style='padding:5px 0px;background:#ddd'><a href='#home'>Top</a></div>";
echo "<a id='bottom' href='http://www.blackbull.in' style='display:block;width:100%;padding:8px 0px;text-decoration:none;background:#404f77;color:white'><b>BlackBull</b> Investment Company</a></body></html>";
mysql_close($con);
?>