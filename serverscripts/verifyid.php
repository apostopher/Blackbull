<?php
require_once('dba.php');
$error = 1;
$username = mysql_real_escape_string($_GET['id']);
$query = "SELECT * FROM pending WHERE id like '".$username."'";
$result = mysql_query($query);
if($result){
	$pendingnum = mysql_numrows($result);
}else{
	$message = "db";
}

if($pendingnum == 0){
	$query = "SELECT * FROM users WHERE id like '".$username."'";
	$users = mysql_query($query);
	if($users){
		$num = mysql_numrows($users);
		if($num == 1){
			$message = "idexists";
		}else{
			$error = 0;
			$message = "";
		}
	}else{
		$message = "db";
	}
}
if($pendingnum == 1){
	$message = "pendingid";
}
$response = array("error" => $error, "type" => $message, "id" =>$_GET['id']);
echo json_encode($response);
mysql_close($con);
?>