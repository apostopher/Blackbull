<?php
require_once('dba.php');
$success = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><html xmlns=\"http://www.w3.org/1999/xhtml\"><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/><title>User Activation</title></head><body style=\"margin:0;padding:0;border-top:10px solid #000;font-family:Arial, Helvetica, sans-serif;font-size:12px;line-height:20px\"><div style=\"width:950px;margin:0 auto;padding-top:30px\"><h2>Activation Successful</h2><p>Your account is activated <b>successfully</b>. You can now logon to <a href=\"http://www.blackbull.in\">http://www.blackbull.in</a></p></div><div style=\"width:950px;margin:0 auto;margin-top:50px;color:#aaa;line-height:18px;text-align:center;padding-top:20px;border-top:1px solid #ddd\"><p>© Copyright 2010 Blackbull Investment Company | All rights reserved</p></div></body></html>";

$error = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><html xmlns=\"http://www.w3.org/1999/xhtml\"><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/><title>User Activation</title></head><body style=\"margin:0;padding:0;border-top:10px solid #000;font-family:Arial, Helvetica, sans-serif;font-size:12px;line-height:20px\"><div style=\"width:950px;margin:0 auto;padding-top:30px\"><h2>Activation Failed</h2><p>An error occured during activation. Please contact <a href=\"mailto:support@blackbull.in\">support@blackbull.in</a> for further assistance. We are sorry for the inconvenience.</p></div><div style=\"width:950px;margin:0 auto;margin-top:50px;color:#aaa;line-height:18px;text-align:center;padding-top:20px;border-top:1px solid #ddd\"><p>© Copyright 2010 Blackbull Investment Company | All rights reserved</p></div></body></html>";

$query = "SELECT * FROM pending WHERE activate like '".$_GET['key']."'";
$presult = mysql_query($query);

while($row = mysql_fetch_array($presult))
{
	$iquery = "INSERT INTO users VALUES ('".$row['id']."','".$row['pass']."','".$row['fname']."','".$row['lname']."','".$row['sex']."','".$row['addr1']."','".$row['addr2']."','".$row['city']."','".$row['pincode']."','".$row['state']."','".$row['country']."','".$row['contact']."','".$row['subscrib']."')";
	
	$qresult = mysql_query($iquery);
	$dquery = "DELETE FROM pending WHERE activate like '".$_GET['key']."'";
	$rresult = mysql_query($dquery);
	print $success;
	mysql_close($con);
	exit;
}
print $error;
?>