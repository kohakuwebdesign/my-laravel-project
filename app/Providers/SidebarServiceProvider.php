<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class SidebarServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('index', 'App\Http\ViewComposers\IndexSidebarComposer');
        View::composer('list', 'App\Http\ViewComposers\IndexSidebarComposer');
        View::composer('admin.list', 'App\Http\ViewComposers\IndexSidebarComposer');
        View::composer('*', 'App\Http\ViewComposers\DogPrefectureListComposer');
        View::composer('*', 'App\Http\ViewComposers\CatPrefectureListComposer');
    }
}
