<?php

namespace App\Http\Controllers;

use App\Models\AdminState;
use App\Models\Post;
use App\Models\Prefecture;
use App\MyClasses\PostMaker;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show admin page data
     *
     * @return object
     */
    public function show()
    {
        $adminState = AdminState::latest()->first();
        $items = Post::where('is_deleted', 0)->orderBy('is_published', 'asc')->orderBy('data_created_at', 'desc')->paginate(20);
        $allPrefectures = Prefecture::all();

        foreach ($items as $item){
            $item->all_prefectures = $allPrefectures;
        }

        return view('admin.list', ['items' => $items, 'adminstate' => $adminState]);
    }

    /**
     * Logical delete
     *
     * @param Request $request
     * @return object
     */
    public function delete(Request $request)
    {
        $form = $request->all();
        unset($form['_token']);
        $post = Post::find($form['id']);
        $data = [
            'is_published' => 0,
            'is_deleted' => $form['is_deleted']
        ];
        $post->update($data);

        $prefectures = Prefecture::all();

        foreach ($prefectures as $prefecture) {
            if ($form['prefecture_id'] == $prefecture->id) {
                $directory = '/admin/' . $prefecture->slug;
                break;
            } else {
                $directory = '/admin';
            }
        }

        return redirect($directory);
    }

    /**
     * Update post
     *
     * @param Request $request
     * @return object
     */
    public function update(Request $request)
    {
        $form = $request->all();

        unset($form['_token']);
        unset($form['delete']);
        $post = Post::find($request->id);
        $data = [
            'is_published' => $form['is_published'],
            'prefecture_id' => $form['prefecture_id']
        ];
        $post->update($data);

        $prefectures = Prefecture::all();
        foreach ($prefectures as $prefecture) {
            if ($form['prefecture_id'] == $prefecture->id) {
                $directory = '/admin/' . $prefecture->slug;
                break;
            } else {
                $directory = '/admin';
            }
        }

        return redirect($directory);
    }

    /**
     * Update publish status
     *
     * @param Request $request
     * @return object
     */
    public function updatePublishState(Request $request)
    {
        $form = $request->all();
        unset($form['_token']);
        $post = Post::find($form['id']);
        $data = [
            'is_published' => $form['is_published']
        ];
        $post->update($data);
        return redirect('/admin');
    }

    /**
     * Update admin status
     *
     * @param Request $request
     * @return object
     */
    public function stateUpdate(Request $request)
    {
        $form = $request->all();
        unset($form['_token']);

        $adminState = AdminState::latest()->first();

        $adminState->fill($form)->update();


        return redirect('/admin');
    }

    /**
     * Do dog collection
     *
     * @return object
     */
    public function dogCollect()
    {
        $adminState = AdminState::latest()->first();
        $postMaker = new PostMaker();
        $animalId = 1;
        $postMaker->collectTwitter($adminState->twitter_dog_keyword, $adminState->twitter_search_limit, $animalId);
        $postMaker->collectInstagram($adminState->instagram_dog_keyword, $adminState->instagram_search_limit, $animalId);
        return redirect('/admin');
    }

    /**
     * Do cat collection
     *
     * @return object
     */
    public function catCollect()
    {
        $adminState = AdminState::latest()->first();
        $postMaker = new PostMaker();
        $animalId = 2;
        $postMaker->collectTwitter($adminState->twitter_cat_keyword, $adminState->twitter_search_limit, $animalId);
        $postMaker->collectInstagram($adminState->instagram_cat_keyword, $adminState->instagram_search_limit, $animalId);
        return redirect('/admin');
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
        })->orderBy('data_created_at', 'desc')->paginate(10);

        $allPrefectures = Prefecture::all();

        foreach ($items as $item){
            $item->all_prefectures = $allPrefectures;
        }

        return view('admin.list', ['items' => $items]);
    }
}
