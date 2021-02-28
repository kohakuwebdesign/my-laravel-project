<?php

session_start();

define('FACEBOOK_APP_ID', '1070234180072644');
define('FACEBOOK_APP_SECRET', 'cc8b0cfb72d8cc80ddb1be69b42470ac');
define('FACEBOOK_REDIRECT_URI', 'http://localhost:8888/instagram_graph_api/get_access_token.php');
define('ENDPOINT_BASE', 'https://graph.facebook.com/v8.0/');

// Long lived access token
//$accessToken = 'EAAPNX1AhNMQBALv4iWJ2BAE4bDRwHZC22To0QKkHtVf3ryPjX38a1aHX011l7fq7jHTJZC0whNVFK4RRjAybnLQDTZCZAYHRtTsV4Ezr6KZCZCCCe7dN2R1KpGaqWZAzh00SZC87nxqKcfoTZA793d97juAB5beRjwi8yKIxZBtbwDNQZDZD';
$accessToken = EAAPNX1AhNMQBAAeYHu2Bx5QUC3RJlj2xZCEcVQvRmeFWDVZBAgnjYTouxjAUnsdd2F9MwAo31EmUKZCOmNkst9X0Ua7KKuZCJsoPXaZAdvlgpxBfRsa8WaHTXZBFuWGh91gYXks8ewUR7WSRLSAtNFY2Fa59wvOZCHEF9RsMkBpLQZDZD;
// page id = facebook page id
$pageId = '198479507164340';

// instagram business account id
$instagramAccountId ='17841403089870520';
