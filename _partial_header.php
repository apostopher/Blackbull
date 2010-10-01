<div id="opaque" class="hide"></div>
<header id="siteheader">
<a href="/index.php" ID="logo"><img src="/images/logo.png" width="314" height="26" alt="Company logo"/></a>
<div id="header_login_nav" class="topnav">
<div id="loadingdiv" class="hide"><span>Please wait&hellip;</span></div>
<ul id="logout_menu" <?php if(!$_SESSION['user']){echo "class=\"invisible\"";} ?>>
<li class="first">Welcome <span id='uname'><?php echo $_SESSION['user']; ?></span></li>
<li class="second">|</li>
<li class="limenu signout"><a class="settings signout" href='#'>Settings</a>
<div id="settings_menu" class="hide">
<ul>
<li class="bottomborder"><a href="/users/changepassword.php">Change Password</a></li>
<li <?php if($_SESSION['user'] != "Admin"){echo "class=\"invisible\"";}?> id="lipreview"><a id="previewdigest" href="#">Preview</a></li>
<li <?php if($_SESSION['user'] != "Admin"){echo "class=\"invisible\"";}?> id="lisave"><a id="savedigest" href="#">Save</a></li>
<li><a href="#" class="lisignout">Log Out</a></li>
</ul>
</div>
</li>
</ul>
<ul id="login_menu" <?php if($_SESSION['user']){echo "class=\"invisible\"";} ?>>
<li class="first"><a href="/users/registration.php">Register</a></li>
<li class="second">|</li>
<li class="limenu signin">
<a class="signin" href="/login.php">Sign in</a>
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
</ul>
</div>     
</header>
<div id="light"><!-- --></div>
<nav id="sitenavigation">
<ul id="mainnav">
<li class="menuitem wall" data-tab-name="Services">
<span class="liname">Services</span>
<span class="arrow hide"></span>
<ul class="submenu hide">
<li><a href="/services/queries.php"><h6>Blackbull Queries</h6><p>Get your questions answered.</p></a></li>
<li><a href="/services/portfolio.php"><h6>Blackbull Portfolio</h6><p>The market positions that we have.</p></a></li>
</ul>
</li>
<li class="menuitem wall" data-tab-name="Articles">
<span class="liname">Articles</span>
<span class="arrow hide"></span>
<ul class="submenu hide">
<li><a href="/articles/dragonEmpire.php"><h6>Dragon Empire</h6><p>US-China trade relations.</p></a></li>
<!-- li><h6>Mix the perfect cocktail</h6><p>Use of fundamental &amp; technical analysis in investment decisions.</p></li -->
<li><a href="/articles/unlockTheCycle.php"><h6>Unlock the cycle</h6><p>The cyclic nature of stocks</p></a></li>
<li><a href="/articles/smallIsBeautiful.php"><h6>Small is beautiful</h6><p>Investment techniques in smallcaps.</p></a></li>
</ul>
</li>
<!-- li class="menuitem wall" data-tab-name="Research">
<span class="liname">Research</span>
<span class="arrow hide"></span>
</li -->
<li class="menuitem wall" data-tab-name="Knowledge">
<span class="liname">Knowledge</span>
<span class="arrow hide"></span>
<ul class="submenu hide">
<li><a href="/knowledge/introStockMarket.php"><h6>The stock market</h6><p>The basics of stock market.</p></a></li>
<li><a href="/knowledge/stockMarketTrading.php"><h6>The stock market trading</h6><p>trading fundamentals.</p></a></li>
<li><a href="/knowledge/auction.php"><h6>The auction trading</h6><p>Basics of auctions.</p></a></li>
</ul>
</li>
<li class="menuitem" data-tab-name="Tools">
<span class="liname">Tools</span>
<span class="arrow hide"></span>
<ul class="submenu hide">
<li><a href="/tools/fiidii.php"><h6>Institutional investments</h6><p>A chart of foreign &amp; domestic investments.</p></a></li>
</ul>
</li>
</ul>
</nav>
<?php require_once("serverscripts/lastlogin.php");?>