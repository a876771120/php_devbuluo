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
namespace app\member\controller\api;
use app\member\model\Member as MemberModel;
use think\exception\ValidateException;

/**
 * 用户其他不需要权限的控制器
 */
class Publics{
    /**
     * 登录方法
     *
     * @return void
     */
	public function login(){
        $data = input('post.');
        // 验证码验证码
        MemberModel::apiLogin($data['username'],$data['password'],$data['']);
    	return json(['code'=>1,'msg'=>'登录成功','data'=>input('post.')]);
    }
    /**
     * 注册方法
     *
     * @return void
     */
    public function register(){

    }
}