<!doctype html>  

<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js modern"> <!--<![endif]-->
<head>
  
  <?php require_once("../metacontent.php"); ?>
  <title>Portfolio Tracker</title>
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
  <link rel="stylesheet" href="/tracker/stylesheets/style.css?v=2">
  <script src="/javascripts/lib/modernizr-1.6.min.js"></script>

</head>

<body>
  <div id="taskbar-wrapper">
    <div id="taskbar">
    </div>
  </div>
  <div id="head-wrapper">
    <div id="head" class="clearfix">
      <div class="logo"><a href="/" class="png_bg">Blackbull investment company</a></div>
    </div>
  </div>
  <div id="container">
    <header id="main-header">
      <div id="nifty" class="index">
        <h4>NIFTY</h4>
        <h5 class="red">6003.55</h5>
        <h6 class="red">-1.83%</h6>
      </div>
      <div id="sensex" class="index">
        <h4>SENSEX</h4>
        <h5 class="red">20123</h5>
        <h6 class="red">-1.83%</h6>
      </div>
      <h1>Portfolio Tracker</h1>
    </header>
    
    <div id="main">
      <div id="tableheader">
      <ul class="clearfix">
        <li class="menuitem"><a id="portsummary" href="javascript:void(0)" class="firstitem">Summary</a></li>
        <li class="menuitem"><a id="myportfolio" href="javascript:void(0)" class="active">My portfolio</a></li>
        <li class="menuitem tips"><div class="numbertips">8</div><a id="stocktips" href="javascript:void(0)">Suggestions</a></li>
        <li class="menuitem"><a id="portsearch" href="javascript:void(0)" >Search</a></li>
        <li class="menuitem"><a id="stocksettings" href="javascript:void(0)" class="lastitem">Settings</a></li>
      </ul>
      </div>
      <div id="newtransdiv" class="hidden">
        <h2>Add Transactions</h2>
        <form action="/tracker/serverscripts/addtransactions.php" method="post">
          <table id="newtranstbl" cellspacing="0" cellpadding="0">
            <tbody>
              <tr><td><label for="transtype">Type</label></td><td><input type="text" id="transtype" name="transtype"/></td></tr>
              <tr><td><label for="transname">Scrip name</label></td><td><input type="text" id="transname" name="transname"/></td></tr>
              <tr><td><label for="transprice">Price per share</label></td><td><input type="text" id="transprice" name="transprice"/></td></tr>
              <tr><td><label for="transqty">Quantity</label></td><td><input type="text" id="transqty" name="transqty"/></td></tr>
              <tr><td><label for="transdate">Date</label></td><td><input type="text" id="transdate" name="transdate"/></td></tr>
              <tr><td><label for="transbrokerage">Brokerage</label></td><td><input type="text" id="transbrokerage" name="transbrokerage"/></td></tr>
              <tr><td><label for="transnotes">Notes</label></td><td><input type="text" id="transnotes" name="transnotes"/></td></tr>
            </tbody>
          </table>
        </form>
      </div>
      <div id="tablecontents">
        <div id="submenu">
          <a id="addtransbtn" href="javascript:void(0);"><span id="addtranspan">Add transactions</span></a>
        </div>
        <table id="portfoliotbl" cellspacing="0" cellpadding="0">
          <col align="left"/>
          <col width="120" align="center"/>
          <col width="120" align="center"/>
          <col width="120" align="center"/>
          <col width="120" align="center"/>
          <col width="120" align="center"/>
          <thead>
            <tr>
              <th class="first">Name</th>
              <th>LTP</th>
              <th>Change</th>
              <th>Avg. buy price</th>
              <th>Quantity</th>
              <th>Gain / Loss</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td class="foot" colspan="7">&nbsp;</td>
            </tr>
          </tfoot>
          <tbody>
            <tr>
              <td class="first">TATA Consultancy Services</td>
              <td>1000</td>
              <td>+5%<br/>(+124.67)</td>
              <td>678</td>
              <td>60</td>
              <td class="last">+120%<br/>(+450.44)</td>
            </tr>
            <tr>
              <td class="first">TATA Consultancy Services</td>
              <td>1000</td>
              <td>+5%<br/>(+124.67)</td>
              <td>678</td>
              <td>60</td>
              <td class="last">+120%<br/>(+450.44)</td>
            </tr>
            <tr>
              <td class="first">TATA Consultancy Services</td>
              <td>1000</td>
              <td>+5%<br/>(+124.67)</td>
              <td>678</td>
              <td>60</td>
              <td class="last">+120%<br/>(+450.44)</td>
            </tr>
            <tr>
              <td class="first">TATA Consultancy Services</td>
              <td>1000</td>
              <td>+5%<br/>(+124.67)</td>
              <td>678</td>
              <td>60</td>
              <td class="last">+120%<br/>(+450.44)</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    
    <footer id="main-footer">

    </footer>
  </div>
  
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.js"></script>
  <script>!window.jQuery && document.write(unescape('%3Cscript src="/javascripts/lib/jquery-1.4.3.js"%3E%3C/script%3E'))</script>
  <script src="http://cdn.jquerytools.org/1.2.5/all/jquery.tools.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.4/jquery-ui.min.js"></script>
  
  
  
  <!-- scripts concatenated and minified via ant build script-->
  <script src="/tracker/javascripts/tracker.js"></script>
  <!-- end concatenated and minified scripts-->
  
  
  <!--[if lt IE 7 ]>
    <script src="/javascripts/lib/dd_belatedpng.js"></script>
    <script> DD_belatedPNG.fix('img, .png_bg'); </script>
  <![endif]-->  
</body>
</html>