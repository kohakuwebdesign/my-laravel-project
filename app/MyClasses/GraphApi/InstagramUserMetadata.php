<?php
namespace App\MyClasses\GraphApi;
include_once 'Configuration.php';
/*
 *
 * Getting instagram a user's metadata
 *
 */

class InstagramUserMetadata
{
    private $userMetaDataEndpoint;

    public function __construct($accesstoken, $instagramAccountId)
    {
        $accesstoken = urlencode($accesstoken);
        $instagramAccountId = urlencode($instagramAccountId);
        $conf = new Configuration();

        // get instagram account id endpoint
        $this->userMetaDataEndpoint = $conf->getEndpoint_base() . $instagramAccountId;

        if ($conf->getAppSecretProofMode() == true) {
            // endpoint params
            $igParams = array(
                'fields' => 'business_discovery.username(kohakuwebdesign){username,website,name,ig_id,id,profile_picture_url,biography,follows_count,followers_count,media_count,media{caption,like_count,comments_count,media_url,permalink,media_type}}',
                'access_token' => $accesstoken,
                'appsecret_proof' => hash_hmac('sha256', $accesstoken, $conf->getFacebook_app_secret())
            );
        } else {
            // endpoint params
            $igParams = array(
                'fields' => 'business_discovery.username(kohakuwebdesign){username,website,name,ig_id,id,profile_picture_url,biography,follows_count,followers_count,media_count,media{caption,like_count,comments_count,media_url,permalink,media_type}}',
                'access_token' => $accesstoken
            );
        }

        // add paramst to endpoint
        $this->userMetaDataEndpoint .= '?' . http_build_query($igParams);
    }

    public function getResponse()
    {
        // setup curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->userMetaDataEndpoint);
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
        return $this->userMetaDataEndpoint;
    }
}

