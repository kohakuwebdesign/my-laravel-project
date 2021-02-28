<?php

namespace App\Console;

use App\Models\AdminState;
use App\MyClasses\PostMaker;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $adminstate = AdminState::latest()->first();
            $postMaker = new PostMaker();
            $animalId = 1;
            $postMaker->collectTwitter($adminstate->twitter_dog_keyword, $adminstate->twitter_search_limit, $animalId);
            $postMaker->collectInstagram($adminstate->instagram_dog_keyword, $adminstate->instagram_search_limit, $animalId);
        })->cron('* * * * *');

        $schedule->call(function () {
            $adminstate = AdminState::latest()->first();
            $postMaker = new PostMaker();
            $animalId = 2;
            $postMaker->collectTwitter($adminstate->twitter_cat_keyword, $adminstate->twitter_search_limit, $animalId);
            $postMaker->collectInstagram($adminstate->instagram_cat_keyword, $adminstate->instagram_search_limit, $animalId);
        })->cron('* * * * *');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
