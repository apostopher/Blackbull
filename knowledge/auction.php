<?php
require_once("../phpinisettings.php");
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
	<meta name="Description" content="Blackbull.in knowledge article explains the Auction trading in details. Increase your stock market investment knowledge with blackbull knowledge articles."/>
	<title>Auction trading - Blackbull Investment Company</title>
	<link rel="stylesheet" href="../stylesheets/site.css" media="screen">
	<link rel="stylesheet" href="../stylesheets/knowledge/knowledge.css" media="screen">
	<script src="../javascripts/lib/modernizr-1.6.min.js"></script>
</head>
<body>
<?php require_once("../_partial_header.php"); ?>
<div id="content" data-type="Knowledge">
<div id="knowledge">
<div class="spacer">&nbsp;</div>
<aside id="leftpane">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-2413414539580695";
/* knowledge */
google_ad_slot = "9946812743";
google_ad_width = 160;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</aside>
<article id="rightpane">
<header>
<h1>Auctions in trading</h1>
</header>
<aside>
<p class="impact">This lecture will teach you the basics of Auction Trading. After reading this you will become familiar with:</p>
<ul>
<li>Basic understanding of auction system</li>
<li>Types of auctions</li>
<li>Sessions in auction</li>
</ul>
</aside>
<section>
<header>
<h3>Overview</h3>
</header>
<p>Now, we have understood about the trading module in stock market. So we will move forward to understand the Auction module.
SEBI proposes to introduce call auction market (CAM) at Over the Counter Exchange of India (OTCEI) to provide a trading platform to investors and brokers of the exchange
Clearing corporation prepares a list of short securities and sends it across all brokers/trading members who participate in the trading session on the day of Auction and place orders. A broker can place the orders of his own or his clients&#8217; orders. A Member who has failed to deliver the securities of a particular company on the pay-in day is not allowed to offer the same in auction.</p>
</section>
<section>
<header>
<h3>Auction Process in Indian Markets/Security Shortages Handling at BSE and NSE</h3>
</header>
<p>On the payin-payout day if the seller is unable to submit the shares, then he turns defaulter and those shares go into auction. This situation may arise when you may have shorted shares of ABC corporation without owning them in your demat account. Now you may pause to realise that since you have sold or shorted the shares for ABC there will be a counter party who would have bought these shares. Therefore, at the end of day the buying party will demand the shares that you have committed to sell. But you do not have any shares of ABC in your demat. In this scenario, your broker will have to purchase the shares of ABC from the Auction market and give them to the buyer.</p>
<p>This will be done as follows:</p>
<p>Let us say that you have shorted ABC corporation of shares on &#8220;T&#8221; day i e (Trading date 16 Mar 2010).So you will be responsible to deliver shares to buyer till &#8220;T + 2&#8221; day. I e ( Settlement date 18 Mar 2010). If the shares are not delivered till &#8220;T+2&#8221; day, then exchange will consider to do the auction of those shares by issuing a notice to the members informing about the names of securities short or not delivered, on &#8220;T + 3&#8221; day. I e ( Auction date 19 Mar 2010).</p>
</section>
<section>
<header>
<h3>On-Line Auctions </h3>
</header>
<p>Normally, following types of auctions are held:</p>
<ul>
<li>Normal Auction ('A' + 'B1' + 'B2' + &#8216;F&#8217;+&#8216;S&#8217; groups)</li>
<li>BDC Auction (Bad Delivery charge)</li>
</ul>
<p>All Types of Auctions are completed within Trading Hours. Auction is not permitted for Z Group scrips, which are closed out compulsorily.</p>
<p>Short Deliveries:  If a member is not able to deliver securities on the day of pay-in then it is considered as Short delivery. It happens when a speculator who sells shares that he doesn&#8217;t own (short selling) fails to square up his transaction within a trading cycle.</p>
<p>Bad Delivery:  Bad delivery exists only in the case of physical share transfers. It doesn&#8217;t exist in de-mat form of securities. If a physical transfer deed is torn, mutilated, overwritten, defaced, or if there are spelling mistakes in the name of the company or the transfer then it is considered as bad delivery.</p>
<p>Clearing agency identifies members who are fully/partially short of securities delivery on securities pay-in day and debits their account by an amount calculated at the valuation price.</p>
<p>The valuation price is the closing price of the security on the preceding trading day of securities pay-in day. Then the exchanges conduct auction to get the securities and delivers them to the buyers who have not received the securities. Auction is a separate trading mechanism which is different from the normal trading. There is separate trading session wherein brokers are allowed to quote offer prices. Unlike normal trading session, where order matching is done continuously, the quotes are captured and placed in ascending order of price and matched at the end of the session.</p>
<p>If the auction price is more than the valuation price the member who defaulted will have to pay the differing amount.</p>
</section>
<section>
<header>
<h3>Types of Sessions:</h3>
</header>
<ul>
<li><h3>Auction Offer Entry: - 11.00 a.m. to 12.00 a.m</h3>
<p>Members are allowed to enter their offers for the various scrips being auctioned during trading hours. Member can enter offers only for the scrips being auctioned during this session Subject to the following rules:</p>
<ul>
<li>The offer rate should be between the floor price and cut-off rate.</li>
<li>A defaulter for scrip cannot enter offers for that scrip.</li>
<li>Total offer quantity cannot exceed the auction quantity.</li>
</ul>
</li>
<li><h3>Matching Session: - 12.00 a.m. to 12.15 p.m.</h3>
<p>Matching of offers takes place in following way:</p>
<ul>
<li>If the total offers in the market are less than the auction quantity, then, all the offers in the market are accepted. The remaining quantity is closed out. The chances of closeout occurring are high for buyers whose quantity is less.</li>
<li>If the total offers in the market equals the auction quantity, all the offers in the market are accepted, with no requirement for closeout.</li>
<li>If the total offers in the market exceed the auction quantity, all the offers for a particular member are clubbed by rate. This is sorted on rate in ascending order. The rate at which the sum total of all the offers better than this rate exceeds the auction quantity is taken as the cutoff rate. All the offers better than this rate are considered for auction.</li>
</ul>
</li>
<li><h3>Report Download Session: - 12.15 p.m. to 1.15 p.m.</h3>
<p>The various Auction reports are downloaded during this session. This session is also provided on the next consecutive day for the settlement to be downloaded, including all latest auctions held in the previous 20 settlements.</p>
<p>During this session, the broker can download the following reports of the current Auction.</p>
<ul>
<li>Money Statement </li>
<li>Delivery Statement</li>
<li>Offer statement</li>
</ul>
<p>If the auction is a Bad Delivery Auction then two additional Reports are downloaded:</p>
<ul>
<li>Closed out Data for Bad Delivery</li>
<li>Entitlements Report</li>
</ul>
</li>
<li><h3>End of Auction: - 1.15 p.m. to 1.35 p.m.</h3>
<p>A broker can download reports of the last 20 auctions after closing session.</p>
</li>
</ul>
</section>
</article>
<div class="spacer">&nbsp;</div>
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