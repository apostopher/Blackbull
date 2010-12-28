<?php
session_start();
require_once("../phpinisettings.php");
if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass']) && isset($_COOKIE['cookid'])){
      $_SESSION['user'] = $_COOKIE['cookname'];
      $_SESSION['pass'] = $_COOKIE['cookpass'];
      $_SESSION['id'] = $_COOKIE['cookid'];
      $_SESSION['user_id'] = $_COOKIE['user_id'];
      $_SESSION['portfolio_id'] = $_COOKIE['portid'];
}
if(!isset($_SESSION['user_id']) || !isset($_SESSION['portfolio_id'])){
        $_SESSION['redirect'] = $_SERVER['PHP_SELF'];
	header( "Location: http://www.blackbull.in/tracker/trackerlogin.php" );
}
$key = sha1(microtime().$_SESSION['user_id'].$_SESSION['portfolio_id']);
$_SESSION['csrf'] = $key;
?>
<!doctype html>  

<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>Portfolio Manager</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
  <link href='http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="css/_tracker_header.css?v=2">
  <link rel="stylesheet" href="css/style.css?v=2">
  <!--script type="text/javascript">
    var cjsscript = document.createElement('script');
    cjsscript.src = "/tracker/js/mylibs/control.js";
    var cjssib = document.getElementsByTagName('script')[0];
    cjssib.parentNode.insertBefore(cjsscript, cjssib);
  </script-->
  <script src="js/libs/modernizr-1.6.min.js"></script>

</head>

