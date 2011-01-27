<?php
require_once('dba.php');
$id = $_POST['id'];
$tpass = trim(mysql_real_escape_string($_POST['tpassword']));
$newpass = trim(mysql_real_escape_string($_POST['upassword']));

$query = "SELECT * FROM pendingpass WHERE id='".$id."' AND pass=PASSWORD('".$tpass."')";
$result = mysql_query($query);

$rowCheck = mysql_num_rows($result);
if($rowCheck > 0){
      $uquery = "UPDATE users SET pass=PASSWORD('".$newpass."') WHERE id='".$id."'";
      $uresult = mysql_query($uquery);
      if($uresult){
          $dquery = "DELETE FROM pendingpass WHERE id='".$id."'";
          $dresult = mysql_query($dquery);
          echo "success";
          mysql_close($con);
          return;
      }else{
	echo "db";
	mysql_close($con);
	return;
      }
}else{
	echo "db";
	mysql_close($con);
	return;
}
?>