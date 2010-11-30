<div id="queryqnholder" class="clearfix">
<div id="postquery">
<div id="charsleft"><b id="charcount">500</b> characters left</div>
<h3>Post a query:</h3>
<form id="newpostform" method="post">
<textarea id="querytext" name="querytext" cols="50" rows="8" placeholder="Post a query&hellip;"></textarea>
<input id="postquerybtn" name="postquerybtn" type="submit" value="Post query" class="btn"/>
<input type="checkbox" name="privatepost" id="privatepost"/>
<input type="hidden" name="ownername" id="ownername" value="<?php echo $_SESSION['id']; ?>"/>
<span id="tip">Keep my post private<div id="privatetip"><b>Private</b> posts will not publish your identity.</div></span>
</form>
</div>
<div id="queryqninfo">
  <h6>Note:</h6>
  <p>We suggest that you put at most two stocks in a single query. This will allow us time to research the stocks before recommending any action.</p>
  <p>Please list the following details in your query if applicable:</p>
  <ol>
    <li>If you already hold the stock, please let us know about your buy price and buy date.</li>
    <li>Your investment horizon: short term(2 to 3 months) and/or long term(1 year or more).</li>
  </ol> 
</div>
</div>
<div id="formresult"><p>The post has been successfully submitted!. Click here to add a <a id='anotherpost' href='#'>new post</a></p></div>