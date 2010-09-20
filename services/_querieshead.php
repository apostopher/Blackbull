<div id="postquery">
<div id="charsleft"><b id="charcount">500</b> characters left</div>
<h3>Post a query:</h3>
<form id="newpostform" method="post">
<textarea id="querytext" name="querytext" cols="50" rows="5" placeholder="Post a query&hellip;"></textarea>
<input id="postquerybtn" name="postquerybtn" type="submit" value="Post query" class="btn"/>
<input type="checkbox" name="privatepost" id="privatepost"/>
<input type="hidden" name="ownername" id="ownername" value="<?php echo $_SESSION['id']; ?>"/>
<span id="tip">Keep my post private<div id="privatetip"><b>Private</b> posts will not publish your identity.</div></span>
</form>
</div>
<div id="formresult"><p>The post has been successfully submitted!. Click here to add a <a id='anotherpost' href='#'>new post</a></p></div>