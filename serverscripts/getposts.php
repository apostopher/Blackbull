<?php
require_once('dba.php');
if(isset($_GET['page'])){
$lowlimit = 30*($_GET['page'] - 1);
$highlimit = 30*($_GET['page']);
}else{
$lowlimit = '0';
$highlimit = '30';
}
 $result = mysql_query("SELECT queries.q_id, queries.date, users.fname, queries.text, queries.isprivate, count( answers.q_id ) as replies FROM users, queries LEFT JOIN answers ON queries.q_id = answers.q_id WHERE users.id = queries.owner GROUP BY queries.q_id ORDER BY queries.date DESC LIMIT $lowlimit , $highlimit");
$i = 0;
if ($result) {
  while($row = mysql_fetch_array($result)) {
    $data[$i] = array("id" => $row['q_id'], "date" => $row['date'], "owner" => $row['fname'], "text" => $row['text'], "private" => $row['isprivate'], "replies" => $row['replies']);
   $i++;
  }
}

$response = array("total" => $i, "posts" => $data);
header('Content-type: application/json');
if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
  	header("Cache-Control: no-cache");
  	header("Pragma: no-cache");
}
echo json_encode($response);
mysql_free_result($result);
mysql_close($con);
?>