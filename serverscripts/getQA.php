<?php
require_once('dba.php');
$id = $_GET['id'];
$query = "SELECT q_id, text, date, fname, isprivate, isopen from queries, users where q_id=$id and queries.owner = users.id";
$result = mysql_query($query);
if($result){
  while($row = mysql_fetch_array($result)) {
       $data = $row['text'];
       $qdate = $row['date'];
       $qid = $row['q_id'];
       $isopen = $row['isopen'];
       $isprivate = $row['isprivate'];
       $qowner = $row['fname'];
   }
}

$answers = "SELECT a_id, q_id, text, date, fname, isprivate from answers, users where q_id=$id and answers.owner = users.id ORDER BY answers.date ASC";
$result1 = mysql_query($answers);
if($result1){
   $count = 0;
   while($row1 = mysql_fetch_array($result1)){
       $ansarray[$count] = array("a_id" => $row1['a_id'], "text" => $row1['text'], "date" => $row1['date'], "owner" => $row1['fname'], "private" => $row1['isprivate']);
       $count = $count +1;
   }
   $response = array("error" => "0", "qid" => $qid, "qowner" => $qowner, "question" => $data, "qdate" => $qdate, "isopen" => $isopen, "private" => $isprivate, "total" => $count, "answers" => $ansarray);
}else{
      $response = array("error" => "1", "qid" => "", "qowner" => "", "question" => "", "qdate" => "", "isopen" => "", "private" => "", "total" => "", "answers" => "");
}
header('Content-type: application/json');
if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
	header("Cache-Control: no-cache");
	header("Pragma: no-cache");
}
echo json_encode($response);
mysql_close($con);
?>