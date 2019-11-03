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
namespace app\api\validate;

use app\api\helper\ReturnCode;
use think\Validate;
/**
 * @package app\admin\validate
 */
class App extends Validate{
    /**
     * 规则
     * @var array
     */
    protected $rule = [
        'name'  =>  'require|max:50',
        'app_id'=>'unique:ApiApp',
        'app_secret'=>'unique:ApiApp',
    ];
    /**
     * 验证消息
     * @var array
     */
    protected $message=[
        'name.require'      => ['code' => ReturnCode::FIELD_REQUIRE,'field'=>'field','msg' => '应用名称不能为空'],
        'name.max'          => ['code' => ReturnCode::FIELD_MAX,'field'=>'field','msg' => '应用名称最多不能超过50个字符'],
        'app_id.unique'     => ['code' => ReturnCode::FIELD_UNIQUE,'field'=>'field','msg' => '应用已经添加过了'],
        'app_secret.unique' => ['code' => ReturnCode::FIELD_UNIQUE,'field'=>'field','msg' => '应用已经添加过了'],
    ];
} 