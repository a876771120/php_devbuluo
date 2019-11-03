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
declare(strict_types=1);
namespace app\api\helper;
/**
 * 返回码管理
 */
class ReturnCode{
    const SUCCESS = 1;
    const INVALID = -1;
    const DB_SAVE_ERROR = -2;//数据插入失败
    const DB_READ_ERROR = -3;//数据获取失败
    const CACHE_SAVE_ERROR = -4;//缓存保存失败
    const CACHE_READ_ERROR = -5;//缓存读取失败
    const FILE_SAVE_ERROR = -6;//文件保存失败
    const LOGIN_ERROR = -7;//日志记录失败
    const NOT_EXISTS = -8;//数据不存在
    const JSON_PARSE_FAIL = -9;//json数据解析失败
    const TYPE_ERROR = -10;//类型错误
    const NUMBER_MATCH_ERROR = -11;//数字匹配失败
    const EMPTY_PARAMS = -12;//参数为空
    const DATA_EXISTS = -13;//数据不存在
    const AUTH_ERROR = -14;//权限错误
    const VERSION_INVALID = -15;//版本信息错误
    const CURL_ERROR = -18;//curl错误
    const RECORD_NOT_FOUND = -19; // 记录未找到
    const DELETE_FAILED = -20; // 删除失败
    const ADD_FAILED = -21; // 添加记录失败
    const UPDATE_FAILED = -22; // 修改记录失败
    const FIELD_REQUIRE = -23; //字段不能为空
    const FIELD_MAX = -24; //字段长度超出
    const FIELD_UNIQUE = -25; //字段长度超出
    const PARAM_INVALID = -995; // 参数无效
    const ACCESS_TOKEN_TIMEOUT = -996;
    const SESSION_TIMEOUT = -997;
    const UNKNOWN = -998;
    const EXCEPTION = -999;
}