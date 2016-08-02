<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Event::listen('illuminate.query',function($query){
     // var_dump($query);
});

Route::get('/', function () {
    return view('welcome');
});

//后台页面显示的路由
Route::get('/admin','AdminController@index');

//练习:后台显示页面路由
// Route::get('/admin1','AdminsController@indexs');

//用户管理
Route::controller('/user','UserController');
//练习:用户管理
// Route::controller('/users','UsersController');

//分类管理
Route::controller('/cate','CateController');

//商品管理
Route::controller('/goods','GoodsController');
