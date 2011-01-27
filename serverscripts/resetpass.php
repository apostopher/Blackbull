<?php
require_once('dba.php');
require_once('Mail.php');
if(!isset($_POST['id'])){
$response = array("success" => "0", "message" => "emptyid");
echo json_encode($response);
mysql_close($con);
return;
}

$id = trim(mysql_real_escape_string($_POST['id']));
$vowels = 'aeuyAEUY';
$consonants = 'bdghjmnpqrstvzBDGHJLMNPQRSTVWXZ23456789@#$%';
$newpass = '';
$alt = time() % 2;
for ($i = 0; $i < 9; $i++) {
	if ($alt == 1) {
		$newpass .= $consonants[(rand() % strlen($consonants))];
		$alt = 0;
	} else {
		$newpass .= $vowels[(rand() % strlen($vowels))];
		$alt = 1;
	}
}

$query = "SELECT fname, lname FROM users WHERE id='".$id."'";
$result = mysql_query($query);

$rowCheck = mysql_num_rows($result);
if($rowCheck > 0){
$row = mysql_fetch_array($result);
$squery = "SELECT id from pendingpass where id='".$id."'";
$sresult = mysql_query($squery);
$rowCheck = mysql_num_rows($sresult);
if($rowCheck > 0){
$uquery = "UPDATE pendingpass SET pass=PASSWORD('".$newpass."') WHERE id='".$id."'";
}else{
$uquery = "INSERT INTO pendingpass VALUES('".$id."',PASSWORD('".$newpass."'), CURDATE())";
}

$uresult = mysql_query($uquery);
if($uresult){
$host = "mail.blackbull.in";
$username = "support@blackbull.in";
$password = "Supp0rT@Bb";

$headers = array ('From' => "support@blackbull.in",
                  'To' => $row['fname'].' '.$row['lname'].' '.$id,
                  'Subject' => "Password reset request Blackbull Investment Company",
				  'Content-type' => "text/html");

$smtp = Mail::factory('smtp',
  array ('host' => $host,
         'port' => "26",
         'auth' => true,
         'username' => $username,
         'password' => $password));
$message = "<html><body style=\"background-color:#F9F9F9; font-family: Arial, Helvetica, sans-serif; font-size:12px; line-height: 20px; color: #3C5768; margin:0; padding:10px;\">";
$message = $message."<p>Dear ".$row['fname']." ".$row['lname'].",</p>";
$message = $message."<p>This e-mail is a response to a password change request initiated by you.</p><p>Your account password has been temporarily set to <b>$newpass</b></p>";
$message = $message."<p>Please click on the link below to set a new password for your BlackBull Investment Company account.</p>";
$message = $message."<p><b><a href=\"http://www.blackbull.in/accounts/setnewpassword/\">http://www.blackbull.in/accounts/setnewpassword/</a></b></p>";
$message = $message."<p>We look forward to having a long, trusted and rewarding relationship with you.</p>";
$message = $message."<p>Regards,</p>";
$message = $message."<p><b>Blackbull Investment Company</b></p>";
$message = $message."</body></html>";
$mail = $smtp->send($id, $headers, $message);

if (PEAR::isError($mail)) {
	$response = array("success" => "0", "message" => "mail");
	echo json_encode($response);
	mysql_close($con); 
	return;
}else{
	$response = array("success" => "1", "message" => $id);
	echo json_encode($response);
	mysql_close($con); 
	return;
}
}else{
	$response = array("success" => "0", "message" => "db");
	echo json_encode($response);
	mysql_close($con);
	return;
}
}else{
	$response = array("success" => "0", "message" => "iderror");
	echo json_encode($response);
	mysql_close($con);
	return;
}
?>