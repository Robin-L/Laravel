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
Route::get('/', 'StaticPagesController@home');
Route::get('/help', 'StaticPagesController@help');
Route::get('/about', 'StaticPagesController@about');
