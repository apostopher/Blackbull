<?php
session_start();
require_once("../../phpinisettings.php");
if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass']) && isset($_COOKIE['cookid'])){
      $_SESSION['user'] = $_COOKIE['cookname'];
      $_SESSION['pass'] = $_COOKIE['cookpass'];
      $_SESSION['id'] = $_COOKIE['cookid'];
}
?>
<!DOCTYPE html>
<html class="no-js">
<head>
	<?php require_once("../../metacontent.php"); ?>
	<meta name="Description" content="Blackbull.in knowledge article explains the basics of mutual funds. know the what, why and how of mutual fund. Get the list of top performing mutual funds."/>
	<title>Mutual funds - Blackbull Investment Company</title>
	<link rel="stylesheet" href="../../stylesheets/site.css" media="screen">
	<link rel="stylesheet" href="../../stylesheets/knowledge/wh/mfbasics.css" media="screen">
	<script src="../../javascripts/lib/modernizr-1.6.min.js"></script>
</head>
<body>
<?php require_once("../../_partial_header.php"); ?>
<div id="content" data-type="Knowledge">
<div id="mfknowledge" class="clearfix">
  <aside id="adholder">
  </aside>
  <article id="articlecontent">
    <header>
      <h1>Mutual funds investment</h1>
    </header>
    <section class="deckcard">
      <h3>What is a mutual fund?</h3>
      <p>A mutual fund is an investment instrument that pools money from many investors and invests this money in stocks, bonds, short-term money market instruments or other securities. The profit obtained on this investment is then returned to investors. Mutual fund keeps some part of the profit as a commission.</p>
    </section>
    <section class="deckcard">
      <h3>How does a mutual fund work?</h3>
      <p>Before understanding the working of Mutual Fund, we should know some performance parameters in mutual fund. These are as follows:</p>
      <table cellspacing="0" cellpadding="0">
        <tbody>
          <tr><td class="termtd">Maturity</td><td>Maturity is the time interval after which the investor gets income from the money he/she invested in mutual fund.</td></tr>
          <tr><td class="termtd">ROI</td><td>It is the most important criteria for an investor at the end of the day. It is also called the return on investment.</td></tr>
          <tr><td class="termtd">Liquidity</td><td>Liquidity means the ease with which the investment product can be converted to cash or cash equivalent.</td></tr>
          <tr><td class="termtd">Unit</td><td>The whole fund is divided into units and every unit holder owned the share of the fund.</td></tr>
          <tr><td class="termtd">NAV</td><td>It is Net value of assets divided by number of units outstanding. This is the price of the unit of a fund. Every fund at initial offering is priced as Rs 10 as base price.</td></tr>
          <tr><td class="termtd">Load</td><td>It is the fee charged while buying and selling the units of a fund. The percentage of bought and sold is paid as fee.</td></tr>
        </tbody>
      </table>
      <img src="http://assets.blackbull.in/mf.png" id="mfpic" alt="Mutual fund diagram" width="460" height="200"/>
      <div class="diaglegend"><b>Diagram 1</b>&nbsp;: Basics of a mutual fund</div>
      <p>A mutual fund is a collection of stocks, bonds, debts or other securities funded by the group of investors and managed by a fund manager. The role of fund manager is to manage the money invested by the group of investors. Fund manager creates a diversified portfolio and invest the proportional amount in the different sectors. Diversified portfolio reduces the risk of losses but also limits the potential to gain substantial profits. The mutual fund does not guarantee of getting certain return, since they are always dependent on the market conditions of stock market. In simple way, they make profit by buying stocks at low price and selling the stocks at high price. Hence to be on safer side, they invest money in stocks, bonds or other securities to earn interest and dividend. This bonus money is distributed to the investors.</p>
    </section>
    <section class="deckcard">
      <h3>Types of mutual funds</h3>
      <p>Mutual funds can be classified on the basis of investment objectives and on the basis of how investors can buy/sell mutual fund units (the contribution style of a mutual fund). Following diagram illustrates these categories.</p>
      <div class="clearfix">
      <div id="leftdiagram" class="diagramdiv">
        <h4>Based on investment objectives</h4>
        <div class="parentnode">Mutual funds</div>
        <div class="line1">&nbsp;</div>
        <div class="line2">&nbsp;</div>
        <div class="lineholder clearfix">
          <div class="line3">&nbsp;</div>
          <div class="line4">&nbsp;</div>
        </div>
        <div class="clearfix">
          <div class="leftchild"><div class="children">Equity funds</div></div>
          <div class="rightchild"><div class="children">Debt funds</div></div>
        </div>
      </div>
      <div id="rightdiagram" class="diagramdiv">
        <h4>Based on contribution</h4>
        <div class="parentnode">Mutual funds</div>
        <div class="line1">&nbsp;</div>
        <div class="line2">&nbsp;</div>
        <div class="lineholder clearfix">
          <div class="line3">&nbsp;</div>
          <div class="line4">&nbsp;</div>
        </div>
        <div class="clearfix">
          <div class="leftchild"><div class="children">Open ended</div></div>
          <div class="rightchild"><div class="children">Closed ended</div></div>
        </div>
      </div>
      </div>
      <div class="diaglegend"><b>Diagram 2</b>&nbsp;: Types of mutual funds</div>
      <p>following are the types of mutual funds&nbsp;<b>Based on investment objectives.</b></p>
      <table cellspacing="0" cellpadding="0">
        <tbody>
          <tr><td class="termtd">Equity funds</td><td>These funds invest in stocks. They generally have well diversified portfolio. The diversified portfolio reduces the risk of losses. The performance of these funds is tightly coupled with market movements. Hence their unit price volatility is high. Some equity funds invest only in perticular sector such as infrastructure. Thus their performance depends significantly on the performane of the sector which they invest in.</td></tr>
          <tr><td class="termtd">Debt funds</td><td>These funds invest in debt instruments such as corporate bonds, debentures and government certificates. As these funds invest in less volatile instruments, their unit prices are more stable than that of equity funds. The risk and reward factor of these funds are low compared to equity funds.</td></tr>
        </tbody>
      </table>
      <p>Some funds invest in equity as well as debt instruments. These funds are called balanced funds or hybrid funds. Because of their balanced nature, they tend to give moderate returns over long time. These funds are suited for investors with less risk apetite.</p>
      <div id="mfmiddle">
      <script type="text/javascript"><!--
        google_ad_client = "ca-pub-2413414539580695";
        /* mfmiddle */
        google_ad_slot = "0191014020";
        google_ad_width = 728;
        google_ad_height = 90;
        //-->
        </script>
        <script type="text/javascript"
          src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
        </script>
      </div>
      <p>following are the types of mutual funds&nbsp;<b>Based on contribution.</b></p>
      <table cellspacing="0" cellpadding="0">
        <tbody>
          <tr><td class="termtd">Open ended funds</td><td>Open ended funds are those funds where units are bought and sold at NAV throughout the Year. They do not have fixed maturity period and number of units may vary due to volatility. This funds differ from closed ended fund in terms of number of shares is not limited. It does not have fixed capitalization and it is characterized by continual selling and redeeming of shares.</td></tr>
          <tr><td class="termtd">Closed ended funds</td><td>Closed ended fund is a fund where growth is limited in terms of the number of shares. The investors need to wait till maturity before they can redeem their units of the fund. The fund is buyable till specified period, after that sale is closed. If you want to purchase after specified time period, then you should go to secondary market and buy at NAV provided that fund is listed.</td></tr>
          <tr><td class="termtd">SIP</td><td>A systematic investment plan is one where an investor are required to buy units at a fixed amount at specific intervals of time and at the prevailing NAV. The units are credited to his account. Thus in SIP investors buy unit irrespective of market conditions or NAV.</td></tr>
        </tbody>
      </table>
      <p></p>
    </section>
    <section class="deckcard">
      <h3>Why should I invest in a mutual fund?</h3>
      <p>Following are the benefits of investing in a mutual fund.</p>
      <ul>
      <li><h5>Professional management</h5>
      <p>Alone you cannot manage your portfolio due to the time constraints and lack of knowledge. Since the market is very volatile and depends on various factors. So a Fund manager of a mutual fund does the fundamental and technical analysis of stocks and invests in those stocks that give good returns to investor.</p>
      </li>
      <li><h5>Low cost to start investment</h5>
      <p>An individual investor generally needs lot of capital to create a well divercified portfolio. A mutual fund enables investors to participate in a diversified portfolio for a low cost.</p>
      </li>
      <li><h5>Transparency</h5>
      <p>Mutual funds alway publish their portfolio. Thus an investor knows in which stocks or intruments his/her money is invested.</p>
      </li>
      <li><h5>Liquidity</h5>
      <p>Investors can redeem their money from mutual fund within 3-4 working days. Thus liquidity of most mutual funds is very high.</p>
      </li>
      <li><h5>Tax benefits</h5>
      <p>Some mutual funds provide tax benefits under section 80C. These funds generally have a locking period and hence their liquidy is low.</p>
      </li>
      </ul>
    </section>
    <section class="deckcard">
      <h3>How do I select a mutual fund?</h3>
      <p>The following are the factors need to be considered before investing in mutual fund</p>
      <ul>
        <li>Hidden expenses</li>
        <li>Management of the fund</li>
        <li>Units and offer</li>
        <li>Dividends and Distributions</li>
        <li>NAV History</li>
        <li>Past returns</li>
        <li>Read the Offer document carefully</li>
      </ul>
    </section>
    <section class="deckcard">
      <h3>Top performing mutual funds in india</h3>
      <p>Following is the list of top performing mutual funds in india as on <time class="dtperf" datetime="2011-22-12">January 22<sup>nd</sup>, 2011</time></p>
      <div class="clearfix">
      <div id="ulholder">
      <ul>
        <li>Birla Sun Life Frontline Equity</li>
        <li>Canara Robeco Equity Tax Saver</li>
        <li>DSPBR Micro Cap Reg</li>
        <li>Fidelity Equity</li>
        <li>Franklin India Bluechip</li>
        <li>HDFC Taxsaver</li>
        <li>ICICI Prudential Discovery</li>
        <li>IDFC Imperial Equity Plan A</li>
        <li>Reliance Equity Opportunities</li>
        <li>Templeton India Equity Income</li>
        <li>UTI Equity</li>
      </ul>
      </div>
      <div id="sqadholder">
        <script type="text/javascript"><!--
          google_ad_client = "ca-pub-2413414539580695";
          /* mfrectangle */
          google_ad_slot = "6777105025";
          google_ad_width = 336;
          google_ad_height = 280;
          //-->
        </script>
        <script type="text/javascript"
          src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
        </script>
      </div>
      </div>
    </section>
    <div id="disqus_thread"></div>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    var disqus_shortname = 'blck'; // required: replace example with your forum shortname

    // The following are highly recommended additional parameters. Remove the slashes in front to use.
    var disqus_identifier = 'mfbasics';
    var disqus_url = 'http://blackbull.in/knowledge/wh/mfbasics.php';

    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>

  </article>
</div>
</div>
<?php require_once("../../_partial_footer.php"); ?>
<?php require_once("../../jslibs.php"); ?>
<?php require_once("../../analyticstracking.php"); ?>
</body>
</html>