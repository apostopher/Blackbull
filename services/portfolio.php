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
	<title>Portfolio - Blackbull Investment Company</title>
	<link rel="stylesheet" href="../stylesheets/site.css?v=6" media="screen">
	<link rel="stylesheet" href="../stylesheets/services/portfolio.css?v=1" media="screen">
	<script src="../javascripts/lib/modernizr-1.6.min.js"></script>
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
<div id="twitthis">
<a id="twitlink" href="http://twitter.com/share" class="twitter-share-button" data-text="Ckeck this out.. #NSE and #BSE stock market portfolio on #blackbull." data-count="vertical" data-via="apostopher">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
</div>
<div id="twitcaption">Liked our portfolio?<br/>Tell your friends.</div>
<h1>Blackbull Portfolio</h1>
<p id="foliointro">These are the investment &amp; trading market positions that we have. The latest market positions are at the top.</p>
<div id="portfolioads">
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
<div id="investment_positions">
<h3>Investment positions</h3>
<div class="posintro">These are long-term wealth appreciation investment calls. The purpose of these calls is to maximize the investor's wealth over a five year horizon. All the stocks recommended here are traded on the Bombay Stock Exchange(BSE).</div>
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
<h3>Trading positions</h3>
<div class="posintro">These are short term momentum trading calls. The user must practice absolute discipline in following the stop losses and target levels. All the stocks recommended here are traded on the Bombay Stock Exchange(BSE) &amp; National Stock Exchange(NSE).</div>
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
<?php require_once("../jslibs.php"); ?>
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