<?php
 require_once('dba.php');
 $anstext = $_POST['text'];
 $isprivate = $_POST['private'];
 $owner = $_POST['owner'];
 $postid = $_POST['id'];
 $postopen = $_POST['open'];
 
if(!$postopen){
  $updatequery = "UPDATE queries SET isopen=0 where q_id = $postid";
  $updateresult = mysql_query($updatequery);
  if($anstext == ""){
    $response = array("error" => "2", "answer" => "");
    mysql_close($con);
    return;
  }
}

$query = "INSERT INTO answers VALUES (NULL, $postid, '$anstext', NOW(),'$owner', $isprivate)";
$result = mysql_query($query);
if($result){
   $getnew = "select a_id, date, fname, text, isprivate from answers, users where a_id = '".mysql_insert_id()."' AND id = '$owner'";
   $result1 = mysql_query($getnew);
   while($row = mysql_fetch_array($result1)) {
    $data = array("a_id" => $row['a_id'], "date" => $row['date'], "owner" => $row['fname'], "text" => $row['text'], "private" => $row['isprivate']);
  }

   $response = array("error" => "0", "answer" => $data);
}else{
   $response = array("error" => "1", "answer" => "");
}

echo json_encode($response);
mysql_close($con);
?>