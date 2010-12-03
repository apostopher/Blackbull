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
	<meta name="Description" content="Blackbull.in options trading tool gives you an overview of near term NIFTY call options and put options traded on NSE."/>
	<title>Options spread - Blackbull Investment Company</title>
	<link rel="stylesheet" href="../stylesheets/site.css" media="screen">
	<link rel="stylesheet" href="../stylesheets/tools/optionspread.css" media="screen">
	<script src="../javascripts/lib/modernizr-1.6.min.js"></script>
</head>
<body>
<?php require_once("../_partial_header.php"); ?>
<div id="content" data-type="Tools">
<div id="optionspread">
<h1>Options Spread</h1>
<table id="spread_info" cellpadding="0" cellspacing="0" border="0">
<tr><td class="legend">Security Name</td><td class="colon">:</td><td class="cellval"><span id="sec_name"></span></td><td></td></tr>
<tr><td class="legend">Expiry Date</td><td class="colon">:</td><td class="cellval"><span id="sec_expiry"></span></td><td></td></tr>
<tr><td class="legend">Value of underlying</td><td class="colon">:</td><td class="cellval"><span id="sec_val"></span></td><td id="updatedate"></td></tr>
</table>
<div id="toolscolumnads">
</div>
<table id="tbl_optionspread" cellpadding="0" cellspacing="0" border="0">
<thead>
<tr>
<th colspan="3">Calls</th>
<th class="stk">&nbsp;</th>
<th colspan="3">Puts</th>
</tr>
<tr>
<th>Premium</th>
<th>Contracts</th>
<th>Open Interest</th>
<th>Strike Price</th>
<th>Premium</th>
<th>Contracts</th>
<th>Open Interest</th>
</tr>
</thead>
<tfoot>
<tr><td colspan="7">&nbsp;</td></tr>
</tfoot>
<tbody id='spread_body'>
<tr><td colspan="7">Loading data&hellip;</td></tr>
</tbody>
</table>
</div>
</div>
<?php require_once("../_partial_footer.php"); ?>
<?php require_once("../jslibs.php"); ?>
<script src="../javascripts/tools/optionspread.js"></script>
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