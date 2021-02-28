<?php
namespace App\MyClasses\GraphApi;
include_once 'Configuration.php';
/*
 *
 * Getting facebook pages
 *
 */

class FacebookPage
{
    private $pages_endpoint;

    public function __construct($long_lived_accesstoken)
    {
        $long_lived_accesstoken = urlencode($long_lived_accesstoken);
        $conf = new Configuration();

        // get pages endpoint
        $this->pages_endpoint = $conf->getEndpoint_base() . 'me/accounts';

        if ($conf->getAppSecretProofMode() == true) {
            // endpoint params
            $page_params = array(
                'access_token' => $long_lived_accesstoken,
                'appsecret_proof' => hash_hmac('sha256', $long_lived_accesstoken, $conf->getFacebook_app_secret())
            );
        } else {
            // endpoint params
            $page_params = array(
                'access_token' => $long_lived_accesstoken
            );
        }

        // add paramst to endpoint
        $this->pages_endpoint .= '?' . http_build_query($page_params);
    }

    public function getFacebookPages()
    {
        // setup curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->pages_endpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // make call and get response
        $response = curl_exec($ch);

        curl_close($ch);

        $responseArray = json_decode($response, true);

        // unset($responseArray['data'][0]['access_token']);

        return $responseArray;
    }

    public function getEndpoint()
    {
        return $this->pages_endpoint;
    }
}
