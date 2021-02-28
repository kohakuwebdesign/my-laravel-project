<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Show all aminals list
     *
     * @return object
     */
    public function index()
    {
        $items = Post::where('is_published', 1)->orderBy('data_created_at', 'desc')->paginate(10);
        return view('index', ['data' => $items]);
    }

    /**
     * Show prefecture related list
     *
     * @param Request $request
     * @return object
     */
    public function showPrefectureRelatedList(Request $request)
    {
        $items = Post::whereHas('prefecture', function($query) use ($request){
            $query->where('slug',$request->prefecture_slug);
        })->where('is_published', 1)->orderBy('data_created_at', 'desc')->paginate(10);

        return view('list', ['data' => $items]);
    }
}
