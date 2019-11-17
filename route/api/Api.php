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
Route::rule('5db5c20c9abaa','app\api\controller\api\Build@accessToken','POST')->middleware(["LogStart","ApiRequest","LogEnd","Response"]);
Route::rule('5dbfd774098a5','app\api\controller\api\Publics@getVersion','POST')->middleware(["LogStart","ApiRequest","LogEnd","Response"]);
Route::rule('5dbfd8d218a80','app\api\controller\api\Publics@splashAd','POST')->middleware(["LogStart","ApiRequest","ApiAuth","ApiPermission","LogEnd","Response"]);
Route::rule('5dc6001a140a4','app\article\controller\api\Category@index','GET')->middleware(["LogStart","ApiRequest","ApiAuth","ApiPermission","LogEnd","Response"]);
Route::rule('5dd15bae57d98','app\member\controller\api\publics@login','POST')->middleware(["LogStart","ApiRequest","ApiAuth","ApiPermission","LogEnd","Response"]);
Route::rule('5dd15dc8bafd4','app\member\controller\api\publics@code','POST')->middleware(["LogStart","ApiRequest","ApiAuth","ApiPermission","LogEnd","Response"]);
Route::rule('5dd15ed0cabe6','app\member\controller\api\publics@register','POST')->middleware(["LogStart","ApiRequest","ApiAuth","ApiPermission","LogEnd","Response"]);