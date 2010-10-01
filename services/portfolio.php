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
	<link rel="stylesheet" href="../stylesheets/services/portfolio.css" media="screen">
	<script src="../javascripts/lib/modernizr-1.5.min.js"></script>
</head>
<body>
<div id="facebox_overlay" class="hide"></div>
<div id="facebox" class="hide">
<div class="popup">
<div class="scripdetails">
<h2 id="scripname"></h2>
<div class="details">
<table>
<tbody>
<tr>
<td class="loading">Loading data&hellip;</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
<?php require_once("../_partial_header.php"); ?>
<div id="content" data-type="Services">
<div id="portfolio">
<h1>Blackbull Portfolio</h1>
<div id="investment_positions">
<table id="investment_list_table" class="portfolio_list" cellspacing="0" cellpadding="0">
<thead>
<tr><th colspan="3">&nbsp;</th></tr>
</thead>
<tbody id="investment_list">
<tr><td class="loading" colspan="3">Loading Data&hellip;</td></tr>
</tbody>
</table>
</div>
<div id="trading_positions">
<table id="trading_list_table" class="portfolio_list" cellspacing="0" cellpadding="0">
<thead>
<tr><th colspan="3">&nbsp;</th></tr>
</thead>
<tbody id="trading_list">
<tr><td class="loading" colspan="3">Loading Data&hellip;</td></tr>
</tbody>
</table>
</div>
<div class="spacer">&nbsp;</div>
</div>
</div>
<?php require_once("../_partial_footer.php"); ?>
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.4/jquery-ui.min.js"></script>
<!-- script src="http://ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script-->
<script src="../javascripts/lib/jquery.tools.min.js"></script>
<script src="../javascripts/lib/jquery.jcryption-1.1.min.js"></script>
<script src="../javascripts/site.js"></script>
<script src="../javascripts/services/portfolio.js"></script>
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