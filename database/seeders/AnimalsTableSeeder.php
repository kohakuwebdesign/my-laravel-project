<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnimalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['label' => '犬','slug' => 'dog'],
            ['label' => '猫','slug' => 'cat'],
        ];
        foreach($items as $item) {
            $param = [
                'label' => $item['label'],
                'slug' => $item['slug']
            ];
            DB::table('animals')->insert($param);
        }
    }
}
