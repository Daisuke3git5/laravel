<?php

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


    

//Q3.「http://XXXXXX.jp/XXX というアクセスが来たときに、 
//AAAControllerのbbbというAction に渡すRoutingの設定」を書いてみてください。
 //Route::get('XXX', 'XXX\AAAController@bbb');



//Q4.【応用】 前章でAdmin/ProfileControllerを作成し、
//add Action, edit Actionを追加しました。
//web.phpを編集して、
//admin/profile/create にアクセスしたら ProfileController の add Action に、
//admin/profile/edit にアクセスしたら ProfileController の edit Action に割り当てるように設定してください。
Route::group(['prefix' => 'admin','middleware' =>'auth' ], function() {
    Route::get('news/edit', 'Admin\NewsController@edit');
    Route::post('news/edit', 'Admin\NewsController@update');
    Route::get('news/delete', 'Admin\NewsController@delete');
    Route::get('profile/create', 'Admin\ProfileController@add');
    Route::post('profile/create', 'Admin\ProfileController@create');
    Route::get('profie', 'Admin\ProfileController@index');
    Route::get('profile/edit', 'Admin\ProfileController@edit');
    Route::post('profile/edit', 'Admin\ProfileController@update');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
