<?php
require_once("../phpinisettings.php");
session_start();
if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
      $_SESSION['user'] = $_COOKIE['cookname'];
      $_SESSION['pass'] = $_COOKIE['cookpass'];
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
	<title>Query - Blackbull Investment Company</title>
	<link rel="stylesheet" href="../stylesheets/site.css" media="screen">
	<link rel="stylesheet" href="../stylesheets/services/query.css" media="screen">
	<link rel="stylesheet" href="../stylesheets/services/queryform.css" media="screen">
	<script src="../javascripts/lib/modernizr-1.6.min.js"></script>
</head>
<body>
<?php require_once("../_partial_header.php"); ?>
<div id="content" data-type="Services">
<div id="query">
<div id="googleads">
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
<?php require_once("../jslibs.php"); ?>
<script src="../javascripts/lib/jquery.dateFormat-1.0.js"></script>
<script src="../javascripts/lib/jquery.url.js"></script>
<script src="../javascripts/services/query.js"></script>
<script>
   var _gaq = [['_setAccount', 'UA-11011315-1'], ['_trackPageview']];
   (function(d, t) {
    var g = d.createElement(t),
        s = d.getElementsByTagName(t)[0];
    g.async = true;
    g.src = '//www.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g, s);
   })(document, 'script');
</script>
</body>
</html>