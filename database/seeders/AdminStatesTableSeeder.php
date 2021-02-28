<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminStatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'g_map_api_daily_count' => 0,
            'g_map_api_limit' => 10,
            'instagram_search_limit' => 10,
            'twitter_search_limit' => 10,
            'twitter_dog_keyword' => '#迷い犬 -RT',
            'instagram_dog_keyword' => '迷い犬',
            'twitter_cat_keyword' => '#迷い猫 -RT',
            'instagram_cat_keyword' => '迷い猫'
        ];

        DB::table('admin_states')->insert($data);
    }
}
