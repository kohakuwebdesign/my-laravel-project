<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebservicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['label' => 'Twiiter','slug' => 'twitter'],
            ['label' => 'Instagram','slug' => 'instagram'],
        ];
        foreach($items as $item) {
            $param = [
                'label' => $item['label'],
                'slug' => $item['slug']
            ];
            DB::table('webservices')->insert($param);
        }
    }
}
