<?php
session_start();
if(isset($_SESSION['user'])){
	unset($_SESSION['user']);
}
if(isset($_SESSION['pass'])){
	unset($_SESSION['pass']);
}
if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
   setcookie("cookname", "", time()-60*60*24*100, "/", "blackbull.in");
   setcookie("cookpass", "", time()-60*60*24*100, "/", "blackbull.in");
   setcookie("cookid", "", time()-60*60*24*100, "/","blackbull.in");
}

session_destroy();
echo "1";
?>