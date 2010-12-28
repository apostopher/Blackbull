<?php
// Start session to store keys
session_start();
// Include the required scripts
require_once("dba.php");
/*require_once("jCryption-1.1.php");

$keyLength = 256;
$jCryption = new jCryption();

// Check whether we need to send keys
if(isset($_GET["generateKeypair"])) {
	$keys = $jCryption->generateKeypair($keyLength);
	$_SESSION["e"] = array("int" => $keys["e"], "hex" => $jCryption->dec2string($keys["e"],16));
	$_SESSION["d"] = array("int" => $keys["d"], "hex" => $jCryption->dec2string($keys["d"],16));
	$_SESSION["n"] = array("int" => $keys["n"], "hex" => $jCryption->dec2string($keys["n"],16));
	echo '{"e":"'.$_SESSION["e"]["hex"].'","n":"'.$_SESSION["n"]["hex"].'","maxdigits":"'.intval($keyLength*2/16+3).'"}';
        return;
}*/

// We need to authenticate the user now
// If username OR password is not set return error
if (!isset($_POST['username']) || !isset($_POST['password'])) {
	$response = array("id"=>'0',"redirect"=>'0', "admin"=>'0');
	mysql_close($con);
	header('Content-type: application/json');
	echo json_encode($response);
	return;
}

// The password is encrypted using jCryption plugin v1.1
// Call the decrypt method to get plaintext password
/*$pass = $jCryption->decrypt($_POST['password'], $_SESSION["d"]["int"], $_SESSION["n"]["int"]);*/
$pass = $_POST['password'];

// We dont need the keys now. delete them
/*unset($_SESSION["e"]);
unset($_SESSION["d"]);
unset($_SESSION["n"]);*/

$user = strtolower(addslashes($_POST['username']));

// Query the users table to authenticate
$result = mysql_query("select * from users where id='".$user."' AND pass=PASSWORD('".$pass."')");

// Process the query result
$rowCheck = mysql_num_rows($result);
if($rowCheck > 0){
        // We found a valid match in users table
	while($row = mysql_fetch_array($result)){
		session_start();
		// Set the session variables
		$_SESSION['user_id'] = $row['user_id'];
		$_SESSION['id'] = $row['id'];
		$_SESSION['user'] = $row['fname'];
		$_SESSION['pass'] = $row['pass'];
		// Set cookies if user has selected 'remember me' option on login form
		if(isset($_POST['remember'])){
			if($_POST['remember'] == "1"){
				setcookie("cookid", $_SESSION['id'], time()+60*60*24*100, "/","blackbull.in");
				setcookie("cookname", $_SESSION['user'], time()+60*60*24*100, "/","blackbull.in");
				setcookie("cookpass", $_SESSION['pass'], time()+60*60*24*100, "/","blackbull.in");
			}
		}
		// If redirect session variable is set, add it to response JSON data
		if(isset($_SESSION['redirect'])){
			$redirect = $_SESSION['redirect'];
		}else{
			$redirect = "0";
		}
		// Check whether user has admin rights
		if($row['id'] == "admin@blackbull.in"){
			$admin = "1";
		}else{
			$admin = "0";
		}
		// Create the JSON response
		$response = array(
		        "user_id"=>$row['user_id'],
			"id"=>$row['fname'],
			"redirect"=>$redirect,
			"admin"=>$admin);
		mysql_close($con);
		header('Content-type: application/json');
		echo json_encode($response);
  	}
}else{
	// Handle the error
	$response = array(
		"id"=>'0',
		"redirect"=>'0',
		"admin"=>'0');
	mysql_close($con);
	header('Content-type: application/json');
	echo json_encode($response);
}
?>