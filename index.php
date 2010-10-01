<?php
session_start();
if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass']) && isset($_COOKIE['cookid'])){
      $_SESSION['user'] = $_COOKIE['cookname'];
      $_SESSION['pass'] = $_COOKIE['cookpass'];
      $_SESSION['id'] = $_COOKIE['cookid'];
   }
?>
<!DOCTYPE html>
<html class="no-js">
<head>
	<?php require_once("metacontent.php"); ?>
	<title>Blackbull Investment Company</title>
        <link rel="stylesheet" href="stylesheets/site.css" media="screen">
        <link rel="stylesheet" href="stylesheets/home.css" media="screen">
        <script src="javascripts/lib/modernizr-1.5.min.js"></script>
</head>
<body>
<?php require_once("_partial_header.php"); ?>
<div id="content">
<div class="spacer">&nbsp;</div>
<div id="leftpane">
<a class="next hide"></a>
<div id="scrollable">
<article id="slides">
<!--section class="items"><a href="articles/cocktail.php"><img src="http://assets.blackbull.in/articleCocktail.jpg" height="400" width="624"/></a></section-->
<section class="items"><a href="articles/dragonEmpire.php"><img src="http://assets.blackbull.in/articleChina.jpg" height="400" width="624"/></a></section>
<section class="items"><a href="articles/unlockTheCycle.php"><img src="http://assets.blackbull.in/articleCycle.jpg" height="400" width="624"/></a></section>
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
<h2>Blackbull Tools</h2>
<p>Blackbull provides tools that will help you take your investment decisions. The institutional investments chart shows foreign and domestic investments in NSE. This graph will tell you the market perspective of big investors.</p>
<span class="goto"><a href="tools/fiidii.php">Go to Blackbull Tools &raquo;</a></span>
</section>
</aside>
<div class="spacer">&nbsp;</div>
</div>
<?php require_once("_partial_footer.php"); ?>
<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.4/jquery-ui.min.js"></script>
<!--script src="http://ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script-->
<script src="javascripts/lib/jquery.tools.min.js"></script>
<script src="javascripts/lib/jquery.jcryption-1.1.min.js"></script>
<script src="javascripts/site.js"></script>
<script src="javascripts/home.js"></script>
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