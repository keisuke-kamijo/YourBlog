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
