<?php
session_start();
require_once("phpinisettings.php");
if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass']) && isset($_COOKIE['cookid'])){
      $_SESSION['user'] = $_COOKIE['cookname'];
      $_SESSION['pass'] = $_COOKIE['cookpass'];
      $_SESSION['id'] = $_COOKIE['cookid'];
   }
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js modern"> <!--<![endif]-->
<head>
	<?php require_once("metacontent.php"); ?>
	<meta name="Description" content="Blackbull.in search is a custom site search powered by google."/>
	<?php require_once("opengraph.php"); ?>
	<title>Blackbull Investment Company</title>
        <link rel="stylesheet" href="stylesheets/site.css?v=4" media="screen">
        <!-- script type="text/javascript" src="http://use.typekit.com/gpv5lbg.js"></script -->
	<!-- script type="text/javascript">try{Typekit.load();}catch(e){}</script -->
</head>
<body>
<?php require_once("_partial_header.php"); ?>
<div id="content" class="clearfix">
<div id="cse-search-results"></div>
<script type="text/javascript">
  var googleSearchIframeName = "cse-search-results";
  var googleSearchFormName = "cse-search-box";
  var googleSearchFrameWidth = 900;
  var googleSearchDomain = "www.google.co.in";
  var googleSearchPath = "/cse";
</script>
<script type="text/javascript" src="http://www.google.com/afsonline/show_afs_search.js"></script>
</div>
<?php require_once("_partial_footer.php"); ?>
<?php require_once("jslibs.php"); ?>
<script src="javascripts/home.js?v=4"></script>
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