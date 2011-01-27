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
	<meta name="Description" content="Blackbull.in settings page to login to blackbull's exclusive content."/>
	<title>Login - Blackbull Investment Company</title>
	<link rel="stylesheet" href="../stylesheets/site.css" media="screen">
	<link rel="stylesheet" href="../stylesheets/users/login.css" media="screen">
	<script src="/javascripts/lib/modernizr-1.6.min.js?v=1"></script>
</head>
<body>
<?php require_once("../_partial_header.php"); ?>
<div id="content">
<div id="login">
<h1><?php if($_GET['forgot'] == "true"){echo "Forgot password";}else{echo "Sign in";} ?></h1>
<div id="formholder">
<div class="spacer">&nbsp;</div>
<div id="loginformdiv">
<form id="loginform" method="post" <?php if($_GET['forgot'] == "true"){echo "style=\"display:none\"";} ?>>
<label for="pageusername">Username</label>
<input type="email" id="pageusername" class="long" placeholder="Your e-mail address."/>
<br/>
<label for="pagepassword">Password</label>
<input type="password" id="pagepassword" class="long"/>
<br/>
<input type="hidden" id="pageencrypted"/>
<input type="checkbox" id="pageremember" class="check" />
<label for="pageremember" class="simple">Remember me</label>
<br/>
<input type="submit" value="Sign in" id="submitform" class="submitbutton"/>
<div id="loginerror" class="hide">Sign in failed. <a href="" id="showresetpass">Reset password?</a></div>
</form>
<form id="resendpass" method="post" class="hide" <?php if($_GET['forgot'] == "true"){echo "style=\"display:block\"";} ?>>
<label for="newpass">E-mail address</label>
<input type="email" id="newpass" class="long"/>
<br/>
<span id="passwordtip">Temporary password will be sent to this e-mail.</span>
<br/>
<input type="submit" value="Send" id="sendpassbtn" class="submitbutton"/>
</form>
</div>
<div id="newmember"><p>Don't have a username? Sign up for free.</p><a class="registeruser" href="registration.php">Sign up</a></div>
<div class="spacer">&nbsp;</div>
</div>
</div>
</div>
<?php require_once("../_partial_footer.php"); ?>
<?php require_once("../jslibs.php"); ?>
<script src="../javascripts/users/login.js"></script>
<?php require_once("../analyticstracking.php"); ?>
</body>
</html>