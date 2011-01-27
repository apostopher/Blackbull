<?php
/**
 * @file
 * User has successfully authenticated with Twitter. Access tokens saved to session and DB.
 */

/* Load required lib files. */
session_start();
require_once('twitteroauth.php');
require_once('config.php');

/* Create a TwitterOauth object with consumer/user tokens. */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_SECRET);

/* If method is set change API call made. Test is called by default. */
/*$content = $connection->get('account/verify_credentials');*/

/* Some example calls */
//$connection->get('users/show', array('screen_name' => 'abraham')));
//$connection->post('statuses/update', array('status' => "Using twitter API... its fun."));
//$connection->post('statuses/destroy', array('id' => 5437877770));
//$connection->post('friendships/create', array('id' => 9436992)));
//$connection->post('friendships/destroy', array('id' => 9436992)));

/* Include HTML to display on the page */
include('html.inc');