<?php

// Include necessary files
require_once('recaptchalib.php');
require_once('dba.php');
require_once('Mail.php');

// Private key for reCAPTCHA
$privatekey = "6LdNJ70SAAAAAFx0BDuKPeAmZcZzuDSGW6qJuMiV";

$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["challenge"],
                                $_POST["userinput"]);
if (!$resp->is_valid) {
	$response = array("status" => "captchafailed");
	echo json_encode($response);
	mysql_close($con);
	return;
}

foreach($_POST as $name => $value) {
	$_POST[$name] = mysql_real_escape_string($value);
}
                          
$query = "SELECT id FROM users WHERE id='".trim($_POST['email'])."'";
$idexists = mysql_query($query);
if(mysql_num_rows($idexists)){
	$response = array("status" => "idexists");
	echo json_encode($response);
	mysql_close($con);
	return;
}
$query = "SELECT id FROM pending WHERE id='".trim($_POST['email'])."'";
$pendingid = mysql_query($query);
if(mysql_num_rows($pendingid)){
	$response = array("status" => "pending", "id" => $_POST['email']);
	echo json_encode($response);
	mysql_close($con);
	return;
}
$date = date("Y-m-d");
$hash = md5($date.$_POST['email'].$_POST['userinput']);
$query = "INSERT INTO pending VALUES ('".trim($_POST['email'])."','".substr($hash,0,78)."','".$date."',PASSWORD('".$_POST['password']."'),'".ucwords(trim($_POST['fname']))."','".ucwords(trim($_POST['lname']))."', '', '', '', '', '', '', '', '', '')";

$result = mysql_query($query);
if(!$result){
	$response = array("status" => "db");
	echo json_encode($response);
	mysql_close($con);
	return;
}

$host = "mail.blackbull.in";
$username = "support@blackbull.in";
$password = "Supp0rT@Bb";

$headers = array ('From' => "support@blackbull.in",
                  'To' => $_POST['fname'].' '.$_POST['lname'].' '.$_POST['email'],
                  'Subject' => "Welcome to Blackbull Investment Company",
				  'Content-type' => "text/html");

$smtp = Mail::factory('smtp',
  array ('host' => $host,
         'port' => "26",
         'auth' => true,
         'username' => $username,
         'password' => $password));
$message = "<html><body style=\"background-color:#F9F9F9; font-family: Arial, Helvetica, sans-serif; font-size:12px; line-height: 20px; color: #3C5768; margin:0; padding:10px;\">";
$message = $message."<p>Dear ".$_POST['fname']." ".$_POST['lname'].",</p>";
$message = $message."<p>Thank you for registering with Blackbull Investment Company.</p><p>We offer you the BlackBull Promise of providing the current, relevant and actionable research and guidance related to the Indian equity markets.</p>";
$message = $message."<p>Please click on the link below to activate your BlackBull Investment Company account.</p>";
$message = $message."<p><b><a href=\"http://www.blackbull.in/accounts/activate/".$hash."\">http://www.blackbull.in/accounts/activate/".$hash."</a></b></p>";
$message = $message."<p>We look forward to having a long, trusted and rewarding relationship with you.</p>";
$message = $message."<p>Regards,</p>";
$message = $message."<p><b>Blackbull Investment Company</b></p>";
$message = $message."</body></html>";
$mail = $smtp->send($_POST['email'], $headers, $message);

if (PEAR::isError($mail)) {
	$response = array("status" => "email");
	echo json_encode($response);
	mysql_close($con);
	return;
}else{
	$response = array("status" => "success", "email" => $_POST['email']);
	echo json_encode($response);
	mysql_close($con);
	return true;
}

?>