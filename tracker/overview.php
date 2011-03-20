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
  <link rel="stylesheet" href="http://blackbull.in/tracker/css/_tracker_header.css?v=2">
  <link rel="stylesheet" href="http://blackbull.in/tracker/css/overview.css?v=2">
  <script src="http://platform.twitter.com/anywhere.js?id=6sc7IQII9HjLH9dXJKCUw&amp;v=1"></script>
  <!--script type="text/javascript">
    var cjsscript = document.createElement('script');
    cjsscript.src = "/tracker/js/mylibs/control.js";
    var cjssib = document.getElementsByTagName('script')[0];
    cjssib.parentNode.insertBefore(cjsscript, cjssib);
  </script-->
  <script src="http://blackbull.in/tracker/js/libs/modernizr-1.6.min.js"></script>

</head>

<body>

  <div id="container" class="<?php echo $_GET['bbid']; ?>">
    <?php require_once("_tracker_header.php"); ?>
    <div id="main" data-pfid="<?php echo $_GET['pfid']; ?>" data-trid="<?php echo $_GET['trid']; ?>">
      <div id="trade_ltp">
        <div id="ltpprice">&nbsp;</div>
        <div id="ltpchg">&nbsp;</div>
      </div>
      <h1 id="trade_name">&nbsp;</h1>
      <h6 id="trade_symbol">&nbsp;</h6>
      <div id="tradesummary">
       <div id="summaryholder" class="clearfix">
        <div class="summarysection">
          <h4>Average<br/>buy price</h4>
          <div id="avg_price_div" class="sectionvalue">&nbsp;</div>
        </div>
        <div class="summarysection">
          <h4>Buy<br/>quantity</h4>
          <div id="buy_qty_div" class="sectionvalue">&nbsp;</div>
        </div>
        <div class="summarysection">
          <h4>Sell<br/>quantity</h4>
          <div id="sell_qty_div" class="sectionvalue">&nbsp;</div>
        </div>
        <div class="summarysection">
          <h4>Invested<br/>capital</h4>
          <div id="invest_cap_div" class="sectionvalue">&nbsp;</div>
        </div>
        <div class="summarysection">
          <h4>Current<br/>value</h4>
          <div id="current_val_div" class="sectionvalue">&nbsp;</div>
        </div>
        <div class="summarysection">
          <h4>Unrealized<br/>returns</h4>
          <div id="unr_ret_div" class="sectionvalue">&nbsp;</div>
        </div>
        <div class="summarysection summarylast">
          <h4>Realized<br/>returns</h4>
          <div id="r_ret_div" class="sectionvalue">&nbsp;</div>
        </div>
       </div>
      </div>
      <div id="chartholder" class="hidden"></div>
      <div id="waitscreen">Loading trade details. Please wait&hellip;</div>
      <div id="transholder" class="clearfix">
        <div id="transdiv">
          <a id="addtransa" class="abtn" href="javascript:void(0);">+ Add<span class="filler">&nbsp;</span><span class="roundc">&nbsp;</span></a>
          <h4>Transactions summary</h4>
          <div id="formslide" class="clearfix">
        <form id="addTransform" action="/serverscripts/portfolio/addTransaction.php" method="post">
          <input name="csrf" id="csrf" type="hidden" value="<?php echo $key; ?>"/>
          <input name="user_id" id="user_id" type="hidden" value="<?php echo $_SESSION['user_id']; ?>"/>
          <input name="trans_scrip" id="trans_scrip" type="hidden"/>
          <div class="formsection posrel firstsection">
            <label for="trans_type">Type</label>
            <select name="trans_type" id="trans_type">
              <option value="1">BUY</option>
              <option value="-1">SELL</option>
            </select>
            <div id="deductcash" class="clearfix">
              <input type="checkbox" name="includecash" id="includecash"/>
              <span id="includetxt">Deduct from cash</span>
            </div>
            <label for="trans_date">Date</label>
            <input name="trans_date" id="trans_date" type="date" class="dateinput" value="<?php echo date('Y-m-d'); ?>"/>
            <label for="trans_price">Stock Price (<a id="cmpa" href="javascript:void();">Get Price</a>)</label>
            <input name="trans_price" id="trans_price" type="text" class="rupee"/>
          </div>
          <div class="formsection">
            <label for="trans_qty">Quantity</label>
            <input name="trans_qty" id="trans_qty" type="text"/>
            <label for="trans_notes">Notes (optional)</label>
            <textarea name="trans_notes" id="trans_notes" type="text" placeholder="Transaction notes"></textarea>
            <div class="clearfix">
              <input id="submitbtn" type="submit" value="Add"/>
              <input id="cancelbtn" type="reset" value="Clear"/>
            </div>
          </div>
          <div class="formsection lastsection">
            <div id="resulttxt">&nbsp;</div>
          </div>
      </form>
      </div>
          <table id="transtbody" cellspacing="0" cellpadding="0">
          <thead id="transheaddiv">
            <tr class="headdiv clearfix">
              <th class="srno">&nbsp;</th>
              <th class="ttype">Type</th>
              <th class="tdate">Date</th>
              <th class="tprice">Price</th>
              <th class="tqty">Quantity</th>
              <th class="notes">Notes</th>
              <th class="trcontrol lastcell">&nbsp;</th>
            </tr>
          </thead>
          <tbody id="transbody"></tbody>
          </table>
        </div>
        <div id="subdiv">
          <div id="sltarget" class="clearfix">
            <div id="stoplossdiv">
              <a id="addsla" class="abtn" href="javascript:void(0);">+ Add<span class="filler">&nbsp;</span></a>
              <h4>Stop losses</h4>
              <table id="sltbody" cellspacing="0" cellpadding="0">
              <thead id="slheaddiv">
                <tr class="headdiv clearfix">
                  <th class="srno">&nbsp;</th>
                  <th class="trvalue">Stop loss</th>
                  <th class="trcontrol lastcell">&nbsp;</th>
                </tr>
              </thead>
              <tbody id="slbody">
                <tr class="bodydivlast"><td colspan="3" class="loadmsg">Loading&hellip;</td></tr>
              </tbody>
              </table>
            </div>
            <div id="targetsdiv">
              <a id="addtrgta" class="abtn" href="javascript:void(0);">+ Add<span class="filler">&nbsp;</span></a>
              <h4>Targets</h4>
              <table id="targettbody" cellspacing="0" cellpadding="0">
              <thead id="targetheaddiv">
                <tr class="headdiv clearfix">
                  <th class="srno">&nbsp;</th>
                  <th class="trvalue">Target</th>
                  <th class="trcontrol lastcell">&nbsp;</th>
                </tr>
              </thead>
              <tbody id="targetbody">
                <tr class="bodydivlast"><td colspan="3" class="loadmsg">Loading&hellip;</td></tr>
              </tbody>
              </table>
            </div>
          </div>
          <div id="overviewad">
          <script type="text/javascript"><!--
google_ad_client = "ca-pub-2413414539580695";
/* port_overview_med */
google_ad_slot = "3742997887";
google_ad_width = 300;
google_ad_height = 250;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
          </div>
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


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
  <script>!window.jQuery && document.write(unescape('%3Cscript src="js/libs/jquery-1.4.4.min.js"%3E%3C/script%3E'))</script>
  <script src="http://cdn.jquerytools.org/1.2.5/all/jquery.tools.min.js"></script>
  <script src="/tracker/js/mylibs/sprintf-0.6.js"></script>
  
  <!-- scripts concatenated and minified via ant build script-->
  <!-- script type="text/cjs" cjssrc="js/plugins.js"></script-->
  <script src="http://blackbull.in/tracker/js/libs/highcharts.js"></script>
  <script src="http://blackbull.in/tracker/js/overview.js"></script>
  <script type="text/javascript" src="http://use.typekit.com/lyw4lvu.js"></script>
  <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
  <!-- end concatenated and minified scripts-->
  
  
  <!--[if lt IE 7 ]>
    <script src="/tracker/js/libs/dd_belatedpng.js"></script>
    <script> DD_belatedPNG.fix('img, .png_bg'); </script>
  <![endif]-->  
</body>
</html>