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
	<link rel="stylesheet" href="../stylesheets/articles/articles.css" media="screen">
	<script src="../javascripts/lib/modernizr-1.5.min.js"></script>
</head>
<body>
<?php require_once("../_partial_header.php"); ?>
<div id="content" data-type="Articles">
<div id="article">
<div class="spacer">&nbsp;</div>
<aside id="leftpane">&nbsp;</aside>
<article id="rightpane">
<header>
<h1>Dragon Empire</h1>
</header>
<section>
<p><span class="dropcap">H</span>ow do you know China? A country with the largest human population; the quiet Indian neighbor; land of the finger-licking Chinese cuisine; - the list is endless. All of these are true perceptions but China is more. China is bigger. And China is powerful.</p>
<p>The powerful aspect of the Dragon empire emerges from its substantial economic impact. Post the sub prime crisis that brought the US and EU to its knee, China has been touted as the world's growth engine. The belief is not completely unfounded. The nation has a huge consumer market and is extremely gungho about building its infrastructure. The Chinese have already spent vast sums in during the Beijing Olympics. The Chinese have also pumped in close to $600 bn in 2008 as stimulus in its economy.</p>
</section>
<section>
<header>
<h3> The US-China trade relations</h3>
<header>
<p>The US too recognizes the immense potential of the Chinese markets. China carries the largest bilateral trade with US. The US companies have over 100 jointly managed ventures working in the Chinese mainland. The US concerns have over $40 bn invested in the Chinese corporations both as debt and equity. This plainly paints a picture where an emerging power is gaining its due recognition.</p>
<p>But it is not all rosy. The Chinese government since 2008 has been under constant flak from the world economies and especially the US about manipulating its currency - the Yuan. The allegations accuse Chinese rule to be deliberately keeping the yuan undervalued.</p>
<p>So how does China do it? And moreover WHY does it do it?</p>
<p>China is not the only country that tries to control its currency. Every nation, to differing extents, controls its currency. Each Central bank has a price band in mind. As long as its currency oscillates within that band, the government does not intervene. But as soon as the currency breaches the band, the government steps in to bring the currency back to its home.</p> 
<p>Now if all governments does it then why does China's actions catch the limelight?</p>
</section>
<section>
<header>
<h3>The yuan story</h3>
</header>
<p>China runs the greatest trade surpluses ( difference between imports and exports) with all the major developed economies. Chinese products are actively sold in almost all developed countries. Therefore, given the huge amount of capital that gets ties to Chinese trade exerts substantial pressure on the countries currency movement against Yuan. Since most countries can't completely ban the Chinese products, they therefore resolve to political and economic firms to create international pressure on China to free the yuan.</p>
<p>Let me explain this point through a more familiar example. All of us use mobile phones. And most of our phones belong to either European or American companies. However, if we take a look at the phone batteries, we would find them to be Made in China. And almost 98% of phone batteries are made by the Dragon Empire. This means that all these American companies source their batteries from China. Now, lets imagine how this transaction would be done. There will be some Chinese company that will manufacture the battery. All its raw material is locally available. The entire cost of making the battery is in yuan- the Chinese currency. This Chinese company then sells the batteries to an American company. However, this time he bills it in US $. The dollars will come in China and be exchanged for yuans and paid to the Chinese company. So, the Chinese company's profit depends on the exchange rate of dollars and yuan. It is an easy guess that the Chinese company is going to benefit the more yuans that it receives for the dollar - which in economic terms says that the Chinese company will benefit from a weak yuan.</p>
<p>This example answers the WHY part. Unlike India, China is an exports driven economy. The Chinese today manufactures almost every single unbranded product that you can imagine. These manufacturers then export these Chinese product to its trade partners - namely every single developed and emerging economy. The whole Chinese growth engine depends on exports. Therefore, the lower the yuan the better it is for the Chinese exporters. Basically, if 1 Dollar buys 10 Yuans, and a Chinese exporter sells a battery for 10 dollars. He pockets 100 yuans. But if one Dollar was worth only 5 Yuans, the exporter would only be able to pocket 50 yuans.</p>
<p>Well the case is pretty clear as to why China wants to keep the Yuan undervalued. Let us now turn to second piece of puzzle - HOW does China do it?</p>
</section>
<section>
<header>
<h3>Controlling yuan</h3>
</header>
<p>The Chinese government does it through a mix of direct and indirect measures. The Chinese Central Bank is the largest buyer of dollars in the open markets. The Chinese banks buy dollars in the proportion of their trade surplus to keep the yuan undervalued. The Chinese hold the largest amount of forex reserves in US dollars. Moreover, The Chinese are always seen as the largest buyer in US auctions. This deliberate buying of US dollars by the Chinese has created a huge dollar bank with them. This allows the bank to easily influence the Us currency by controlling the supply of the dollars in the markets.</p>
<p>Now if you take a minute and imagine this whole scheme of things, you will realize the helplessness of the US. The US companies have been badly bruised by the sub prime crisis. So they need to cut costs desperately. This makes them rely on the cheap Chinese imports. Given the weak Yuan, these Chinese imports become very cost competitive to US companies. This creates a guaranteed supply of dollars to China. Now, the US government has already issued close to $700 bn stimulus. This has weakened the government financial health. The US government would soon have to suck this money back. For this to happen sooner, the US consumer and the corporates must return to normalcy. Hence, the US can't ban the cheap Chinese imports. Secondly, the Chinese government in turn go and buy more dollars from the market to exert further pressure on the dollar. Moreover, the Chinese government also goes and invests the dollars earned in the US Treasury bonds. This makes those dollars earn even more dollars in interest. So you see, it is a vicious circle that feeds on itself and keeps the yuan undervalued.</p>
<p class="last">So, the next time you witness US frustration over Chinese currency, you know what they are talking about!</p>
</section>
</article>
<div class="spacer">&nbsp;</div>
</div>
</div>
<?php require_once("../_partial_footer.php"); ?>
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.4/jquery-ui.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
<script src="../javascripts/lib/jquery.jcryption-1.1.min.js"></script>
<script src="../javascripts/site.js"></script>
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