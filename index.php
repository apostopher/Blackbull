<?php
session_start();
if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
      $_SESSION['user'] = $_COOKIE['cookname'];
      $_SESSION['pass'] = $_COOKIE['cookpass'];
   }
   if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
?>
<!DOCTYPE html>
<html class="no-js">
<head>
	<?php require_once("metacontent.php"); ?>
	<title>Blackbull Investment Company</title>
        <link rel="stylesheet" href="stylesheets/site.css" media="screen">
        <link rel="stylesheet" href="stylesheets/home.css" media="screen">
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="javascripts/lib/modernizr-1.5.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.4/jquery-ui.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
        <script src="javascripts/lib/jquery.tools.min.js"></script>
        <script src="javascripts/lib/jquery.jcryption-1.1.min.js"></script>
        <script src="javascripts/site.js"></script>
        <script src="javascripts/home.js"></script>
</head>
<body>
<?php require_once("_partial_header.php"); ?>
<div id="content">
<div class="spacer">&nbsp;</div>
<div id="leftpane">
<a class="next hide"></a>
<div id="scrollable">
<article id="slides">
<!--section class="items"><a href="articles/cocktail.php"><img src="assets/articleCocktail.jpg" height="400" width="624"/></a></section-->
<section class="items"><a href="articles/dragonEmpire.php"><img src="assets/articleChina.jpg" height="400" width="624"/></a></section>
<section class="items"><a href="articles/unlockTheCycle.php"><img src="assets/articleCycle.jpg" height="400" width="624"/></a></section>
</article>
</div>
<a class="prev hide"></a>
<article id="news">
<section id="news1" class="bbnews" <?php if($_SESSION['user'] == "Admin"){echo " contenteditable=\"true\"";}?>>
<?php require_once("articles/dailydigest/news1.php"); ?>
</section>
<section id="news2" class="bbnews" <?php if($_SESSION['user'] == "Admin"){echo " contenteditable=\"true\"";}?>>
<?php require_once("articles/dailydigest/news2.php"); ?>
</section>
</article>
</div>
<aside id="rightpane">
<blockquote>
<p>100 Rs. Invested in Blackbull is <span id="returns"></span> Rs after one year</p>
</blockquote>
<section class="bbfolio">
<h2>Blackbull Portfolio</h2>
<div class="spacer">&nbsp;</div>
<ul class="portfolio">
<li id="tradingtab" class="tab active"><a href="#">Trading</a>
<span class="filler">&nbsp;</span> 
<div id="tradingcontent">
<table>
<tbody id="tradingpositions">
<tr class="last">
<td class="loading">Loading Data&hellip;</td>
</tr>
</tbody>
</table>
</div>
</li>
<li id="investtab" class="tab"><a href="#">Investment</a>
<span class="filler invisible">&nbsp;</span>
<div id="investcontent">
<table>
<tbody id="investmentpositions">
<tr class="last">
<td class="loading">Loading Data&hellip;</td>
</tr>
</tbody>
</table>
</div>
</li>
</ul>
<div class="goto"><a href="services/portfolio.php">For details visit Blackbull portfolio</a></div>
</section>
<section class="bbinfo">
<h2>Blackbull Queries</h2>
<p>Our new Blackbull queries is specially made available to answer your queries related to stocks and investments. Feel free to post your queries and we will get back to you as soon as possible.</p>
<span class="goto"><a href="services/queries.php">Go to Blackbull Queries &raquo;</a></span>
</section>
</aside>
<div class="spacer">&nbsp;</div>
</div>
<?php require_once("_partial_footer.php"); ?>
</body>
</html>