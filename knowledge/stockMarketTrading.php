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
	<link rel="stylesheet" href="../stylesheets/knowledge/knowledge.css" media="screen">
	<script src="../javascripts/lib/modernizr-1.5.min.js"></script>
</head>
<body>
<?php require_once("../_partial_header.php"); ?>
<div id="content" data-type="Knowledge">
<div id="knowledge">
<div class="spacer">&nbsp;</div>
<aside id="leftpane">&nbsp;</aside>
<article id="rightpane">
<header>
<h1>The stock market trading</h1>
</header>
<aside>
<p class="impact">This lecture will teach you the basics of Stock Market trading. After reading this you will become familiar with:</p>
<ul>
<li>Sessions of stock market trading</li>
<li>How does Trade happen in exchange</li>
<li>Different types of orders</li>
<li>Terminology in Stock market trading</li>
</ul>
</aside>
<section>
<header>
<h3>Overview</h3>
</header>
<p>With the growing importance of digital technology and the internet, many investors are opting to buy and sell stocks for themselves rather than pay advisors large commissions for research and advice. However, before you can start buying and selling stocks, you must know the different types of sessions and orders and when they are appropriate.</p>
</section>
<section>
<header>
<h3>Types of Sessions</h3>
</header>
<ul>
<li><span class="lihead">Login Session</span><span class="lidate">8.30 a.m. to 9.00 a.m.</span><p>Members are allowed to login after 9.00 a.m.  During this session, members will not be allowed to enter orders. Members can do the batch upload of orders during this session. However the batch submission of these orders can be done only in the continuous session. Members can also download the Broker (BRK), Trader files (TRD) of the previous 5 settlements and Auction files for the previous 25 settlements.</p>
<li><span class="lihead">Continuous Trading Session</span><span class="lidate">9.00 a.m. to 3.30 p.m.</span><p>During this session, all types of orders are allowed to be entered into the system and the users can carry on all their trading activities. The user receives confirmations of the trades executed by him and can also view his net-position and break-even position in scrip. Also, he can receive the latest market information and news.</p></li>
<li><span class="lihead">Closing Session</span><span class="lidate">3.30 p.m. to 3.40 p.m.</span><p>The closing price of scrips is computed during this session. At the end of the session, the computed closing price for each scrip is displayed in the Touchline window.</p></li>
<li><span class="lihead">Post Closing Session</span><span class="lidate">3.40 p.m. to 4.00 p.m.</span><p>This session is held after the closing session and is meant for matching orders at closing price only. The user can enter only Limit orders at Closing Price which would be matched at the closing price. Any limit order other than those at closing price would not be accepted. The user has to enter Retention Flag as EOSESS (End of session) for order. User cannot enter market order, Stop-loss order and Basket orders. All unmatched orders will be returned.</p><p>In Trade window, Client code rectification is allowed ONLY in this session. Members can modify the client code for orders in this session.</p></li>
<li><span class="lihead">Member Query Session</span><span class="lidate">4.00 p.m. to 6.00 p.m.</span><p>In this session, the system generates member-wise, trader level reports. In this session members are allowed to download and get the break-up of trader-wise trade details.  Member-Query window is a function provided in the main menu. This window displays the trades of all the traders executed during the day. Members download the Trader & Broker files. TRD file can be downloaded by all the traders / sub-brokers (provided Admin Terminal has given permission) and this report will contain self-trades only.  Main Member can download BRK file, which contain trader-wise details.</p><p>When all trades have been received, a check is initiated to detect any error receiving trades. A warning message is displayed in case of an error and Query would have to be reinitiated. If all the trades have been received successfully, a message is displayed indicating the file in which the data has been stored.</p><p>This file is created in the Export sub-directory and is in the BRddmmyy.dat format. Members query is normally allowed from TWS No.1.</p><p>In this session, members are allowed to enter and custodians confirm the 6A/7A entries.  Auction reports for the previous 25 settlements can also be downloaded in this session.</p></li>
</ul>
</section>
<section>
<header>
<h3>Types of Orders</h3>
</header>
<ul>
<li><span class="lihead">Limit Order</span><p>A limit order sets the maximum or minimum price at which you are willing to buy or sell. 
For example, if you wanted to buy a stock at 100 Rs, you could enter a limit order for this amount. This means that you would not pay a paisa over 100 Rs for the particular stock. It is still possible, however, that you buy it for less than the 100 Rs.</p><p>Conditions related to time can be easily made into a limit order, which are as follows:</p>
<ul>
<li><b>Good Till Canceled</b> (GTC): A GTC order is the order that remains in the system for a period not exceeding one calendar week or the member cancels it.</li>
<li><b>Good for Day</b> (GFD): A GFD is the order, which is valid for the day on which it is entered. If the order is not matched during the day, the order gets cancelled automatically at the end of the trading day.</li>
<li><b>Good till Date</b> (GTD): A GTD order allows the member to specify the number of days not exceeding one calendar week for which the order shall stay in the stay in the system. At the end of this period the order shall be deleted from the system.</li>
</ul>
</li>
<li><span class="lihead">Market Order</span><p>A market order is an order to buy or sell immediately at the best available price. These orders do not guarantee a price, but they do guarantee the order's immediate execution. Typically, if you are going to buy a stock, then you will pay a price near the posted sell price. If you are going to sell a stock, you will receive a price near the posted buy price.</p>
<p>One important thing to remember is that the last-traded price is not necessarily the price at which the market order will be executed. In fast moving and volatile markets, the price at which you actually execute (or fill) the trade can deviate from the last-traded price. The price will remain the same only when the bid and ask prices are exactly at the last-traded price. Market orders are popular among individual investors who want to buy or sell a stock without delay. Although the investor doesn't know the exact price at which the stock will be bought or sold, market orders on stocks that trade over tens of thousands of shares per day will likely be executed close to the bid and ask prices.</p>
<p><b>Market protection price</b> is a term associated with Market orders. Market protection is always in percentage. The "protection price" would be calculated by the system every time a market order is placed. The protection price would be a fixed percentage of the touchline price, depending upon the categorization of that scrip, at the time the market order was placed.</p>
<p>For bid orders, protection price would be added to the touch-line offer price, and for market ask orders, protection would be deducted to touch-line bid price. After attaching the protected price to the market order, this order would be executed like any other order.</p>
<p>For example,</p>
<p>Broker X places a market order for buying 1000 shares of scrip RIL at Market Protection of 1%. The touch-line on his screen while placing the order is Rs. 200 quantity at Rs. 90 (offer) and 500 quantity at Rs. 90.90 (offer). In this case, the protection price would be Rs. 90.90 i.e. Rs. 90 (being the touchline offer price) + 1%.</p>
<p>Broker X's market order would thus get executed as under:</p>
<ul>
<li>200 shares at Rs.90 against Broker Y</li>
<li>500 shares at Rs.90.90 against Broker Z</li>
</ul><p>Since there are no more offers, the remaining 300 quantity will be stored as Limit order at the buy rate of Rs.90.90, which is the Last Traded Price.</p><p>Knowing the difference between a limit and a market order is fundamental to individual investing.</p></li>
<li><span class="lihead">Stoploss Order</span><p>Also referred to as a stopped market, on-stop buy, or on-stop sell, this is one of the most useful orders. This order is different because - unlike the limit and market orders, which are active as soon as they are entered - this order remains dormant until a certain price is passed, at which time it is activated as a market order.</p>
<p>Suppose an investor has bought some shares at some price and now the prices suddenly starts going down, that means that he is suffering losses. With this system the investor can square up his position in the market by putting an opposite sell order. This enables him to square off easily without having to execute his orders manually while keeping a close watch on market movements.</p>
<p>This facility reduces risk and stops further loss. Trader can square up their position in the market by putting an opposite order, when there is a fluctuation in the scrip prices. This enables trader to square off easily without having to execute their orders manually while keeping a close watch on market movements.</p>
<p>The un-triggered stop-loss orders can be removed / changed. After getting triggered, these orders are converted into normal orders and are displayed in the pending order window. These can be changed or removed in the same way as normal pending orders. The trades executed against stop-loss orders, can be viewed from the Trade window screen.</p> 
<p>While entering Stoploss Orders, you will have to enter 2 prices - the Trigger price and the Limit price. In case of a buy stoploss order, Trigger price must be less than or equal to the Limit price. In case of a sell stoploss order, Trigger price must be greater than or equal to the Limit price.</p>
<p>The buy stop loss orders will be activated when the "Last Traded Price" of the scrip becomes equal to or greater than the "Trigger Price" of the stop loss order.</p>
<p>The sell stop loss orders will be activated when the "Last Traded Price" of the scrip becomes equal to or less than the "Trigger Price" of the stop loss order.</p>
<p>The order will have two rates: the Limit price entered by the member, and the System price which will be decided by the system by applying the circuit filter limits on the day on which the order gets triggered.</p>
<p>These orders get activated in the order of Trigger price and timestamp.</p>
</li>
<li><span class="lihead">Buy Minimum (TAKE) & Sell Minimum (HIT) Orders</span><p>This is a variation of the market orders. It allows for faster order execution without cluttering up the limit order book. Minimum fill/rest kill is a facility provided for quick order execution. To make a quick deal, select scrip and enter the quantity and minimum fill quantity. Click on the HIT or TAKE button as per the requirement. The order will be matched at touchline price to a quantity available in the market.  The unexecuted quantity of the order will be killed. When the Order Entry screen is in the Buy mode, only Buy minimum will be permitted and vice-versa. Note that rate is not allowed in these orders.</p></li>
<li><span class="lihead">Drip Feed Order</span><p>A Drip Feed Order is an order in which the member has the option to specify a replenish quantity along with the total order quantity. Only the replenish quantity is revealed to the market. The quantity gets replenished only when the previous quantity has got traded and every time the quantity gets replenished, the visible quantity gets a new time stamp.</p></li>
<li><span class="lihead">Odd Lot order</span><p>Any share quantity, which is not a market lot or multiple of market lots, shall be called Odd Lot. While matching the system would match orders only if the quantity (odd) of the order is fully satisfied by one of the opposite order. This is done to allow small investors to deliver physical shares, in scrips mandated for compulsory dematerialized trading, up to Rs 25,000 in value or 500 shares in number. The system will place orders for the sale or purchase of these physical shares despite the compulsory demat mandate.</p></li>
<li><span class="lihead">Block Deal Order</span><p>A block deal is a deal where a minimum quantity of 5 lakh shares or shares with a minimum value of Rs 5 cr are transacted through a single transaction window. A block deal happen through a separate window provided by the stock exchange. This window is open for only 35 minutes but bulk deals take place throughout the trading day. There is always a need for two parties for a block deal to take place, however, bulk deals are market driven. Transaction price of a share ranges from +1% to -1% of the previous day's closing or the current market price. These transactions take place on delivery basis.</p></li>
<li><span class="lihead">Basket Order</span><p>In the stock market, an investor can trade a large number of stocks with just a single order entry, and this is often referred to as "basket trading". This is particularly useful for large institutional investors who are always making trades in the market. They can thus put all of this large number of trades under one basket through a single order entry. For basket trading however, the trader or the investor must be trading in a minimum number of stocks. And not just trade, the basket allows the trader to track and manage the stocks better as well. Basket trading is done by large institutional investors.</p></li>
</ul>
</section>
<section>
<header>
<h3>Trade execution</h3>
</header>
<p>As an investor one would definitely like to know what happens after placing an Order in the system:</p>
<p>After the orders placing, the orders are accepted by the exchange, the exchange then sends a confirmation to the trader in the form of OrderId which a unique number.</p>
<p>Subsequently, the exchange receives the orders from the traders and then it matches appropriately to generate the trade.</p>
<p>There are five Best bids and Offer bids for a RIL in the market picture screen. The concept of matching the orders can be realised by the below table:-</p>
<p>The Best five bids and offers are displayed as follows:</p>
<table class="datatable" cellspacing="0" cellpadding="0">
<thead>
<tr>
<th>Best Bid Quantity</th>
<th>Best Bid Price</th>
<th>Best Offer Quantity</th>
<th>Best Offer Price</th>
</tr>
</thead>
<tfoot>
<tr>
<td colspan="4"></td>
</tr>
</tfoot>
<tbody>
<tr>
<td>150</td>
<td><span class="chapter_blu">2165.00</span></td>
<td>150</td>
<td><span class="chapter_orange">2165.70</span></td>
</tr>
<tr>
<td>150</td>
<td><span class="chapter_blu">2164.90</span></td>
<td>900</td>
<td><span class="chapter_orange">2166.00</span></td>
</tr>
<tr>
<td>150</td>
<td><span class="chapter_blu">2164.65</span></td>
<td>1050</td>
<td><span class="chapter_orange">2166.90</span></td>
</tr>
<tr>
<td>150</td>
<td><span class="chapter_blu">2164.45</span></td>
<td>150</td>
<td><span class="chapter_orange">2166.95</span></td>
</tr>
<tr>
<td>150</td>
<td><span class="chapter_blu">2164.05</span></td>
<td>150</td>
<td><span class="chapter_orange">2167.65</span></td>
</tr>
</tbody>
</table>
<p>Here the best bid price available is <span class="chapter_blu">2165.00</span> and the best offer price is <span class="chapter_orange">2165.70</span>.
The best match for any buy order received in the system will be <span class="chapter_orange">2165.70</span> and similarly for the sell order it will be <span class="chapter_blu">2165.00</span></p>
<p>Order Matching will take place after order acceptance where in the system will search for a best available opposite matching order. If a match is found, a trade will be generated. The order against which the trade has been generated will be removed from the system. In case the order is not exhausted further matching orders will be searched for and trades generated till the order gets exhausted or no more match-able orders are found. If the order is not entirely exhausted, the system will retain the order in the pending order book. Matching will be in the priority of price and timestamp. A unique trade-id will be generated for each trade and the entire information of the trade will be sent to the members involved.</p>
</section>
<section>
<header>
<h3>Terminology in stock market</h3>
</header>
<ul>
<li><span class="lihead">Open rate</span><p>It is the very first trade generated in the continuous trading session for scrip. If the scrip's not traded in this session then its Open Price remains zero, till the scrip gets traded.</p></li>
<li><span class="lihead">Weighted average rate (WAR)</span><p>WAR is calculated as multiplication of number of shares traded and last traded price divided by summation of total number of shares for last 30 minutes.</p><p>For example,</p>Assume that for particular scrip having a market lot of 100 shares, the following trades had taken place during the last 30 minutes before market closure at 3.30 p.m.</p>
<ul>
<li>at 3:29 p.m. 400 shares traded at Rs.32.00</li>
<li>at 3.25 p.m., 300 shares traded at Rs. 31.00</li>
<li>at 3.17 p.m., 500 shares traded at Rs. 32.50</li>
<li>at 3.02 p.m., 200 shares traded at Rs. 31.50</li>
</ul>
<p>The weighted average price of all trades during the last 30 minutes is calculated as follows:</p>
<table class="formula" cellspacing="0" cellpadding="0" border="0">
<tbody>
<tr><td class="numerator">(400 x 32.00) + (300 x 31.00) + (500 x 32.00) + (200 x 31.25)</td><td rowspan="2">= Rs. 31.89</td></tr>
<tr><td>400 + 300 + 500 + 200</td></tr>
</tbody>
</table>
<p>The weighted average price of Rs. 31.89 is rounded off to the nearest tick, i.e. Rs. 0.05 for this price range, and therefore, the official closing price for this scrip would be taken as Rs. 31.90.</p>
</li>
<li><span class="lihead">Close rate</span><p>Close rate is weightage average rate for the last 30 minutes. If the scrip is not traded for a day, then the closing price is the previous close rate. If only one trade has taken place, then close price is the last traded price.</p></li>
<li><span class="lihead">Circuit filters</span><p>Circuit filter is a real-time surveillance tool to control excessive volatility of particular scrip.  The Exchange decides the circuit filter percentage from time to time. The present Circuit filter percentage is given below to indicate that the price for particular scrip in a particular group should not vary beyond the specified percentage of the previous day's closing price (plus or minus) in a day.</p></li>
<li><span class="lihead">Daily Circuit Filters</span><p>These Daily Circuit Filters are applied to control the volatility of scrip in a day.  They are expressed on percentage on previous day's closing price.  For example, if a particular scrip has Rs. 30/- as last day's closing price and the Daily Circuit Filter limit is 20%, then the price can vary between Rs. 33/- (Rs.30/- + 3/-) or Rs.27/- (Rs. 30/- - 3/-).</p></li>
</ul>
<table class="datatable" cellspacing="0" cellpadding="0">
<thead>
<tr>
<th>Scrip Price</th>
<th>Circuit Filter %</th>
<th>Relaxation</th>
</tr>
</thead>
<tfoot>
<tr>
<td colspan="3"></td>
</tr>
</tfoot>
<tbody>
<tr>
<td>53 scrips on which derivative<br/> products are available.</td>
<td>Dummy 20%</td>
<td>20% further on reaching the first 20%.</td>
</tr>
<tr>
<td>All other Scrips</td>
<td>20%</td>
<td>No relaxation</td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
</section>
<footer>
<h3>resources</h3>
<ul>
<li><a href="http://en.wikipedia.org/wiki/Order_%28exchange%29">Market orders on wikipedia</a>(http://en.wikipedia.org/wiki/Order_%28exchange%29)</li>
<li><a href="http://www.investopedia.com/articles/stocks/09/use-stop-loss.asp">The Stop-Loss Order - Make Sure You Use It</a>(http://www.investopedia.com/articles/stocks/09/use-stop-loss.asp)</li>
</ul>
</footer>
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
<!--script src="http://ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script-->
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