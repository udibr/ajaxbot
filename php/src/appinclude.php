<?php
require_once 'facebook.php';

$appapikey = '[todo: enter the API KEY for your application]';
$appsecret = '[todo: enter the API secret for your application]'';
$facebook = new Facebook($appapikey, $appsecret);
$user = $facebook->require_login();

$appcallbackurl = 'http://[todo: change the following url to your callback url]/fbaliza.php';
$canvaspageurl = 'http://apps.facebook.com/[todo: enter your facebook application name/';

$is_added = @$facebook->api_client->users_isAppAdded();
if (is_null($is_added)) {
	// Catch errors (PHP4 does not have exception handling)
	// this will clear cookies for your application and redirect them to a login prompt
	$facebook->set_user(null, null);
	$facebook->redirect($appcallbackurl);
} elseif (! $is_added) {
    $facebook->redirect($facebook->get_add_url());
}
