<?php
namespace App\MyClasses\GraphApi;
class Configuration
{
    private $appsecret_proof_mode = true;
    private $facebook_app_id = '1070234180072644';
    private $facebook_app_secret = 'cc8b0cfb72d8cc80ddb1be69b42470ac';
    private $facebook_redirect_uri = 'http://localhost:8888/instagram_graph_api/index.php';
    private $endpoint_base = 'https://graph.facebook.com/v8.0/';
    private $default_graph_version = 'v8.0';

    // Long lived access token
    private $accessToken = 'EAAPNX1AhNMQBALv4iWJ2BAE4bDRwHZC22To0QKkHtVf3ryPjX38a1aHX011l7fq7jHTJZC0whNVFK4RRjAybnLQDTZCZAYHRtTsV4Ezr6KZCZCCCe7dN2R1KpGaqWZAzh00SZC87nxqKcfoTZA793d97juAB5beRjwi8yKIxZBtbwDNQZDZD';
    // page id = facebook page id
    private $pageId = '198479507164340';
    // instagram business account id
    private $instagramAccountId ='17841403089870520';

    /*
    public function __construct()
    {
        session_start();
    }
    */

    public function setAppSecretProofMode($bool)
    {
        $this->appsecret_proof_mode = $bool;
    }

    public function getAppSecretProofMode()
    {
        return $this->appsecret_proof_mode;
    }

    public function getFacebook_app_id()
    {
        return $this->facebook_app_id;
    }
    public function getFacebook_app_secret()
    {
        return $this->facebook_app_secret;
    }
    public function getFacebook_redirect_uri()
    {
        return $this->facebook_redirect_uri;
    }
    public function getEndpoint_base()
    {
        return $this->endpoint_base;
    }
    public function getDefault_graph_version()
    {
        return $this->default_graph_version;
    }

    // Long lived access token
    public function getAccessToken()
    {
        return $this->accessToken;
    }
    // page id = facebook page id
    public function getPageId()
    {
        return $this->pageId;
    }
    // instagram business account id
    public function getInstagramAccountId()
    {
        return $this->instagramAccountId;
    }
}
