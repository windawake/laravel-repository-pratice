<?php
// affiliate前台用户路由

Route::namespace('Frontend')->group(function(){

    Route::group(['prefix' => 'affiliate'], function () {
        // 用户登录
        Route::post('login', 'AffiliateController@login');
        // 用户注册
        Route::post('register', 'AffiliateController@register');
        // 发重置密码邮件
        Route::post('password/email', 'AffiliateController@password_email');

        // 重置密码
        Route::post('password/reset', 'AffiliateController@password_reset');
    });
    
});


Route::group(['namespace' => 'Frontend', 'middleware' => ['auth:frontend']], function(){
    Route::group(['prefix' => 'affiliate'], function () {
        // 验证token
        Route::post('me', 'AffiliateController@me');
        // 用户登出
        Route::post('logout', 'AffiliateController@logout');
        // 修改密码
        Route::post('password/update', 'AffiliateController@password_update');
    });
});
