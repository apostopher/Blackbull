<?php
session_start();
require_once("../phpinisettings.php");
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
	<meta name="Description" content="Blackbull.in settings page to reset user account password."/>
	<title>New password - Blackbull Investment Company</title>
	<link rel="stylesheet" href="../stylesheets/site.css" media="screen">
	<link rel="stylesheet" href="../stylesheets/users/setnewpassword.css" media="screen">
	<!-- script src="../javascripts/lib/modernizr-1.5.min.js"></script -->
</head>
<body>
<?php require_once("../_partial_header.php"); ?>
<div id="content">
<div id="resetpassword">
<h1>Reset password</h1>
<p>Fill the following form to set a new account password.</p>
<form id="setnewpassform" method="post">
<label for="email">E-mail address</label>
<input type="email" id="email" class="longlegend"/>
<br/>
<span id="emailresult">Your e-mail is your <b>USERNAME</b>.</span>
<br/>
<label for="tpassword">Temporary password</label>
<input type="password" id="tpassword" class="long"/>
<br/>
<label for="upassword">New password</label>
<input type="password" id="upassword" class="longlegend" title="Password must be less than 16 characters."/>
<br/>
<span id="passresult">&nbsp;</span>
<br/>
<label for="repassword">Retype new password</label>
<input type="password" id="repassword" class="long"/>
<br/>
<input type="submit" value="Reset password" id="submitform" class="submitbutton"/>
</form>
</div>
</div>
<?php require_once("../_partial_footer.php"); ?>
<?php require_once("../jslibs.php"); ?>
<script src="../javascripts/users/setnewpassword.js"></script>
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