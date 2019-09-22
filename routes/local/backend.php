<?php
// 后台用户路由

use Illuminate\Support\Facades\Redis;

Route::namespace('Backend')->group(function(){
    Route::group(['prefix' => 'admin'], function () {
        // 用户登录
        Route::post('login', 'AdminController@login');
        // 用户注册
        Route::post('register', 'AdminController@register');
    });
    
});

Route::group(['namespace' => 'Backend', 'middleware' => 'auth:backend'], function(){
    Route::group(['prefix' => 'admin'], function () {
        // 验证token
        Route::post('me', 'AdminController@me');
    });
});