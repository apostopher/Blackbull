<?php
 require_once('dba.php');
 require_once('Mail.php');
 $posttext = trim(mysql_real_escape_string($_POST['text']));
 $isprivate = trim(mysql_real_escape_string($_POST['private']));
 $owner = trim(mysql_real_escape_string($_POST['owner']));
 $i = 0;

$query = "INSERT INTO queries VALUES (NULL, '$posttext', NOW(),'$owner',true,$isprivate,'')";
$result = mysql_query($query);
if($result){
   $getnew = "select q_id, date, fname, text, isprivate from queries, users where q_id = '".mysql_insert_id()."' AND id = '$owner'";
   $result1 = mysql_query($getnew);
   while($row = mysql_fetch_array($result1)) {
    $firstname = $row['fname'];
    $data[$i] = array("id" => $row['q_id'], "date" => $row['date'], "owner" => $row['fname'], "text" => $row['text'], "private" => $row['isprivate']);
    $i++;
  }

   $response = array("error" => "0", "posts" => $data);
}else{
   $response = array("error" => "1", "posts" => "");
}


$host = "mail.blackbull.in";
$username = "support@blackbull.in";
$password = "Supp0rT@Bb";

$headers = array ('From' => "support@blackbull.in",
                  'To' => "apostopher@gmail.com",
                  'Subject' => "Blackbull Queries",
				  'Content-type' => "text/html");

$smtp = Mail::factory('smtp',
  array ('host' => $host,
         'port' => "26",
         'auth' => true,
         'username' => $username,
         'password' => $password));
$message = "<html><body style=\"background-color:#F9F9F9; font-family: Arial, Helvetica, sans-serif; font-size:12px; line-height: 20px; color: #3C5768; margin:0; padding:10px;\">";
$message = $message."<p>$posttext</p>";
$message = $message."<p><i>by ".$firstname."</i><p>";
$message = $message."</body></html>";
$mail = $smtp->send("apostopher@gmail.com,pankaj.dalvi@tcs.com,tennis.et.thed@gmail.com", $headers, $message);
echo json_encode($response);
mysql_close($con);
?>