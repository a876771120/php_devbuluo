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
use app\member\helper\CaptchaClient;
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
        $appId = "f8815ef2e8528d779389878a7d34e136";
        $appSecret = "644904258e9d18ef92d71c3c98285717";
        $client = new CaptchaClient($appId,$appSecret);
        $client->setTimeOut(2);      //设置超时时间，默认2秒
        $response = $client->verifyToken(input('post.captcha_token'));  //token指的是前端传递的值，即验证码验证成功颁发的token
        //确保验证状态是SERVER_SUCCESS，SDK中有容错机制，在网络出现异常的情况会返回通过
        if($response->result && $response->serverStatus=='SERVER_SUCCESS'){
            // 验证码验证码
            return MemberModel::apiLogin($data['username'],$data['password']);
        }else{
            return ['code'=>-1,'msg'=>'验证码验证失败!'];
        }
    }
    /**
     * 注册方法
     *
     * @return void
     */
    public function register(){

    }
}