<?php
session_start();
require_once("phpinisettings.php");
if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass']) && isset($_COOKIE['cookid'])){
      $_SESSION['user'] = $_COOKIE['cookname'];
      $_SESSION['pass'] = $_COOKIE['cookpass'];
      $_SESSION['id'] = $_COOKIE['cookid'];
   }
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js modern"> <!--<![endif]-->
<head>
	<?php require_once("metacontent.php"); ?>
	<meta name="Description" content="Blackbull.in is a website about stock market investments. Get access to various articles on stocks, IPO, company analysis. Our investment tools, stock market tips and tricks help you become intelligent investor."/>
	<?php require_once("opengraph.php"); ?>
	<title>Blackbull Investment Company</title>
        <link rel="stylesheet" href="stylesheets/site.css?v=6" media="screen">
        <link rel="stylesheet" href="stylesheets/home.css?v=2" media="screen">
        <script src="/javascripts/lib/modernizr-1.6.min.js?v=1"></script>
        <!-- script type="text/javascript" src="http://use.typekit.com/gpv5lbg.js"></script -->
	<!-- script type="text/javascript">try{Typekit.load();}catch(e){}</script -->
</head>
<body>
<?php require_once("_partial_header.php"); ?>
<div id="content" class="clearfix">
<div id="homeadunits">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-2413414539580695";
/* homepagelinks */
google_ad_slot = "6996630614";
google_ad_width = 728;
google_ad_height = 15;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
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
<div id="sensex" class="index clearfix">
<div class="indexname greenname">SENSEX</div>
<div class="indexvalue greenvalue"><span id="sprice"></span><br/><span id="schange"></span></div>
</div>
<div id="nifty" class="index clearfix">
<div class="indexname greenname">NIFTY</div>
<div class="indexvalue greenvalue"><span id="nprice"></span><br/><span id="nchange"></span></div>
</div>
<script type="text/javascript"><!--
google_ad_client = "pub-2413414539580695";
/* Homepage */
google_ad_slot = "3232859886";
google_ad_width = 300;
google_ad_height = 250;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<blockquote>
<p>100 Rs. Invested in Blackbull is <span id="returns"></span>&nbsp;Rs after one year</p>
</blockquote>
<section class="bbinfo">
<h2>Blackbull Portfolio</h2>
<div id="porttabholder" class="clearfix">
<ul class="portfolio">
<li id="tradingtab" class="tab active"><a href="#">Trading</a>
<span class="filler">&nbsp;</span>
</li>
<li id="investtab" class="tab"><a href="#">Investment</a>
<span class="filler invisible">&nbsp;</span>
</li>
</ul>
</div>
<div id="tradingcontent">
<table>
<tbody id="tradingpositions">
<tr class="last">
<td class="loading">Loading Data&hellip;</td>
</tr>
</tbody>
</table>
</div>
<div id="investcontent" style="display:none;">
<table>
<tbody id="investmentpositions">
<tr class="last">
<td class="loading">Loading Data&hellip;</td>
</tr>
</tbody>
</table>
</div>
<div class="goto"><a href="services/portfolio.php">For details visit Blackbull portfolio</a></div>
</section>
<section class="bbinfo">
<h2>Blackbull Tools</h2>
<p>Blackbull provides tools that will help you take your investment decisions. The institutional investments chart shows foreign and domestic investments in indian markets. This graph will tell you the market perspective of big investors.</p>
<span class="goto"><a href="tools/fiidii.php">Go to Blackbull Tools &raquo;</a></span>
</section>
<div id="twitthis">
<p>Liked this site?<br/>Spread the word.</p>
<a id="twitlink" href="http://twitter.com/share" class="twitter-share-button" data-text="Ckeck this out.. Cool website for stock market investment in india #NSE and #BSE." data-count="vertical" data-via="apostopher">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
</div>
<div id="fblike">
<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fblackbull.in&amp;layout=box_count&amp;show_faces=true&amp;width=45&amp;action=like&amp;colorscheme=light&amp;height=65" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:65px;" allowTransparency="true"></iframe>
</div>
</aside>
</div>
<?php require_once("_partial_footer.php"); ?>
<?php require_once("jslibs.php"); ?>
<script src="javascripts/home.js?v=4"></script>
<?php require_once("analyticstracking.php"); ?>
</body>
</html>