<?php
namespace App\MyClasses;
use App\Models\AdAddress;
use App\Models\Post;
use App\Models\Prefecture;
use Illuminate\Support\Facades\DB;

class PostMaker
{
    private $twitter;
    private $instagram;

    public function __construct()
    {
        $this->twitter = app('App\MyClasses\Twitter');
        $this->instagram = app('App\MyClasses\Instagram');
    }

    /*
     * Collect data from Twitter and insert into database
     *
     * @param string $keyword
     * @param integer $count
     * @param integer $animalId
     * @return void
     */
    public function collectTwitter($keyword, $count, $animalId)
    {
        $dataForDb = $this->twitter->getTweetsForDb($keyword, $count, $animalId);
        $this->insertIntoDb($dataForDb);
    }

    /*
     * Collect data from Instagram and insert into database
     *
     * @param string $keyword
     * @param integer $count
     * @param integer $animalId
     * @return void
     */
    public function collectInstagram($keyword, $count, $animalId)
    {
        $dataForDb = $this->instagram->getDataForDb($keyword, $count, $animalId);
        $this->insertIntoDb($dataForDb);
    }

    /*
     * Gets Prefecture id from post text
     *
     * @param string $text
     * @return integer|null
     */
    public function getPrefId($text)
    {
        $mecab = new MecabApi();
        $items = $mecab->getResponse($text);
        $target = '';
        // Get prefecture name which is at very first meet
        foreach ($items as $item) {
            if(isset($item['features'])){
                if(preg_match('/地域/', $item['features'])) {
                    $target = $item['surface'];
                    break;
                }
            }
        }

        $prefectureId = Null;
        if($target != '') {
            // Get prefecture id from prefecture name
            $items = AdAddress::where(DB::raw('CONCAT(ken_name,city_name,town_name)'), 'LIKE', '%' . $target . '%')->get();
            if(isset($items[0]->ken_name)){
                $prefecture = Prefecture::where('label', $items[0]->ken_name)->first();
                $prefectureId = $prefecture->id;
            }
        }

        return $prefectureId;
    }

    /*
     * Insert data into database
     *
     * @param array $dataForDb
     * @return void
     */
    public function insertIntoDb($dataForDb)
    {
        for ($i = 0; $i < count($dataForDb); $i++) {
            // If the post has image then insert into database
            if ($dataForDb[$i]['media_url'] != '') {

                // Exception filters
                if ((preg_match('/リポスト/',$dataForDb[$i]['text']) == 0) &&
                    (preg_match('/Repost/',$dataForDb[$i]['text']) == 0) &&
                    (preg_match('/repost/',$dataForDb[$i]['text']) == 0) &&
                    (preg_match('/見つかりました/',$dataForDb[$i]['text']) == 0) &&
                    (preg_match('/帰ってきました/',$dataForDb[$i]['text']) == 0) &&
                    (preg_match('/おかえり/',$dataForDb[$i]['text']) == 0) &&
                    (preg_match('/一件落着/',$dataForDb[$i]['text']) == 0)) {

                    // Include filters
                    if ((preg_match('/探して/',$dataForDb[$i]['text']) == 1) ||
                        (preg_match('/居なく/',$dataForDb[$i]['text']) == 1) ||
                        (preg_match('/いなく/',$dataForDb[$i]['text']) == 1) ||
                        (preg_match('/見かけ/',$dataForDb[$i]['text']) == 1) ||
                        (preg_match('/見掛け/',$dataForDb[$i]['text']) == 1) ||
                        (preg_match('/知りません/',$dataForDb[$i]['text']) == 1) ||
                        (preg_match('/逃げ/',$dataForDb[$i]['text']) == 1) ||
                        (preg_match('/逃走/',$dataForDb[$i]['text']) == 1) ||
                        (preg_match('/脱走/',$dataForDb[$i]['text']) == 1) ||
                        (preg_match('/はぐれ/',$dataForDb[$i]['text']) == 1) ||
                        (preg_match('/拡散/',$dataForDb[$i]['text']) == 1) ||
                        (preg_match('/目撃/',$dataForDb[$i]['text']) == 1) ||
                        (preg_match('/保護されています/',$dataForDb[$i]['text']) == 1) ||
                        (preg_match('/保護しています/',$dataForDb[$i]['text']) == 1) ||
                        (preg_match('/行方不明/',$dataForDb[$i]['text']) == 1)) {

                        // If the data id is not exist in the database then insert it
                        if (Post::where('data_id', $dataForDb[$i]['data_id'])->exists() == false) {

                            unset($dataForDb[$i]['hashtags']);

                            // Get prefecture id from text
                            $prefecture_id = $this->getPrefId($dataForDb[$i]['text']);
                            $dataForDb[$i]['prefecture_id'] = $prefecture_id;

                            // If prefecture id is found then publish it. others don't publish it
                            if($prefecture_id != Null){
                                $dataForDb[$i]['is_published'] = 1;
                            } else {
                                $dataForDb[$i]['is_published'] = 0;
                            }

                            // Save data
                            $post = new Post();
                            $post->create($dataForDb[$i])->id;
                        }
                    }
                }
            }
        }
    }
}
