<!doctype html>  

<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title></title>
  <meta name="description" content="">
  <meta name="author" content="">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
  <link href='http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="css/trackerlogin.css?v=5">
  <script src="js/libs/modernizr-1.6.min.js"></script>

</head>

<body>

  <div id="container">
    <header id="trackerhead">
      <h1><a href="http://blackbull.in"><b>Blackbull</b>&nbsp;Investment Company</a></h1>
    </header>
    
    <div id="main">
     <div id="backdrop">
      <div id="mainholder">
        <h1 class="png_bg">Portfolio Tracker</h1>
        <div id="loginformholder">
        <p>Login to portfolio with your blackbull username and password.<br/>New to blackbull? <a href="/users/registration.php">Register</a> now!</p>
        <form id="loginfrm" action="/serverscripts/portfolio/trackerlogin.php" method="post">
          <label for="trackeruser">Username</label>
          <input id="trackeruser" name="trackeruser" type="text" class="border"/>
          <label for="trackerpass">Password</label>
          <input id="trackerpass" name="trackerpass" type="password" class="border"/>
          <div class="clearfix">
            <div id="remembercheck"><input type="checkbox" id="remember" name="remember" value="1" />Remember me</div>
            <input id="loginsubmit" name="loginsubmit" type="submit" value="Login"/>
          </div>
        </form>
        </div>
        <div id="newfolioholder">
          <p>Login successful! You are just one step away from creating your first portfolio. Just enter a desired name for your portfolio and click 'Create'.</p>
          <form id="newfoliofrm" action="/serverscripts/portfolio/foliocreate.php" method="post">
            <label for="folioname">Portfolio Name</label>
            <input id="folioname" name="folioname" type="text" class="border"/>
            <div class="clearfix">
              <input id="newfoliosubmit" name="newfoliosubmit" type="submit" value="Create"/>
            </div>
          </form>
        </div>
      </div>
     </div>
    </div>
    
    <footer>
      <div id="loginfooter" class="clearfix">
        <div class="footersection">
          <h3>Monitor performance</h3>
          <p>The blackbull portfolio has brilliant reports & charts that help you to make better investing decisions.</p>
        </div>
        <div class="footersection">
          <h3>Community stock tips</h3>
          <p>Follow and share stock market tips directly from your portfolio.</p>
        </div>
        <div class="footersection">
          <h3>User friendly interface</h3>
          <p>Blackbull provides a very user-friendly interface to manage your stock market trades.</p>
        </div>
      </div>
      <div class="copy"><div class="contactme"><a href="mailto:apostopher@gmail.com?Subject=Blackbull%20Portfolio">Contact me</a></div>&copy; 2011 Blackbull inc. | All rights reserved. |&nbsp;<a href="http://blackbull.in/legal.php">Legal</a></div>
    </footer>
  </div> <!-- end of #container -->


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
  <script>!window.jQuery && document.write(unescape('%3Cscript src="js/libs/jquery-1.4.4.min.js"%3E%3C/script%3E'))</script>
  
  
  <!-- scripts concatenated and minified via ant build script-->
  <script src="js/trackerlogin.min.js"></script>
  <!-- end concatenated and minified scripts-->
  
  
  <!--[if lt IE 7 ]>
    <script src="js/libs/dd_belatedpng.js"></script>
    <script> DD_belatedPNG.fix('img, .png_bg'); </script>
  <![endif]-->
  
</body>
</html>