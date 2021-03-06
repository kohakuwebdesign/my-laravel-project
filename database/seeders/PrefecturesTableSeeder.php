<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrefecturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['label' => '北海道','slug' => 'hokkaido'],
            ['label' => '青森県','slug' => 'aomori'],
            ['label' => '岩手県','slug' => 'iwate'],
            ['label' => '宮城県','slug' => 'miyagi'],
            ['label' => '秋田県','slug' => 'akita'],
            ['label' => '山形県','slug' => 'yamagata'],
            ['label' => '福島県','slug' => 'fukushima'],
            ['label' => '茨城県','slug' => 'ibaraki'],
            ['label' => '栃木県','slug' => 'tochigi'],
            ['label' => '群馬県','slug' => 'gunma'],
            ['label' => '埼玉県','slug' => 'saitama'],
            ['label' => '千葉県','slug' => 'chiba'],
            ['label' => '東京都','slug' => 'tokyo'],
            ['label' => '神奈川県','slug' => 'kanagawa'],
            ['label' => '新潟県','slug' => 'niigata'],
            ['label' => '富山県','slug' => 'toyama'],
            ['label' => '石川県','slug' => 'ishikawa'],
            ['label' => '福井県','slug' => 'fukui'],
            ['label' => '山梨県','slug' => 'yamanashi'],
            ['label' => '長野県','slug' => 'nagano'],
            ['label' => '岐阜県','slug' => 'gifu'],
            ['label' => '静岡県','slug' => 'shizuoka'],
            ['label' => '愛知県','slug' => 'aichi'],
            ['label' => '三重県','slug' => 'mie'],
            ['label' => '滋賀県','slug' => 'shiga'],
            ['label' => '京都府','slug' => 'kyoto'],
            ['label' => '大阪府','slug' => 'osaka'],
            ['label' => '兵庫県','slug' => 'hyogo'],
            ['label' => '奈良県','slug' => 'nara'],
            ['label' => '和歌山県','slug' => 'wakayama'],
            ['label' => '鳥取県','slug' => 'tottori'],
            ['label' => '島根県','slug' => 'shimane'],
            ['label' => '岡山県','slug' => 'okayama'],
            ['label' => '広島県','slug' => 'hiroshima'],
            ['label' => '山口県','slug' => 'yamaguchi'],
            ['label' => '徳島県','slug' => 'tokushima'],
            ['label' => '香川県','slug' => 'kagawa'],
            ['label' => '愛媛県','slug' => 'ehime'],
            ['label' => '高知県','slug' => 'kochi'],
            ['label' => '福岡県','slug' => 'fukuoka'],
            ['label' => '佐賀県','slug' => 'saga'],
            ['label' => '長崎県','slug' => 'nagasaki'],
            ['label' => '熊本県','slug' => 'kumamoto'],
            ['label' => '大分県','slug' => 'oita'],
            ['label' => '宮崎県','slug' => 'miyazaki'],
            ['label' => '鹿児島県','slug' => 'kagoshima'],
            ['label' => '沖縄県','slug' => 'okinawa']
        ];

        foreach($items as $item) {
            $param = [
                'label' => $item['label'],
                'slug' => $item['slug']
            ];
            DB::table('prefectures')->insert($param);
        }
    }
}
