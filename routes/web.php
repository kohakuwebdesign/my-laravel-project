<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);

// all animals related routes
Route::get('/', [App\Http\Controllers\IndexController::class, 'index'])->name('index');
Route::get('/all/{prefecture_slug}', [App\Http\Controllers\IndexController::class, 'showPrefectureRelatedList'])->name('all.prefecture');

// dog related routes
Route::get('/dog', [App\Http\Controllers\DogController::class, 'show'])->name('dog');
Route::get('/dog/{prefecture_slug}', [App\Http\Controllers\DogController::class, 'showPrefectureRelatedList'])->name('dog.prefecture');

// cat related routes
Route::get('/cat', [App\Http\Controllers\CatController::class, 'show'])->name('cat');
Route::get('/cat/{prefecture_slug}', [App\Http\Controllers\CatController::class, 'showPrefectureRelatedList'])->name('cat.prefecture');

// admin related routes
Route::post('/admin/state', [App\Http\Controllers\AdminController::class, 'stateUpdate'])->name('admin.state');
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'show'])->name('admin');
Route::get('/admin/{prefecture_slug}', [App\Http\Controllers\AdminController::class, 'showPrefectureRelatedList'])->name('admin.prefecture');
Route::post('/admin', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.update');;
Route::post('/admin/publish', [App\Http\Controllers\AdminController::class, 'updatePublishState'])->name('admin.publish');
Route::post('/admin/delete', [App\Http\Controllers\AdminController::class, 'delete'])->name('admin.delete');
Route::post('/admin/collect/dog', [App\Http\Controllers\AdminController::class, 'dogCollect'])->name('admin.collect.dog');
Route::post('/admin/collect/cat', [App\Http\Controllers\AdminController::class, 'catCollect'])->name('admin.collect.cat');
