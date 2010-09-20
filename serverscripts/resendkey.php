<?php

require_once('dba.php');
require_once('Mail.php');

$query = "SELECT activate FROM pending WHERE id='".trim($_GET['resend'])."'";
$resendid = mysql_query($query);

if(mysql_num_rows($resendid) == 0){
	$response = array("success" => "0");
	echo json_encode($response);
	mysql_close($con);
	return;
}
while($row = mysql_fetch_array($resendid)){
   $hash = $row['activate'];
   break;
}
$host = "mail.blackbull.in";
$username = "support@blackbull.in";
$password = "Supp0rT@Bb";

$headers = array ('From' => "support@blackbull.in",
                  'To' => $_GET['resend'],
                  'Subject' => "Welcome to Blackbull Investment Company",
				  'Content-type' => "text/html");

$smtp = Mail::factory('smtp',
  array ('host' => $host,
         'port' => "26",
         'auth' => true,
         'username' => $username,
         'password' => $password));
$message = "<html><body style=\"background-color:#F9F9F9; font-family: Arial, Helvetica, sans-serif; font-size:12px; line-height: 20px; color: #3C5768; margin:0; padding:10px;\">";
$message = $message."<p>Dear Friend,</p>";
$message = $message."<p>Thank you for registering with Blackbull Investment Company.</p><p>We offer you the BlackBull Promise of providing the current, relevant and actionable research and guidance related to the Indian equity markets.</p>";
$message = $message."<p>Please click on the link below to activate your BlackBull Investment Company account.</p>";
$message = $message."<p><b><a href=\"http://www.blackbull.in/accounts/activate/".$hash."\">http://www.blackbull.in/accounts/activate/".$hash."</a></b></p>";
$message = $message."<p>We look forward to having a long, trusted and rewarding relationship with you.</p>";
$message = $message."<p>Regards,</p>";
$message = $message."<p><b>Blackbull Investment Company</b></p>";
$message = $message."</body></html>";
$mail = $smtp->send($_GET['resend'], $headers, $message);

if (PEAR::isError($mail)) {
	$response = array("success" => "0");
	echo json_encode($response);
}else{
	$response = array("success" => "1");
	echo json_encode($response);
}
mysql_close($con);
?>