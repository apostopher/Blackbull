<?php
require_once('../serverscripts/dba.php');
if($_REQUEST['filedate']){
$filedate = $_REQUEST['filedate'];
$csvdate = date("d-m-Y", strtotime($filedate));
}else{
$filedate = date("dMY");
$csvdate = date("d-m-Y");
}
//http://www.nseindia.com/content/equities/temp_csv/eq_fiidii_23-09-201023-09-2010.csv
$baseurl = 'http://www.nseindia.com/content/equities/temp_csv/';
$filename = 'eq_fiidii_'.$csvdate.$csvdate.'.csv';
$url = $baseurl.$filename;
if(url_exists($url)){
	$file = fopen($url,"r");
	$fiidii = fgetcsv($file);
	while($fiidii = fgetcsv($file)) {
		if(strtoupper($fiidii[0]) == "FII"){
			$fii = intval($fiidii[4]);
		}
		if(strtoupper($fiidii[0]) == "DII"){
			$dii = intval($fiidii[4]);
		}
	}
	$fiidiiquery = "SELECT fii, dii from fiidii WHERE 1 ORDER BY fiidii_date DESC LIMIT 1";
	$fiidiiresult = mysql_query($fiidiiquery);
	if($fiidiiresult){
		$fiidiirow = mysql_fetch_array($fiidiiresult);
		$newfii = $fii + $fiidiirow['fii'];
		$newdii = $dii + $fiidiirow['dii'];
		
		$addfiidii = "INSERT INTO fiidii VALUES(NOW(),".$newfii.",".$newdii.")";
		$addfiidiiresult = mysql_query($addfiidii);
		if($addfiidiiresult){
			echo "FII update successful.\n";
		}else{
			echo "FII update failed.\n";
		}
	}
	fclose($file);
}else{
	echo $url;
}

function url_exists($url) {
    $hdrs = @get_headers($url);
    return is_array($hdrs) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$hdrs[0]) : false;
}
?>