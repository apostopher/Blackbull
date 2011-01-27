<header id="siteheader">
      <div id="headerwrap" class="clearfix">
        <div id="welcomediv">Welcome&nbsp;<?php echo $_SESSION['user']; ?></div>
        <a id="logo" href="http://blackbull.in/tracker/"><img src="/tracker/images/tinylogo.png" width="72" height="26"/></a>
        <div id="srchfrm">
        <form action="" method="post">
          <fieldset id="srchfield">
            <input type="text" name="srchterm" id="srchterm" placeholder="Search"/>
            <input type="submit" name="srchsubmit" id="srchsubmit" class="png_bg" value=""/>
          </fieldset>
        </form>
        </div>
      </div>
    </header>