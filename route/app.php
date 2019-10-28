<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;
// 验证码
Route::get('captcha/[:id]', "\\think\\captcha\\CaptchaController@index");
Route::group('api',function(){
    Route::get('5ce78d450636c',"app\\member\\controller\\api\\Index@index");
    Route::miss(function() {
        return '404 Not Found!';
    });
});