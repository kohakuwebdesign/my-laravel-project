<?php
/*
 *
 * Getting long lived access token
 *  
 */
include 'define.php';

// load graph-sdk files
include_once __DIR__ . '/vendor/autoload.php';

// facebook credentials array
$cred = array(
    'app_id' => FACEBOOK_APP_ID,
    'app_secret' => FACEBOOK_APP_SECRET,
    'default_graph_version' => 'v8.0',
    'persistant_data_handler' => 'session'
);

// create facebook object
$facebook = new Facebook\Facebook($cred);

// helper
$helper = $facebook->getRedirectLoginHelper();

// oauth object
$oAuth2Client = $facebook->getOauth2Client();

if (isset($_GET['code'])) { // get access token
    try {
        $shortLivedAccessToken = $helper->getAccessToken(); // short lived access token (one hour)
    } catch (Facebook\Exceptions\FacebookResponseException $e) { // graph error
        echo 'Graph returned an error ' . $e->getMessage;
    } catch (Facebook\Exceptions\FacebookSDKException $e) { // validation error
        echo 'Facebook SDK returned an error ' . $e->getMessage;
    }

    if (!$shortLivedAccessToken->isLongAccessToken) { // exchange short lived access token for long lived access token (60 days)
        try {
            $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($shortLivedAccessToken);
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Error getting long lived access token' . $e->getMessage();
        }
    }

    echo '<h1>Short Lived Access Token</h1>';
    print_r($shortLivedAccessToken);
    var_dump($shortLivedAccessToken);

    echo '<h1>Long Lived Access Token</h1>';
    print_r($longLivedAccessToken);
    var_dump($longLivedAccessToken);

} else { // display login url
    $permission = [
        'public_profile',
        'instagram_basic',
        'pages_show_list',
        'instagram_manage_insights' // you need this permission to use 'business_discovery' endpoint
    ];

    $loginUrl = $helper->getLoginUrl(FACEBOOK_REDIRECT_URI, $permission);

    echo '<a href="' . $loginUrl . '">Login with Facebook</a>';
}

