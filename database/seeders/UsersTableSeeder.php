<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => '坂口裕樹',
            'email' => 'info@atoriekohaku.com',
            'password' => '$2y$10$0ct7zBvwSqH6yMLG6/G8JOez5SKqzBh.HLD.xckvhhbsB7ksHDN4a'
        ]);
    }
}
