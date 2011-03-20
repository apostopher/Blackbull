<?php

require_once('../serverscripts/dba.php');
/* Twitter Oauth API */
require_once('twitter/twitteroauth.php');
require_once('twitter/config.php');

// Check whether we can run this script now!
$tableStatusCMQuery = "SELECT timestamp FROM updatestatus WHERE tablename='fiidii'";
$tableStatusCM = mysql_fetch_array(mysql_query($tableStatusCMQuery));
if(strstr($tableStatusCM['timestamp'],date("Y-m-d"))){
	echo "Already updated";
	// Close the connection to the database
	mysql_close($con);
	return false;
}
if($_REQUEST['csvdate'] && $_REQUEST['sqldate']){
  $csvdate = $_REQUEST['csvdate'];
  $sqldate = $_REQUEST['sqldate'];
}else{
  $csvdate = date("d-m-Y");
  $sqldate = date("Y-m-d");
}

$baseurl = 'http://www.nseindia.com/content/equities/temp_csv/';
$filename = 'eq_fiidii_'.$csvdate.$csvdate.'.csv';
$url = $baseurl.$filename;
/*$url = "http://www.nseindia.com/content/equities/temp_csv/eq_fiidii_25-10-201025-10-2010.csv";*/
if(url_exists($url)){
	updatefiidii($url, $sqldate);
}else{
	echo $url;
}

function updatefiidii($url, $sqldate){
	$file = fopen($url,"r");
	$fiidii = fgetcsv($file);
	while($fiidii = fgetcsv($file)) {
		if(strtoupper($fiidii[0]) == "FII"){
			$fii = floatval($fiidii[4]);
			$fiibuy = floatval($fiidii[2]);
			$fiisell = floatval($fiidii[3]);
		}
		if(strtoupper($fiidii[0]) == "DII"){
			$dii = floatval($fiidii[4]);
			$diibuy = floatval($fiidii[2]);
			$diisell = floatval($fiidii[3]);
		}
	}
	$fiidiiquery = "SELECT fii, dii from fiidii WHERE 1 ORDER BY fiidii_date DESC LIMIT 1";
	$fiidiiresult = mysql_query($fiidiiquery);
	if($fiidiiresult){
		$fiidiirow = mysql_fetch_array($fiidiiresult);
		$newfii = $fii + $fiidiirow['fii'];
		$newdii = $dii + $fiidiirow['dii'];
		
		$addfiidii = "INSERT INTO fiidii VALUES('".$sqldate."',".$newfii.",".$newdii.",".$fiibuy.",".$fiisell.",".$diibuy.",".$diisell.")";
		$addfiidiiresult = mysql_query($addfiidii);
		if($addfiidiiresult){
			echo "FII update successful.\n";
			$updatetimefo = "UPDATE updatestatus SET timestamp= '".$sqldate."' WHERE tablename='fiidii'";
    			$updatetimeforesult = mysql_query($updatetimefo);
    			/* POST the new twit on twitter */
    			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_SECRET);
    			/* twit format
    			   #FII & #DII trading activity on #NSE and #BSE as on 31-Dec-2010 visit http://blck.in/d2FC3F on #blackbull
    			*/
    			$twit = "Beautiful charts of #FII & #DII trading activity on #NSE and #BSE as on ".date("j-M-Y")." visit http://blck.in/d2FC3F on #blackbull";
    			$connection->post('statuses/update', array('status' => $twit));
		}else{
			echo "FII update failed.\n";
		}
	}
	fclose($file);
};

function url_exists($url) {
    $hdrs = @get_headers($url);
    echo $hdrs[0];
    return is_array($hdrs) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$hdrs[0]) : false;
};

function PostRequest($url, $referer, $_data) {
 
    // convert variables array to string:
    $data = array();    
    while(list($n,$v) = each($_data)){
        $data[] = "$n=$v";
    }    
    $data = implode('&', $data);
    // format --> test1=a&test2=b etc.
 
    // parse the given URL
    $url = parse_url($url);
    if ($url['scheme'] != 'http') { 
        die('Only HTTP request are supported !');
    }
 
    // extract host and path:
    $host = $url['host'];
    $path = $url['path'];
 
    // open a socket connection on port 80
    $fp = fsockopen($host, 80);
 
    // send the request headers:
    fputs($fp, "POST $path HTTP/1.1\r\n");
    fputs($fp, "Host: $host\r\n");
    fputs($fp, "Referer: $referer\r\n");
    fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
    fputs($fp, "Content-length: ". strlen($data) ."\r\n");
    fputs($fp, "Connection: close\r\n\r\n");
    fputs($fp, $data);
 
    $result = ''; 
    while(!feof($fp)) {
        // receive the results of the request
        $result .= fgets($fp, 128);
    }
 
    // close the socket connection:
    fclose($fp);
 
    // split the result header from the content
    $result = explode("\r\n\r\n", $result, 2);
 
    $header = isset($result[0]) ? $result[0] : '';
    $content = isset($result[1]) ? $result[1] : '';
 
    // return as array:
    return array($header, $content);
}
?>