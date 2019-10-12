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
        'username.require' => '{%user.please enter user name}',
        'username.max' => '{%user.username cannot exceed 25 characters at most}',
        'email.email' => '{%user.incorrect mailbox format}',
        'email.unique' => '{%user.the mailbox already exists}',
        'password.require'=>'{%user.please enter your password}',
        'nickname.require'=>'{%user.please enter a nickname}',
        'nickname.unique'=>'{%user.nickname already exists}',
        'captcha.require'=>'{%user.verification code must be filled}',
        'captcha.captcha'=>'{%user.verification code error}'
    ];

    protected $scene = [
        'edit' => ['email', 'phone'],
        'login'=>['username.require','password','captcha'],
        'user_update'=>['nickname'],
    ];
}