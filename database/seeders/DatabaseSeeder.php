<?php

namespace Database\Seeders;

use App\Models\AdminState;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(PrefecturesTableSeeder::class);
        $this->call(AnimalsTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(WebservicesTableSeeder::class);
        $this->call(AdminStatesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
