<?php
session_start();
if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass']) && isset($_COOKIE['cookid'])){
      $_SESSION['user'] = $_COOKIE['cookname'];
      $_SESSION['pass'] = $_COOKIE['cookpass'];
      $_SESSION['id'] = $_COOKIE['cookid'];
}
if(!isset($_SESSION['user'])){
        $_SESSION['redirect'] = $_SERVER['PHP_SELF'];
	header( "Location: http://www.blackbull.in/users/login.php" );
}
?>
<!DOCTYPE html>
<html class="no-js">
<head>
	<?php require_once("../metacontent.php"); ?>
	<title>Blackbull Investment Company</title>
	<link rel="stylesheet" href="../stylesheets/site.css" media="screen">
	<link rel="stylesheet" href="../stylesheets/services/queries.css" media="screen">
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
        <script src="../javascripts/lib/jquery.ThreeDots.min.js"></script>
        <script src="../javascripts/lib/jquery.dateFormat-1.0.js"></script>
        <script src="../javascripts/site.js"></script>
        <script src="../javascripts/services/queries.js"></script>
</head>
<body>
<?php require_once("../_partial_header.php"); ?>
<div id="content" data-type="Services">
<div id="queries">
<h1>Blackbull Queries</h1>
<p>Blackbull queries is a place for you to get your questions answered. Feel free to post your queries and we will get back to you as soon as possible.</p>
<?php
if(isset($_SESSION['user'])){
	require_once("_querieshead.php");
}else{
	require_once("_querieslogin.php");
}
?>
<div id="querytable">
<table id="table_queries" cellpadding="0" cellspacing="0" border="0">
<colgroup>
<col/>
<col width="50" />
<col width="100" />
<col width="100" />
</colgroup>
<thead>
<tr>
<th>Question</th>
<th>Replies</th>
<th>Owner</th>
<th>Last post</th>
</tr>
</thead>
<tfoot>
<tr><td colspan="4">&nbsp;</td></tr>
</tfoot>
<tbody id="queries_tbody">
</tbody>
</table>
</div>
</div>
</div>
<?php require_once("../_partial_footer.php"); ?>
</body>
</html>