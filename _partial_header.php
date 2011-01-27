<div id="opaque" class="hide"></div>
<div id="header_login_nav" class="topnav">
<div id="loadingdiv" class="hide"><span>Please wait&hellip;</span></div>
<ul id="logout_menu" class="clearfix <?php if(!$_SESSION['user']){echo " invisible";} ?>" >
<li class="limenu signout limenumain"><a class="settings signout" href='#'>Settings</a>
<div id="settings_menu" class="hide">
<ul>
<li class="bottomborder"><a href="/users/changepassword.php">Change Password</a></li>
<li <?php if($_SESSION['user'] != "Admin"){echo "class=\"invisible\"";}?> id="lipreview"><a id="previewdigest" href="#">Preview</a></li>
<li <?php if($_SESSION['user'] != "Admin"){echo "class=\"invisible\"";}?> id="lisave"><a id="savedigest" href="#">Save</a></li>
<li><a href="#" class="lisignout">Log Out</a></li>
</ul>
</div>
</li>
<li class="second limenumain">|</li>
<li class="first limenumain">Welcome <span id='uname'><?php echo $_SESSION['user']; ?></span></li>
</ul>
<ul id="login_menu" class="clearfix <?php if($_SESSION['user']){echo " invisible";} ?>" >
<li class="limenu signin limenumain">
<a class="signin" href="/users/login.php">Sign in</a>
<div id="signin_menu" class="hide">
    <form id="signinfrm" method="post">
      <p>
      <label for="username">Username (e-mail address)</label>
      <input id="username" name="username" autofocus placeholder="e-mail address" value="" title="username" tabindex="4" type="email" class="txtbox" />
      </p>
      <p>
        <label for="password">Password</label>
        <input id="password" name="password" value="" title="password" tabindex="5" type="password" class="txtbox" />
      </p>
      <p class="remember">
        <input id="encrypted" value="" type="hidden" />
        <input id="signin_submit" value="Sign in" tabindex="6" type="submit" />
        <input id="remember" name="remember_me" value="1" tabindex="7" type="checkbox" class="chkbox" />
        <label for="remember">Remember me</label>
      </p>
      <p class="forgot"><a id="forgot" href="/users/login.php?forgot=true">Forgot your password?</a> </p>
    </form>
</div>
</li>
<li class="second limenumain">|</li>
<li class="first limenumain"><a href="/users/registration.php">Register</a></li>
</ul>
</div>
<header id="siteheader" class="png_bg clearfix">
<h1><a href="/index.php" id="logo"><img src="/images/logo.png" width="314" height="26" alt="Blackbull Investment Company"/></a></h1>     
</header>
<div id="light"><!-- --></div>
<nav id="sitenavigation">
<div id="bbsearch">
<form action="http://blackbull.in/searchresults.php" id="cse-search-box">
  <div>
    <input type="hidden" name="cx" value="partner-pub-2413414539580695:1w7lvk-k0hd" />
    <input type="hidden" name="cof" value="FORID:10" />
    <input type="hidden" name="ie" value="UTF-8" />
    <input type="text" name="q" size="20" />
    <input type="submit" name="sa" value="Search" />
  </div>
</form>
<script type="text/javascript" src="http://www.google.co.in/cse/brand?form=cse-search-box&amp;lang=en"></script>
</div>
<ul id="mainnav">
<li class="menuitem wall png_bg" data-tab-name="Services">
<span class="liname png_bg">Services</span>
<span class="arrow hide png_bg"></span>
<ul class="submenu hide">
<li><a href="/services/queries.php" rel="prefetch"><span class="sublihead">Blackbull Queries</span><span class="sublidesc">Get your questions answered.</span></a></li>
<li><a href="/services/portfolio.php" rel="prefetch"><span class="sublihead">Blackbull Portfolio</span><span class="sublidesc">The market positions that we have.</span></a></li>
</ul>
</li>
<li class="menuitem wall png_bg" data-tab-name="Articles">
<span class="liname png_bg">Articles</span>
<span class="arrow hide png_bg"></span>
<ul class="submenu hide">
<li><a href="/articles/dragonEmpire.php"><span class="sublihead">Dragon Empire</span><span class="sublidesc">US-China trade relations.</span></a></li>
<!-- li><span class="sublihead">Mix the perfect cocktail</span><span class="sublidesc">Use of fundamental &amp; technical analysis in investment decisions.</span></li -->
<li><a href="/articles/unlockTheCycle.php"><span class="sublihead">Unlock the cycle</span><span class="sublidesc">The cyclic nature of stocks</span></a></li>
<li><a href="/articles/smallIsBeautiful.php"><span class="sublihead">Small is beautiful</span><span class="sublidesc">Investment techniques in smallcaps.</span></a></li>
</ul>
</li>
<li class="menuitem wall png_bg" data-tab-name="Research">
<span class="liname png_bg">Research</span>
<span class="arrow hide png_bg"></span>
<ul class="submenu hide">
<li><a href="/research/coalindiaIPO.php"><span class="sublihead">Coal India IPO</span><span class="sublidesc">The IPO analysis.</span></a></li>
<li><a href="/research/tulip.php"><span class="sublihead">TULIP telecom analysis</span><span class="sublidesc">The complete analysis of TULIP telecom.</span></a></li>
<li><a href="/research/moilIPO.php"><span class="sublihead">MOIL IPO analysis</span><span class="sublidesc">The complete analysis of MOIL IPO.</span></a></li>
</ul>
</li>
<li class="menuitem wall png_bg" data-tab-name="Knowledge">
<span class="liname png_bg">Knowledge</span>
<span class="arrow hide png_bg"></span>
<ul class="submenu hide">
<li><a href="/knowledge/introStockMarket.php"><span class="sublihead">The stock market</span><span class="sublidesc">The basics of stock market.</span></a></li>
<li><a href="/knowledge/stockMarketTrading.php"><span class="sublihead">The stock market trading</span><span class="sublidesc">trading fundamentals.</span></a></li>
<li><a href="/knowledge/auction.php"><span class="sublihead">The auction trading</span><span class="sublidesc">Basics of auctions.</span></a></li>
</ul>
</li>
<li class="menuitem wall png_bg" data-tab-name="Tools">
<span class="liname png_bg">Tools</span>
<span class="arrow hide png_bg"></span>
<ul class="submenu hide">
<li><a href="/tools/fiidii.php"><span class="sublihead">Institutional investments</span><span class="sublidesc">A chart of foreign &amp; domestic investments.</span></a></li>
<li><a href="/tools/optionspread.php"><span class="sublihead">Options Spread</span><span class="sublidesc">An overview of NIFTY put and call options.</span></a></li>
</ul>
</li>
</ul>
</nav>
<?php require_once("serverscripts/lastlogin.php");?>