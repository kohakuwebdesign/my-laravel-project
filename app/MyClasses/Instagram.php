<?php


namespace App\MyClasses;
use App\MyClasses\GraphApi;

class Instagram
{
    private $posts;
    private $instagramBusinessAccountId;
    private $longTermAccesstoken;

    /**
     * Get data from instagram thru Graph Api
     *
     * @param string $keyword
     * @param integer $count
     * @param integer $animalId
     * @return array
     */
    public function getDataForDb($keyword, $count, $animalId)
    {
        $this->instagramBusinessAccountId = config('app.instagram_business_account_id');
        $this->longTermAccesstoken = config('app.graphapi_long_lived_accesstoken');

        $instagramHashtag = new GraphApi\InstagramHashtag();
        $response = $instagramHashtag->getHashTagId($this->longTermAccesstoken, $this->instagramBusinessAccountId, $keyword);
        $hashtagId = $response['data'][0]['id'];
        $this->posts = $instagramHashtag->getPostsDataFromHashtagId($hashtagId, $this->instagramBusinessAccountId, $this->longTermAccesstoken, $count);
        $helper = new GraphApi\GraphApiHelpter();
        $data = [];
        $dataForDb = [];

        if (isset($this->posts['data'])) {
            foreach ($this->posts['data'] as $post) {
                $instagramPostEmbed = new GraphApi\InstagramPostEmbed($this->longTermAccesstoken, $post['permalink']);
                $embedTag = $instagramPostEmbed->getResponse()['html'];
                $array = $helper->getHashtagList($post['caption']);
                $newArray = [];

                for ($i = 0; $i < count($array); $i++){
                    $str = str_replace('#','',$array[$i]);
                    $obj = new \stdClass();
                    $obj->text =  $str;
                    $newArray[$i] = $obj;
                }

                if (isset($post['media_url'])) {
                    $media_url = $post['media_url'];
                } else {
                    $media_url = '';
                }
                $data['animal_id'] = $animalId;
                $data['data_id'] = $post['id'];
                $data['text'] = $post['caption'];
                $data['data_created_at'] = date('Y-m-d H:i:s', strtotime($post['timestamp']));
                $data['media_url'] = $media_url;
                $data['embed_tag'] = $embedTag;
                $data['hashtags'] = $newArray;
                array_push($dataForDb, $data);
            }
        }

        return $dataForDb;
    }

}
