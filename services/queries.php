<?php
session_start();
require_once("../phpinisettings.php");
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
	<meta name="Description" content="Blackbull.in queries is a forum to discuss stock market investment ideas, queries and views. Discuss company prospects, IPO and FPO views on blackbull queries."/>
	<title>Queries - Blackbull Investment Company</title>
	<link rel="stylesheet" href="../stylesheets/site.css" media="screen">
	<link rel="stylesheet" href="../stylesheets/services/queries.css?v=2" media="screen">
	<link rel="stylesheet" href="../stylesheets/services/queryform.css?v=2" media="screen">
	<script src="../javascripts/lib/modernizr-1.6.min.js"></script>
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
<div id="queriesads">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-2413414539580695";
/* query */
google_ad_slot = "7222763231";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
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
<?php require_once("../jslibs.php"); ?>
<script src="../javascripts/lib/jquery.ThreeDots.min.js"></script>
<script src="../javascripts/lib/jquery.dateFormat-1.0.js"></script>
<script src="../javascripts/services/queries.js"></script>
<?php require_once("../analyticstracking.php"); ?>
</body>
</html>