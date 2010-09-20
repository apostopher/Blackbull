<?php
$news1 = $_POST['news1'];
$news2 = $_POST['news2'];
$preview = $_POST['preview'];

if($preview == '1'){
$response = array("success"=>'1',"news1"=>stripslashes(htmlspecialchars_decode($news1)),"news2" => stripslashes(htmlspecialchars_decode($news2)));
header('Content-type: application/json');
echo json_encode($response);
return;
}

if(trim($news1)!='null'){
	$myFile = "../articles/dailydigest/news1.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = stripslashes(htmlspecialchars_decode($news1));
	fwrite($fh, $stringData);
	fclose($fh);
}
if(trim($news2)!='null'){
	$myFile = "../articles/dailydigest/news2.php";
	$fh = fopen($myFile, 'w') or die("can't open file");
	$stringData = stripslashes(htmlspecialchars_decode($news2));
	fwrite($fh, $stringData);
	fclose($fh);
}
$response = array("success"=>'1');
header('Content-type: application/json');
echo json_encode($response);
return;
?>