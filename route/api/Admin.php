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
Route::group('appgroup', function () {
    Route::rule('index', 'appgroup/index');
    Route::rule('add', 'appgroup/add');
    Route::rule('edit', 'appgroup/edit');
    Route::rule('enable', 'appgroup/enable');
    Route::rule('disable', 'appgroup/disable');
    Route::rule('delete', 'appgroup/delete');
});
Route::group('app', function () {
    Route::rule('index', 'app/index');
    Route::rule('add', 'app/add');
    Route::rule('edit', 'app/edit');
    Route::rule('enable', 'app/enable');
    Route::rule('disable', 'app/disable');
    Route::rule('getSecret', 'app/getSecret');
    Route::rule('delete', 'app/delete');
});
Route::group('group', function () {
    Route::rule('index', 'group/index');
    Route::rule('add', 'group/add');
    Route::rule('edit', 'group/edit');
    Route::rule('enable', 'group/enable');
    Route::rule('disable', 'group/disable');
    Route::rule('delete', 'group/delete');
});
Route::group('index', function () {
    Route::rule('refresh', 'index/refresh');
    Route::rule('index', 'index/index');
    Route::rule('add', 'index/add');
    Route::rule('edit', 'index/edit');
    Route::rule('delete', 'index/delete');
});
Route::group('fields', function () {
    Route::rule('request', 'fields/request');
    Route::rule('response', 'fields/response');
    Route::rule('add', 'fields/add');
    Route::rule('edit', 'fields/edit');
    Route::rule('enable', 'fields/enable');
    Route::rule('disable', 'fields/disable');
    Route::rule('delete', 'fields/delete');
});