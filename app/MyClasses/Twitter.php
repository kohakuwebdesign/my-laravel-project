<?php
namespace App\MyClasses;

use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter {

    private $consumerKey;
    private $consumerSecret;
    private $accessToken;
    private $accessTokenSecret;
    private $connection;
    private $dataForDb = array();

    /**
     * Connection to Twitter Api
     *
     * @return void
     */
    public function __construct()
    {
        $this->consumerKey = config('app.twitter_consumer_key');
        $this->consumerSecret = config('app.twitter_consumer_secret');
        $this->accessToken = config('app.twitter_access_token');
        $this->accessTokenSecret = config('app.twitter_access_token_secret');

        // connect to api
        $this->connection = new TwitterOAuth($this->consumerKey, $this->consumerSecret, $this->accessToken, $this->accessTokenSecret);
    }

    /**
     * Get response from Twitter Api
     *
     * @param string $keyword
     * @param integer $count
     * @return object
     */
    public function getTwitterResponse($keyword, $count)
    {
        $twitterResponse = $this->connection->get("search/tweets", array("q" => $keyword, 'count' => $count, 'result_type' => 'recent'));
        return $twitterResponse;
    }

    /**
     * Get twitter embed code
     *
     * @param string $userName
     * @param string $tweetId
     * @return object
     */
    public function getTwitterOEmbed($userName, $tweetId)
    {
        $tweetUrl = 'https://twitter.com/'.$userName.'/status/'.$tweetId;
        $response = $this->connection->get("statuses/oembed", array("url" => $tweetUrl, "align" => "center", "maxwidth" => "1000"));
        return $response;
    }

    public function getApiStatus()
    {
        $twitterResponse = $this->connection->get("application/rate_limit_status", array("resources" => "search"));
        return $twitterResponse;
    }

    /**
     * Create data array for database
     *
     * @param string $keyword
     * @param integer $count
     * @param integer $animalId
     * @return array
     */
    public function getTweetsForDb($keyword, $count, $animalId)
    {
        $twitterResponse = $this->getTwitterResponse($keyword, $count, $animalId);
        for ($i = 0; $i < count($twitterResponse->statuses); $i++) {
            if(isset($twitterResponse->statuses[$i]->entities->media[0])) {
                $data = array();
                $data['animal_id'] = $animalId;
                $data['data_id'] = $twitterResponse->statuses[$i]->id;
                $data['text'] = $twitterResponse->statuses[$i]->text;
                $data['data_created_at'] = date('Y-m-d H:i:s', strtotime($twitterResponse->statuses[$i]->created_at));
                $data['media_url'] = $twitterResponse->statuses[$i]->entities->media[0]->media_url;
                $data['embed_tag'] = $this->getTwitterOEmbed($twitterResponse->statuses[$i]->user->screen_name, $twitterResponse->statuses[$i]->id)->html;
                $data['hashtags'] = $twitterResponse->statuses[$i]->entities->hashtags;
                array_push($this->dataForDb, $data);
            }
        }
        return $this->dataForDb;
    }

    /**
     * Get prefecture name from tweet text
     *
     * @return void
     */
    public function getPrefectureFromTweetText()
    {
        $dataForDb = $this->dataForDb;
        $prefectureList = array();
        for($i = 0; $i < count($dataForDb); $i++) {
            $prefectureList[$i] = $dataForDb[$i]['text'];
        }
    }
}
