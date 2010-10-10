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
	<link rel="stylesheet" href="../stylesheets/tools/fiidii.css" media="screen">
	<!-- script src="../javascripts/lib/modernizr-1.5.min.js"></script -->
</head>
<body>
<?php require_once("../_partial_header.php"); ?>
<div id="content" data-type="Tools">
<div id="fiidii">
<h1>Institutional Investments</h1>
<p>This chart shows cumulative investment of FII(Foreign Institutional Investors) &amp; DII(Domestic Institutional Investors) in NSE(National Stock Exchange) over last 30 trading days.</p>
<div id="chartholder"></div>
<h3>What are institutional investors?</h3>
<p>Institutional investors are the companies such as banks, investment banks, mutual funds &amp; pension funds. These big giants invest a considerable amount of capital in indian markets. When these companies buy securities in indian market, the market tends to move upwards. The the movement of this chart is similar to the movement of NIFTY index. Some people believe that indian markets are controlled by Foreign and domestic institutional investors.</p>
<h3>How to use this information?</h3>
<p>Upward movement of this chart indicates that the money is flowing IN the market and this means positive sentiments. Downward movement of this chart indicates that the money is flowing OUT of the market and this is the time when you should get ready with your exit strategies. Although movement of NIFTY index and this chart are almost same, sometimes this chart shows divergence and an early signal of change in market direction.</p>
<h3>Where does this data come from?</h3>
<p>The data source of this chart is from <a href="http://www.nseindia.com/">NSE website</a>.</p>
</div>
</div>
<?php require_once("../_partial_footer.php"); ?>
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.4/jquery-ui.min.js"></script>
<script src="../javascripts/lib/jquery.tools.min.js"></script>
<script src="../javascripts/lib/jquery.jcryption-1.1.min.js"></script>
<script src="../javascripts/site.js"></script>
<script src="../javascripts/lib/highcharts.js"></script>
<script src="../javascripts/tools/fiidii.js"></script>
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