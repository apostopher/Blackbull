<?php
require_once('dba.php');
if(!isset($_POST['bb_id'])){
mysql_close($con);
echo "iderror";
return;
}
if(!isset($_POST['bb_opsw'])){
mysql_close($con);
echo "iderror";
return;
}
if(!isset($_POST['bb_psw'])){
mysql_close($con);
echo "iderror";
return;
}

$id = $_POST['bb_id'];
$pass = $_POST['bb_opsw'];
$newpass = $_POST['bb_psw'];

$query = "SELECT fname FROM users WHERE id='".$id."' AND pass=PASSWORD('".$pass."')";
$result = mysql_query($query);

$rowCheck = mysql_num_rows($result);
if($rowCheck > 0){
$row = mysql_fetch_array($result);
$uquery = "UPDATE users SET pass=PASSWORD('".$newpass."') WHERE id='".$id."'";
$uresult = mysql_query($uquery);
if($uresult){
   session_start();
   $_SESSION['id'] = $id;
   $_SESSION['user'] = $row['fname'];
   $_SESSION['pass'] = $newpass;
   if(isset($_POST['remember'])){
      if($_POST['remember'] == "1"){
   setcookie("cookid", $_SESSION['id'], time()+60*60*24*100, "/");
   setcookie("cookname", $_SESSION['user'], time()+60*60*24*100, "/");
   setcookie("cookpass", $_SESSION['pass'], time()+60*60*24*100, "/");
}
}
   mysql_close($con);
   echo "success";
   return;
}else{
   mysql_close($con);
   echo "db";
   return;
}
}else{
   mysql_close($con);
   echo "iderror";
   return;
}
?>