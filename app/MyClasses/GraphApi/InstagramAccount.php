<?php
namespace App\MyClasses\GraphApi;
include_once 'Configuration.php';

/*
 *
 * Getting instagram account id (instagram business account id)
 *
 */

class InstagramAccount
{

    private $instagramAccountIdEndpoint;

    public function __construct($accesstoken, $pageId)
    {
        $accesstoken = urlencode($accesstoken);
        $pageId = urlencode($pageId);

        $conf = new Configuration();

        // get instagram account id endpoint
        $this->instagramAccountIdEndpoint = $conf->getEndpoint_base() . $pageId;

        if ($conf->getAppSecretProofMode() == true) {
            // endpoint params
            $igParams = array(
                'fields' => 'instagram_business_account',
                'access_token' => $accesstoken,
                'appsecret_proof' => hash_hmac('sha256', $accesstoken, $conf->getFacebook_app_secret())
            );
        } else {
            // endpoint params
            $igParams = array(
                'fields' => 'instagram_business_account',
                'access_token' => $accesstoken
            );
        }

        // add paramst to endpoint
        $this->instagramAccountIdEndpoint .= '?' . http_build_query($igParams);
    }

    function getResponse()
    {
        // setup curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->instagramAccountIdEndpoint);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // make call and get response
        $response = curl_exec($ch);

        curl_close($ch);

        $responseArray = json_decode($response, true);

        return $responseArray;
        unset($responseArray['data'][0]['access_token']);
    }

    public function getEndpoint()
    {
        return $this->instagramAccountIdEndpoint;
    }
}