<body>

  <div id="container" class="<?php echo $_SESSION['user_id']; ?>">
    <?php include_once("_tracker_header.php"); ?>
    <div id="main">
      <div id="marketholder" class="clearfix">
        <h1>Portfolio Manager</h1>
        <div id="sensex" class="market">
          <h3>Sensex</h3>
          <div class="indexvalue">&nbsp;</div>
          <div class="indexchange">&nbsp;</div>
        </div>
        <div id="nifty" class="market">
          <h3>Nifty</h3>
          <div class="indexvalue">&nbsp;</div>
          <div class="indexchange">&nbsp;</div>
        </div>
        <div id="welcomediv">Welcome&nbsp;<?php echo $_SESSION['user']; ?></div>
      </div>
      <div id="foliosummary" class="clearfix" rel="<?php echo $_SESSION['portfolio_id']; ?>">
        <div class="summarysection">
          <h4>Invested Capital</h4>
          <span class="legend">( in Rs. )</span>
          <div class="sectionbody">
            <span class="key">In Market:</span>
            <span id="marketvalue" class="value">Loading&hellip;</span><br/>
            <span class="key">In Cash:</span>
            <span id="cashvalue" class="value">Loading&hellip;</span>
          </div>
        </div>
        <div class="summarysection">
          <h4>Portfolio Networth</h4>
          <span class="legend">( in Rs. )</span>
          <div class="sectionbody">
            <span class="longkey">Net Value:</span>
            <span id="netvalue" class="value">Loading&hellip;</span><br/>
            <span class="longkey">Unrealized Returns:</span>
            <span id="ureturn" class="value">Loading&hellip;</span>
          </div>
        </div>
      </div>
      <div id="formholder" class="clearfix">
        <span id="addtransa"><a href="javascript:void(0);">Add Transaction</a><span>&nbsp;</span></span>
        <span id="nullspan">&nbsp;</span>
        <span id="managecasha"><a href="javascript:void(0);">Manage Cash</a><span>&nbsp;</span></span>
        <div id="cashfrmholder" class="clearfix">
          <form id="managecashform" action="/serverscripts/portfolio/managecash.php" method="post">
            <input name="cashcsrf" id="cashcsrf" type="hidden" value="<?php echo $key; ?>"/>
            <input name="cashuser_id" id="cashuser_id" type="hidden" value="<?php echo $_SESSION['user_id']; ?>"/>
            <div class="formsection posrel firstsection">
              <label for="trans_scrip">Amount</label>
              <input name="cashinrs" id="cashinrs" class="rupee" type="text"/>
              <label for="cash_type">Type</label>
              <div class="clearfix">
                <select name="cash_type" id="cash_type">
                  <option value="1">DEPOSIT</option>
                  <option value="-1">WITHDRAW</option>
                </select>
              </div>
              <label for="cash_date">Date</label>
              <input name="cash_date" id="cash_date" type="date" class="dateinput" value="<?php echo date('Y-m-d'); ?>"/>
            </div>
            <div class="formsection lastsection">
            <label for="cash_notes">Notes (optional)</label>
            <textarea name="cash_notes" id="cash_notes" type="text" placeholder="Notes"></textarea>
            <div class="clearfix">
              <input id="cashsubmitbtn" type="submit" value="Submit"/>
              <input id="cashcancelbtn" type="reset" value="Clear"/>
            </div>
            <div id="cashresulttxt" class="hidden"></div>
          </div>
          </form>
        </div>
        <div id="formslide" class="clearfix">
        <form id="addTransform" action="/serverscripts/portfolio/addTransaction.php" method="post">
          <input name="csrf" id="csrf" type="hidden" value="<?php echo $key; ?>"/>
          <input name="user_id" id="user_id" type="hidden" value="<?php echo $_SESSION['user_id']; ?>"/>
          <input name="trans_qscrip" id="trans_qscrip" type="hidden"/>
          <div class="formsection posrel firstsection">
            <label for="trans_scrip">Stock Name</label>
            <input name="trans_scrip" id="trans_scrip" type="text"/>
            <div id="autoresults" class="hidden"></div>
            <label for="trans_type">Type</label>
            <div class="clearfix">
            <select name="trans_type" id="trans_type">
              <option value="1">BUY</option>
              <option value="-1">SELL</option>
            </select>
            <input type="checkbox" name="includecash" id="includecash"/>
            <span id="includetxt">Deduct from cash</span>
            </div>
            <label for="trans_date">Date</label>
            <input name="trans_date" id="trans_date" type="date" class="dateinput" value="<?php echo date('Y-m-d'); ?>"/>
          </div>
          <div class="formsection">
            <label for="trans_price">Stock Price (<a id="cmpa" href="javascript:void();">Get Price</a>)</label>
            <input name="trans_price" id="trans_price" type="text" class="rupee"/>
            <label for="trans_qty">Quantity</label>
            <input name="trans_qty" id="trans_qty" type="text"/>
            <label for="stoploss">Stop loss (optional)</label>
            <input name="stoploss" id="stoploss" type="text" class="rupee"/>
          </div>
          <div class="formsection lastsection">
            <label for="trans_notes">Notes (optional)</label>
            <textarea name="trans_notes" id="trans_notes" type="text" placeholder="Transaction notes"></textarea>
            <div class="clearfix">
              <input id="submitbtn" type="submit" value="Add Transaction"/>
              <input id="cancelbtn" type="reset" value="Clear"/>
            </div>
            <div id="resulttxt" class="hidden"></div>
          </div>
      </form>
      </div>
      </div>
      <div id="porttableholder">
        <div class="headdiv clearfix">
          <div class="first">Name</div>
          <div class="ltp">LTP<br/><span class="legend">( in Rs. )</span></div>
          <div class="avgbuy">Avg. buy price<br/><span class="legend">( in Rs. )</span></div>
          <div class="tradeqty">Quantity</div>
          <div class="profitloss">Gain / Loss<br/><span class="legend">( in Rs. )</span></div>
        </div>
      </div>
    </div>
    
    <footer>
      <div id="footercontent">
        <div class="contactme"><a href="mailto:apostopher@gmail.com?Subject=Blackbull%20Portfolio">Contact me</a></div>
        <div class="copy">&copy; 2011 Blackbull inc. | All rights reserved. |&nbsp;<a href="http://blackbull.in/legal.php">Legal</a></div>
      </div>
    </footer>
  </div> <!-- end of #container -->


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
  <script>!window.jQuery && document.write(unescape('%3Cscript src="js/libs/jquery-1.4.4.min.js"%3E%3C/script%3E'))</script>
  <script src="http://cdn.jquerytools.org/1.2.5/all/jquery.tools.min.js"></script>
  <script src="/tracker/js/mylibs/sprintf-0.6.js"></script>
  
  <!-- scripts concatenated and minified via ant build script-->
  <!-- script type="text/cjs" cjssrc="js/plugins.js"></script-->
  <script src="js/script.min.js"></script>
  <!-- end concatenated and minified scripts-->
  
  
  <!--[if lt IE 7 ]>
    <script src="js/libs/dd_belatedpng.js"></script>
    <script> DD_belatedPNG.fix('img, .png_bg'); </script>
  <![endif]-->  
</body>
</html>