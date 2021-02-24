<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('yourblog','App\Http\Controllers\YourBlogController@index');
//記事投稿フォーム
Route::get('yourblog/editor','App\Http\Controllers\YourBlogController@editor')->middleware('auth');
Route::post('yourblog/editor','App\Http\Controllers\YourBlogController@post');
//記事表示
Route::get('yourblog/article/{id?}','App\Http\Controllers\YourBlogController@article');
Route::post('yourblog/article','App\Http\Controllers\YourBlogController@appendArticle');
Route::post('yourblog/article/delete','App\Http\Controllers\YourBlogController@deleteArticle');
//記事一覧
Route::get('yourblog/articles','App\Http\Controllers\YourBlogController@articles');
//リスト一覧
Route::get('yourblog/lists','App\Http\Controllers\YourBlogController@lists');
Route::post('yourblog/lists','App\Http\Controllers\YourBlogController@delete_list');
//リストの内容一覧
Route::get('yourblog/list_content/{id?}','App\Http\Controllers\YourBlogController@list_content');
Route::post('yourblog/list_content','App\Http\Controllers\YourBlogController@deleteArticleOnList');
//リストの追加
Route::get('yourblog/addList','App\Http\Controllers\YourBlogController@add_list')->middleware('auth');
Route::post('yourblog/addList','App\Http\Controllers\YourBlogController@create_list');


Auth::routes([
    'register' => false,
    'reset'    => false,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
