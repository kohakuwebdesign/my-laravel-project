<?php
namespace App\MyClasses\GraphApi;
include_once 'Configuration.php';

class InstagramHashtag
{
    private $hashtagIdEndpoint;
    private $postDataEndpoint;

    public function getHashTagId($infinit_term_accesstoken, $instagram_business_account_id, $hashTag)
    {
        $infinit_term_accesstoken = urlencode($infinit_term_accesstoken);
        $instagram_business_account_id = urlencode($instagram_business_account_id);
        // $hashTag = urlencode(utf8_encode($hashTag));

        $conf = new Configuration();

        // get hastag id endpoint
        $endpoint = $conf->getEndpoint_base() . 'ig_hashtag_search';

        if ($conf->getAppSecretProofMode() == true) {
            // endpoint params
            $igParams = array(
                'user_id' => $instagram_business_account_id,
                'q' => $hashTag,
                'access_token' => $infinit_term_accesstoken,
                'appsecret_proof' => hash_hmac('sha256', $infinit_term_accesstoken, $conf->getFacebook_app_secret())
            );
        } else {
            // endpoint params
            $igParams = array(
                'user_id' => $instagram_business_account_id,
                'q' => $hashTag,
                'access_token' => $infinit_term_accesstoken,
            );
        }

        // add paramst to endpoint
        $endpoint .= '?' . http_build_query($igParams);
        $this->hashtagIdEndpoint = $endpoint;

        return $this->getResponse($endpoint);
    }

    public function getHashtagIdEndpoint()
    {
        return $this->hashtagIdEndpoint;
    }


    public function getPostsDataFromHashtagId($instagram_hashtag_id, $instagram_business_account_id, $infinit_term_accesstoken, $count)
    {
        $instagram_business_account_id = urlencode($instagram_business_account_id);
        $infinit_term_accesstoken = urlencode($infinit_term_accesstoken);

        $instagram_hashtag_id = urlencode($instagram_hashtag_id);

        $conf = new Configuration();

        // get hastag id endpoint
        $endpoint = $conf->getEndpoint_base() . $instagram_hashtag_id . '/recent_media';

        if ($conf->getAppSecretProofMode() == true) {
            // endpoint params
            $igParams = array(
                'fields' => 'media_url,caption,permalink,id,media_type,timestamp',
                'limit' => $count,
                'user_id' => $instagram_business_account_id,
                'access_token' => $infinit_term_accesstoken,
                'appsecret_proof' => hash_hmac('sha256', $infinit_term_accesstoken, $conf->getFacebook_app_secret())
            );
        } else {
            // endpoint params
            $igParams = array(
                'fields' => 'media_url,caption,permalink,id,media_type,timestamp',
                'limit' => $limit,
                'user_id' => $instagram_business_account_id,
                'access_token' => $infinit_term_accesstoken,
            );
        }

        // add paramst to endpoint
        $endpoint .= '?' . http_build_query($igParams);
        $this->postDataEndpoint = $endpoint;

        return $this->getResponse($endpoint);
    }

    public function getPostDataEndpoint()
    {
        return $this->postDataEndpoint;
    }

    public function getResponse($endpoint){
        // setup curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
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
}
