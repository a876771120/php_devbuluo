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
namespace app\admin\validate;
use think\Validate;
/**
 * @package app\admin\validate
 */
class Config extends Validate{
    /**
     * 规则
     * @var array
     */
    protected $rule = [
        'field'  =>  'require|unique:AdminConfig|max:25',
        'title'=>'require',
        'template'=>'require'
    ];
    /**
     * 验证消息
     * @var array
     */
    protected $message=[
        'field.require'     => ['code' => 1001,'field'=>'field','msg' => '配置名必填'],
        'field.unique'      => ['code' => 1002,'field'=>'field','msg' => '配置名已经存在'],
        'field.max'         => ['code' => 1002,'field'=>'field','msg' => '配置名最多不能超过25个字符'],
        'title.require'     => ['code' => 1003,'field'=>'field','msg' => '标题必填'],
        'template.require'  => ['code' => 1004,'field'=>'field','msg' => '请选择配置的表单模板'],
    ];
    /**
     * 验证场景
     * @var array
     */
    protected $scene = [
        'add'   =>  ['field','title','template'],
        'edit'   =>  ['field','title','template'],
    ];
} 