<?php
session_start();
require_once("../phpinisettings.php");
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
	<meta name="Description" content="Get the chart of FII and DII investment in indian markets over a month. Blackbull.in provides FII and DII investment tool to give the overview of foreign investment in india."/>
	<title>FII DII trading activity on NSE and BSE - Blackbull Investment Company</title>
	<link rel="stylesheet" href="../stylesheets/site.css" media="screen">
	<link rel="stylesheet" href="../stylesheets/tools/fiidii.css?v=3" media="screen">
	<script src="../javascripts/lib/modernizr-1.6.min.js"></script>
</head>
<body>
<?php require_once("../_partial_header.php"); ?>
<div id="content" data-type="Tools">
<div id="fiidii">
<h1>Institutional Investments</h1>
<p>About&nbsp;<span id="perown">60%</span>&nbsp;of the Indian markets is owned by foreign money that primarily originates from United States.</p>
<p>These charts show cumulative investment of FII(Foreign Institutional Investors) &amp; DII(Domestic Institutional Investors) in india over last 30 trading days.</p>
<div id="fiiadholder">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-2413414539580695";
/* fiileader2 */
google_ad_slot = "2778153379";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
<div id="ulholder" class="clearfix" data-active="fiidiili" data-period="m1">
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
<div id="tabhelp">Select tab to view corresponding chart.</div>
<ul id="chartperiod">
<li id="y1"><a href="javascript:void(0)" id="ay1">1y</a>
<span class="filler">&nbsp;</span>
</li>
<li id="m6"><a href="javascript:void(0)" id="am6">6m</a>
<span class="filler">&nbsp;</span>
</li>
<li id="m3"><a href="javascript:void(0)" id="am3">3m</a>
<span class="filler">&nbsp;</span>
</li>
<li class="active" id="m1"><a href="javascript:void(0)" id="am1">1m</a>
<span class="filler visible">&nbsp;</span>
</li>
</ul>
<div id="periodhelp">Select tab to change time period (1 month to 1 year).</div>
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
<div id="adthis">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-2413414539580695";
/* fiileader */
google_ad_slot = "1377945996";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
<div id="twitthis">
<p>Liked this page?<br/>Spread the word.</p>
<a id="twitlink" href="http://twitter.com/share" class="twitter-share-button" data-text="Ckeck this out.. Cool stock market chart for FII and DII investment in india." data-count="vertical" data-via="apostopher">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
</div>
<div id="dloadthis">
<p>Liked this chart?<br/>Download data.</p>
<form id="dldatafrm" method="get" action="/serverscripts/fiidii.php">
<input type="hidden" name="req" id="req" value="dl"/>
<h6>Time period:</h6>
<select name="tperiod" id="tperiod">
  <option value="1m">1 Month</option>
  <option value="3m" selected="selected">1 Quarter</option>
  <option value="6m">Half Year</option>
  <option value="12m">Year</option>
  <option value="all">All</option>
</select>
<h6>Chart type:</h6>
<select name="ctype" id="ctype">
  <option value="both">Both</option>
  <option value="fii">FII</option>
  <option value="dii">DII</option>
</select>
<input name="dloaddata" id="dloaddata" type="submit" value="Download"/>
</form>
</div>
<div id="daily">
<h3>FII &amp; DII activity</h3>
<div id="fiidiidate"></div>
<div id="spanright">In Rs. crore</div>
<div>
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
</div>
<h3>Who are institutional investors?</h3>
<p>Institutional investors are the companies such as banks, investment banks, mutual funds &amp; pension funds. These big giants invest a considerable amount of capital in indian markets. When these companies buy securities in indian market, the market tends to move upwards. The movement of this chart is similar to the movement of NIFTY index. Some people believe that indian markets are controlled by Foreign and domestic institutional investors.</p>
<h3>How to use this information?</h3>
<p>Upward movement of FII + DII chart indicates that the money is flowing IN the market and this means positive sentiments. Downward movement of FII + DII chart indicates that the money is flowing OUT of the market and this is the time when you should get ready with your exit strategies. Although movement of NIFTY index and this chart are almost same, sometimes this chart shows divergence and an early signal of change in market direction.</p>
<h3>Where does this data come from?</h3>
<p>The data source of this chart is from <a href="http://www.nseindia.com/">NSE website</a>.</p>
</div>
<?php require_once("../_partial_footer.php"); ?>
<?php require_once("../jslibs.php"); ?>
<script src="../javascripts/lib/highcharts.js?v=3"></script>
<script src="../javascripts/tools/fiidii.js?v=9"></script>
</body>
</html>