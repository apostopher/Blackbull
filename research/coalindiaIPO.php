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
	<link rel="stylesheet" href="../stylesheets/research/research.css" media="screen">
	<script src="../javascripts/lib/modernizr-1.6.min.js"></script>
</head>
<body>
<?php require_once("../_partial_header.php"); ?>
<div id="content" data-type="Research">
<div id="analysis">
<div id="suggest"><h3>We recommend</h3><p class="buy">BUY</p></div>
<h1>Coal india IPO analysis</h1>
<p><span class="dropcap">C</span>oal India Limited (CIL) is set to hit the primary markets with its IPO of Rs. 15,000 crores on 18th Oct 2010. With the market just shying a bit short of its historic highs, CIL seems to have timed the offering spot on. We at BlackBull Investments constantly scan the IPO action for possible investment recommendations. This write up will also help you take a decision about the CIL investment rationale.</p>
<p>CIL is world's largest coal producer and accounts to 80% of India's total production. CIL has grown its profits from Rs. 5890 crores to 9600 crores in five years. The <abbr title="Net Profit Margin">NPM</abbr> is 22%. Now most of the CIL production is of non-coking nature that is mainly used by the power generating companies. It is a low grade coal based on the calorific value. Now, though the companies can import coal at zero duty, it still mixes the high grade coal with cheap CIL coal to realize low cost operations.</p>
<p>Now the coal is of low quality and is sold through long term fixed price contracts at close to 25% discount to the international spot rates. But still the <abbr title="Operating Profit Margin">OPM</abbr> is 30%. This feat is achieved because CIL has bottom rock cost of production.  CIL has also been diversifying its line of business by venturing into power generation (through joint ventures) and acquisition of coal assets abroad. Both the initiatives align well with the company internal competence.</p>
<p>But there is no return without risk. CIL main risk is it's inefficient execution. It has consistently missed production targets. Secondly, many of the mines are in landlocked states and thus create a dependency on the railways tariff structure. Thirdly, the recent political propaganda on mining may allow for some legislation that may impact mining profitability.</p>
<p>So, what should we as retail investors do in this case? The company has very strong balance sheet which is debt free and has cash reserves of Rs.39,000 crores. The company plans to divest 10% of its stake with a plan to raise Rs.15000 cr putting its market cap at around Rs.150,000 crores. The secondary research pegs the share price of Rs.240. At this price, the company will trade at 15 PE FY 10 earnings.</p>
<p class="last">Hence, we recommend a <b>BUY</b> on the stock.</p>
</div>
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