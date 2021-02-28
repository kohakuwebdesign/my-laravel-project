<?php

namespace App\Http\ViewComposers;

use App\Models\Prefecture;
use Illuminate\View\View;

class IndexSidebarComposer
{
    private $prefectureList;

    /**
     * Init sidebar list of prefectures
     *
     * @return void
     */
    public function __construct()
    {
        $this->prefectureList = Prefecture::withCount([
            // Just for counting
            'posts'=>function($query){
                $query->where('is_published',1)
                    ->where('is_deleted',0)
                    ->where('prefecture_id', '<>', 'NULL');
            }
            ])->whereHas('posts',function($query){
            // Actually get data
                $query->where('is_published',1)
                    ->where('is_deleted',0)
                    ->where('prefecture_id', '<>', 'NULL');
            })->get();
    }

    /**
     * Show sidebar list of prefectures
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('sidebar_contents', $this->prefectureList);
    }
}
