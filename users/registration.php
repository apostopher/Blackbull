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
	<meta name="Description" content="Blackbull.in settings page to register a new user account."/>
	<title>Registration - Blackbull Investment Company</title>
	<link rel="stylesheet" href="../stylesheets/site.css" media="screen">
	<link rel="stylesheet" href="../stylesheets/users/registration.css" media="screen">
	<script src="/javascripts/lib/modernizr-1.6.min.js?v=1"></script>
</head>
<body>
<?php require_once("../_partial_header.php"); ?>
<div id="content">
<div id="registration">
<h1>Welcome!</h1>
<p>Joining blackbull is simple. Just fill the following form &amp; submit.</p>
<form id="registrationform" method="post">
<script src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
<div id="captchaholder" class="hide">
<div id="verifyhuman">
<a id="closePopup" href=""></a>
<h3>Please verify that you are a human.</h3>
<div id="recaptcha_image"></div>
<div><a href="javascript:Recaptcha.reload()">Can't read this? Get two new words.</a></div>
<label for="recaptcha_response_field" class="recaptcha">Type the two words</label>
<table cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td><input type="text" class="short" id="recaptcha_response_field" name="recaptcha_response_field" /></td>
<td><button id="captchaSubmit" class="captchaSubmit">Finish</button></td>
</tr>
</tbody>
</table>
<span id="captcharesult">&nbsp;</span>
</div>
</div>
<p><i>All fields are mandatory.</i></p>
<label for="firstname">First name</label>
<input type="text" id="firstname" class="short"/>
<label for="lastname">Last name</label>
<input type="text" id="lastname" class="short"/>
<br/>
<span id="firstnameresult">Your screen name on blackbull.</span>
<span id="lastnameresult">&nbsp;</span>
<br/>
<label for="email">E-mail address</label>
<input type="email" id="email" class="longlegend" title="We'll send you a confirmation."/>
<br/>
<span id="emailresult">Your e-mail will be your <b>USERNAME</b>.</span>
<br/>
<label for="upassword">Password</label>
<input type="password" id="upassword" class="longlegend" title="Must be less than 16 characters."/>
<br/>
<span id="passresult">&nbsp;</span>
<br/>
<label for="repassword">Retype password</label>
<input type="password" id="repassword" class="long"/>
<br/>
<p id="terms">By clicking on "Submit" below, you are agreeing to the <a rel="license" href="../legal.php">terms &amp; conditions</a>.</p>
<input type="submit" value="Submit" id="submitform" class="submitbutton"/>
<input type="reset" value="Reset" id="resetform" class="submitbutton"/>
<input type="hidden" value="0" id="emailverify"/>
</form>
</div>
</div>
<?php require_once("../_partial_footer.php"); ?>
<?php require_once("../jslibs.php"); ?>
<script src="../javascripts/users/registration.js"></script>
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