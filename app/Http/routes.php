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

/**
 * 第一个参数指明了URL，第二个参数指明了处理该URL的控制器动作。
 * get表明这个路由将会响应GET请求，并将请求映射到指定的控制器动作上
 *
 * -------------------------------------------------------
 * 基本的HTTP操作
 * GET      常用于页面读取
 * POST     常用于数据提交
 * PATCH    常用于数据更新
 * DELETE   常用于数据删除
 * -----------------------
 * PATCH和DELETE是不被浏览器所支持的，但可通过添加隐藏域的方式来欺骗服务器
 */
Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

//Route::get('/signup', 'UsersController@create')->name('signup');
get('signup', 'UsersController@create')->name('signup');
// 第一个参数为资源名称，第二个参数为控制名称
resource('users', 'UsersController');

get('login', 'SessionsController@create')->name('login');   // 显示登录页面
post('login', 'SessionsController@store')->name('login');   // 创建新会话（登录）
delete('logout', 'SessionsController@destory')->name('logout'); // 销毁会话（退出登录）

get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email'); // 激活账号路由

// 密码重置
get('password/email', 'Auth\PasswordController@getEmail')->name('password.reset');       // 显示重置密码的邮箱发送页面
post('password/email', 'Auth\PasswordController@postEmail')->name('password.reset');     // 处理重置密码的邮箱发送操作
get('password/reset/{token}', 'Auth\PasswordController@getReset')->name('password.edit');// 显示重置密码的密码更新页面
post('password/reset', 'Auth\PasswordController@postReset')->name('password.update');    // 显示重置密码的密码更新请求
