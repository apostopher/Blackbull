<?php
session_start();
if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
      $_SESSION['user'] = $_COOKIE['cookname'];
      $_SESSION['pass'] = $_COOKIE['cookpass'];
   }

?>
<!DOCTYPE html>
<html class="no-js">
<head>
	<?php require_once("../metacontent.php"); ?>
	<title>Blackbull Investment Company</title>
	<link rel="stylesheet" href="../stylesheets/site.css" media="screen">
	<link rel="stylesheet" href="../stylesheets/services/query.css" media="screen">
	<link rel="stylesheet" href="../stylesheets/services/queryform.css" media="screen">
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="../javascripts/lib/modernizr-1.5.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.4/jquery-ui.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
        <script src="../javascripts/lib/jquery.tools.min.js"></script>
        <script src="../javascripts/lib/jquery.jcryption-1.1.min.js"></script>
        <script src="../javascripts/lib/jquery.dateFormat-1.0.js"></script>
        <script src="../javascripts/lib/jquery.url.js"></script>
        <script src="../javascripts/site.js"></script>
        <script src="../javascripts/services/query.js"></script>
</head>
<body>
<?php require_once("../_partial_header.php"); ?>
<div id="content" data-type="Services">
<div id="query">
<div id="question">
</div>
<div id="answers">
</div>
<?php
if(isset($_SESSION['user'])){
	require_once("_answershead.php");
}else{
	require_once("_querieslogin.php");
}
?>
</div>
</div>
<?php require_once("../_partial_footer.php"); ?>
</body>
</html>