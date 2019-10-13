<?php
// +----------------------------------------------------------------------
// | BaseAdmin [ 基于thinkphp6框架 ]
// +----------------------------------------------------------------------
// | 版权所有 2017~2020 BaseAdmin [ http://www.BaseAdmin.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://www.BaseAdmin.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
namespace app\member\validate;
use think\Validate;
/**
 * 用户验证器
 */
class Member extends Validate
{
    protected $rule = [
        'username' => 'require|max:25|unique:common_member',
        'email' => 'email|unique:common_member',
        'password'=>'require',
        'phone'=> 'require|unique:common_member',
        'nickname'=>'require|unique:common_member',
        'captcha'=>'require|captcha'
    ];

    protected $message = [
        'username.require' => '请输入用户名',
        'username.max' => '用户名最多不能超过25个字符',
        'email.email' => '邮箱格式错误',
        'email.unique' => '邮箱已经存在',
        'password.require'=>'请输入密码',
        'nickname.require'=>'请输入昵称',
        'nickname.unique'=>'昵称已经存在',
        'captcha.require'=>'验证码不能为空',
        'captcha.captcha'=>'验证码错误'
    ];

    protected $scene = [
        'edit' => ['email', 'phone'],
        'login'=>['username.require','password','captcha'],
        'user_update'=>['nickname'],
    ];
}