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
	<?php require_once("../metacontent.php"); ?>
	<title>Blackbull Investment Company</title>
	<link rel="stylesheet" href="../stylesheets/site.css" media="screen">
	<link rel="stylesheet" href="../stylesheets/tools/fiidii.css?v=2" media="screen">
	<script src="../javascripts/lib/modernizr-1.6.min.js"></script>
</head>
<body>
<?php require_once("../_partial_header.php"); ?>
<div id="content" data-type="Tools">
<div id="fiidii">
<h1>Institutional Investments</h1>
<p>These charts show cumulative investment of FII(Foreign Institutional Investors) &amp; DII(Domestic Institutional Investors) in india over last 30 trading days.</p>
<div id="ulholder">
<div id="tabhelp">Select tab to view corresponding chart.</div>
<div class="spacer">&nbsp;</div>
<ul id="charttype">
<li class="active" id="fiidiili"><a href="javascript:void(0)" id="afiidii">FII + DII</a>
<span class="filler visible">&nbsp;</span>
</li>
<li id="fiili"><a href="javascript:void(0)" id="afii">FII</a>
<span class="filler">&nbsp;</span>
</li>
<li id="diili"><a href="javascript:void(0)" id="adii">DII</a>
<span class="filler">&nbsp;</span>
</li>
</ul>
<div class="spacer">&nbsp;</div>
</div>
<div id="fiidiiholder"><div class="waiting">Loading chart please wait&hellip;</div></div>
<div id="fiiholder" style="display:none"><div class="waiting">Loading chart please wait&hellip;</div></div>
<div id="diiholder" style="display:none"><div class="waiting">Loading chart please wait&hellip;</div></div>
<div id="fiihelp">
<h4>Note:</h4>
<ol>
<li>These charts will auto-update at <b>6:30 PM (India time)</b> every working day.</li>
<li>Refresh the page if the charts do not show latest data.</li>
<li>Select tab to see corresponding chart.</li>
<li>FII data calculation comes negative according to the data from NSE.</li>
</ol>
</div>
<div id="twitthis">
<p>Liked this page?<br/>Spread the word.</p>
<a id="twitlink" href="http://twitter.com/share" class="twitter-share-button" data-text="Ckeck this out.. Cool stock market chart for FII and DII investment in india." data-count="vertical" data-via="apostopher">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
</div>
<div id="daily">
<h3>FII &amp; DII activity</h3>
<span id="fiidiidate"></span>
<span id="spanright">In Rs. crore</span>
<table id="dailymove" cellspacing="0" cellpadding="0">
<tr class="legends">
<td>&nbsp;</td>
<td>Buy value</td>
<td>Sell value</td>
<td class="noright">Net value</td>
</tr>
<tr>
<td class="legends">FII</td>
<td id="fiibuy"></td>
<td id="fiisell"></td>
<td id="fiinet" class="noright"></td>
</tr>
<tr>
<td class="legends">DII</td>
<td id="diibuy"></td>
<td id="diisell"></td>
<td id="diinet" class="noright"></td>
</tr>
<tr>
<td class="legends" id="fiidiitd">FII + DII</td>
<td id="totalbuy"></td>
<td id="totalsell"></td>
<td id="totalnet" class="noright"></td>
</tr>
</table>
</div>
<h3>Who are institutional investors?</h3>
<p>Institutional investors are the companies such as banks, investment banks, mutual funds &amp; pension funds. These big giants invest a considerable amount of capital in indian markets. When these companies buy securities in indian market, the market tends to move upwards. The movement of this chart is similar to the movement of NIFTY index. Some people believe that indian markets are controlled by Foreign and domestic institutional investors.</p>
<h3>How to use this information?</h3>
<p>Upward movement of FII + DII chart indicates that the money is flowing IN the market and this means positive sentiments. Downward movement of FII + DII chart indicates that the money is flowing OUT of the market and this is the time when you should get ready with your exit strategies. Although movement of NIFTY index and this chart are almost same, sometimes this chart shows divergence and an early signal of change in market direction.</p>
<h3>Where does this data come from?</h3>
<p>The data source of this chart is from <a href="http://www.nseindia.com/">NSE website</a>.</p>
</div>
</div>
<?php require_once("../_partial_footer.php"); ?>
<?php require_once("../jslibs.php"); ?>
<script src="../javascripts/lib/highcharts.js"></script>
<script src="../javascripts/tools/fiidii.js?v=1"></script>
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