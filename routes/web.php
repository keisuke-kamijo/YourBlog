<?php

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('yourblog','App\Http\Controllers\YourBlogController@index');
//記事投稿フォーム
Route::get('yourblog/editor','App\Http\Controllers\YourBlogController@editor');
Route::post('yourblog/editor','App\Http\Controllers\YourBlogController@post');
//記事表示
Route::get('yourblog/article/{id?}','App\Http\Controllers\YourBlogController@article');
Route::post('yourblog/article','App\Http\Controllers\YourBlogController@appendArticle');
//記事一覧
Route::get('yourblog/articles','App\Http\Controllers\YourBlogController@articles');
//リスト一覧
Route::get('yourblog/lists','App\Http\Controllers\YourBlogController@lists');
//リストの内容一覧
Route::get('yourblog/list_content/{id?}','App\Http\Controllers\YourBlogController@list_content');

