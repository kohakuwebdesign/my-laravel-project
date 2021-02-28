<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class DogController extends Controller
{
    /**
     * Show cat list
     *
     * @return object
     */
    public function show()
    {
        $items = Post::whereHas('animal', function($query){
            $query->where('id', 1);
        })->where('is_published', 1)->orderBy('data_created_at', 'desc')->paginate(10);

        return view('dog.list', ['data' => $items]);
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
        })->whereHas('animal', function($query) use ($request){
            $query->where('id',1);
        })->where('is_published', 1)->orderBy('data_created_at', 'desc')->paginate(10);

        return view('dog.list', ['data' => $items]);
    }
}
