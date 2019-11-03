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
use think\Validate;
/**
 * @package app\admin\validate
 */
class Index extends Validate{
    /**
     * 规则
     * @var array
     */
    protected $rule = [
        'name'  =>  'require|max:50',
        'api_class'=>'require',
        'hash'=>'unique:ApiList',
    ];
    /**
     * 验证消息
     * @var array
     */
    protected $message=[
        'name.require'     => ['code' => 1001,'field'=>'field','msg' => '接口名称'],
        'name.max'         => ['code' => 1002,'field'=>'field','msg' => '接口名称最多不能超过50个字符'],
        'api_class.require'     => ['code' => 1003,'field'=>'field','msg' => '接口访问真实类库'],
        'hash.unique'     => ['code' => 1003,'field'=>'field','msg' => '接口地址已经存在'],
    ];
} 