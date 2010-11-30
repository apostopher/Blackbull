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
	<title>MOIL IPO - Blackbull Investment Company</title>
	<link rel="stylesheet" href="../stylesheets/site.css?v=6" media="screen">
	<link rel="stylesheet" href="../stylesheets/research/research.css" media="screen">
	<script src="../javascripts/lib/modernizr-1.6.min.js"></script>
</head>
<body>
<?php require_once("../_partial_header.php"); ?>
<div id="content" data-type="Research">
<div id="analysis">
<div id="suggest"><h3>We recommend</h3><p class="buy">BUY</p></div>
<h1>MOIL IPO analysis</h1>
<p><span class="dropcap">M</span>OIL is the largest producer of manganese ore in India and the lowest cost producer in the world. It extracts about half the nation's manganese requirement.</p>
<p>Manganese is used in making of steel and it can't be recycled from steel. This means that manganese becomes critical resource. We are bullish on the infrastructure story. This makes it easy to infer that steel supply will be less than the demand. This means that manganese will also see a surge in demand.</p>
<div id="researchads">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-2413414539580695";
/* ipo */
google_ad_slot = "4918226797";
google_ad_width = 336;
google_ad_height = 280;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
<p>The other major suppliers of manganese are East and South Asia. There is a total of 90mn MT of coal. MOIL commands 60mn MT.One must however also look at the quality of mines. The quality of a manganese mine is decided by the average manganese content that a mine holds. MOIL holds mines that have average content of 36%. This makes it medium quality manganese. This again gives some comfort to the pricing power of MOIL.</p>
<p>But the mines of high quality are small in size and many are located in South Africa. But that country has been grappling with problems like poor infrastructure and increased domestic power shortage. This leaves less ore for exports. Furthermore, the South African Rand has been strengthening against the dollar thus making the exports uncompetitive.</p>
<p>MOIL is planning to ramp up its production by 50,000 MT each year. It has entered into JV with SAIL and RINL to produce ferro manganese. These facilities will come on steam in FY 2012. Apart from this, MOIL is also mechanizing its mines to boost efficiency. This will help MOIL to extract more ore.</p>
<p>On financial front, the company has a very strong balance sheet just like other PSUs. Even if we consider that the prices of the ore would not go up next year and that MOIL meets its target production, the valuation comes out to a price of INR 622.</p>
<p class="last">Therefore, we recommend a strong <b>BUY</b> on the stock.</p></div>
</div>
<?php require_once("../_partial_footer.php"); ?>
<?php require_once("../jslibs.php"); ?>
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