<?php
	$url = "http://finance.yahoo.com/d/quotes.csv?s=^NSEI+^BSESN&f=l1c1p2&ex=.csv";
	$file = fopen ($url,"r");
	if($file){
		$data = array();
		$i = 0;
		while($stocks = fgetcsv($file)) {
			$data[$i] = array("price" => $stocks[0], "change" => $stocks[1], "perchange" => $stocks[2]);
			$i++;
		}
		fclose($file);
		if($i < 1){
			$response = array("error" => "1", "time" => time(), "values" => $data);
		}else{
			$response = array("error" => "0", "time" => time(), "values" => $data);
		}
	}else{
		$response = array("error" => "1");
	}
	header('Content-type: application/json');
        if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")==false) {
            header("Cache-Control: no-cache");
            header("Pragma: no-cache");
        }
        echo json_encode($response);
?>