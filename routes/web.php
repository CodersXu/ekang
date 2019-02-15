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

/* Route::get('/', function () {
    return view('welcome');
}); */
 /**
 * 登录展示页面
 *
 * @var array
 */
Route::get('/',function(){
    return view('loginbase');
});
//登录页面
Route::get('login',function(){
    return view('login');
});
//Ajax登录验证
Route::any('logins', 'CinstitutionsController@validation');
//登录跳转首页
Route::any('profile', 'IndexController@validation');
//登录检验账号
Route::any('index', 'IndexController@index');
//退出登录
Route::any('loginout', 'IndexController@loginout');

Route::any('dev', 'IndexController@dev');

