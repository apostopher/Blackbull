<?php

if(isset($_SESSION['lastlogin']) || !isset($_SESSION['id'])){
	return;
}

// Include the required scripts
require_once("dba.php");

$user = $_SESSION['id'];
$browserstr = substr($_SERVER['HTTP_USER_AGENT'],0,39);
$result = mysql_query("select id from lastlogin where id='".$user."'");
if($result){
	if(mysql_num_rows($result)){
		$updatetime = "UPDATE lastlogin SET timestamp= NOW(), browser='$browserstr' WHERE id='".$user."'";
		$timeresult = mysql_query($updatetime);
	}else{
		$inserttime = "INSERT INTO lastlogin VALUES('".$user."', NOW(), '$browserstr')";
		$timeresult  = mysql_query($inserttime);
	}
	if($timeresult){
		$_SESSION['lastlogin'] = "set";
	}	
	mysql_close($con);
}
?>