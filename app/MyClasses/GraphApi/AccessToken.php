<?php
namespace App\MyClasses\GraphApi;
include_once 'Configuration.php';
// load graph-sdk files
include_once __DIR__ . '/vendor/autoload.php';
use Facebook\Facebook;

/*
 *
 * Getting long lived access token
 *
 */

class AccessToken
{
    private $conf;
    private $cred;
    private $helper;
    private $oAuth2Client;

    public function __construct()
    {
        $this->conf = new Configuration();
        // facebook credentials array

        $this->cred = array(
            'app_id' => $this->conf->getFacebook_app_id(),
            'app_secret' => $this->conf->getFacebook_app_secret(),
            'default_graph_version' => $this->conf->getDefault_graph_version(),
            'persistant_data_handler' => 'session'
        );

        // create facebook object
        $facebook = new Facebook($this->cred);

        // helper
        $this->helper = $facebook->getRedirectLoginHelper();

        // oauth object
        $this->oAuth2Client = $facebook->getOauth2Client();
    }

    public function authorize($code)
    {
        $data = [];
        if (isset($code)) { // get access token
            try {
                $shortLivedAccessToken = $this->helper->getAccessToken(); // short lived access token (one hour)
            } catch (\Facebook\Exceptions\FacebookResponseException $e) { // graph error
                $data['status'] = 'Authorization Failed';
                $data['errors']['graph_error'] = 'Graph returned an error ' . $e->getMessage;
            } catch (\Facebook\Exceptions\FacebookSDKException $e) { // validation error
                $data['status'] = 'Authorization Failed';
                $data['errors']['facebook_sdk_error'] = 'Facebook SDK returned an error ' . $e->getMessage;
            }

            if (!$shortLivedAccessToken->isLongAccessToken) { // exchange short lived access token for long lived access token (60 days)
                try {
                    $longLivedAccessToken = $this->oAuth2Client->getLongLivedAccessToken($shortLivedAccessToken);
                } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                    $data['status'] = 'Authorization Failed';
                    $data['errors']['long_lived_accesstoken_error'] = 'Error getting long lived access token' . $e->getMessage();
                }
            }

            if($data['status'] != 'Authorization Failed'){
                $data['status'] = 'Authorization Succeeded';
            }
            $data['short_lived_accesstoken'] = $shortLivedAccessToken;
            $data['long_lived_accesstoken'] = $longLivedAccessToken;

        } else { // display login url
            $permission = [
                'public_profile',
                'instagram_basic',
                'pages_show_list',
                'instagram_manage_insights' // you need this permission to use 'business_discovery' endpoint
            ];

            $data['login_url'] = $this->helper->getLoginUrl($this->conf->getFacebook_redirect_uri(), $permission);
        }

        return $data;
    }
}

