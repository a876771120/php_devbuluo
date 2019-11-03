<?php
// +----------------------------------------------------------------------
// | devbuluo [ 基于thinkphp6框架 ]
// +----------------------------------------------------------------------
// | 版权所有 2017~2020 devbuluo [ http://www.devbuluo.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://www.devbuluo.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
use think\facade\Route;
//MISS路由定义
Route::miss('Miss/index');
Route::rule('5db5c20c9abaa','app\api\controller\interface\publics@getAccessToken','POST')->middleware(["ApiPermission","ApiAuth","ApiRequest","ApiLog"]);
Route::rule('5dbe9fafa8b2f','app\member\controller\interface\publics@login','POST')->middleware(["ApiPermission","ApiAuth","ApiRequest","ApiLog"]);