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
namespace app\member\controller\admin;
use app\common\controller\Base;
use app\member\model\Member as MemberModel;
use think\exception\ValidateException;
/**
 * 用户其他不需要权限的控制器
 */
class Publics extends Base{
    /**
     * 登录方法
     *
     * @return void
     */
    public function login(){
        // 如果是登录操作
        if(request()->isAjax() && request()->isPost()){
            $data = input('');
            try {
                $this->validate($data,'Member.login');
                // 用户登录
                $res = MemberModel::adminLogin(input('username'),input('password'));
                if($res!==true){
                    $data = ['code'=>-1,'msg'=>$res,'data'=>''];
                }else{
                    // 登录成功设置语言
                    $data = ['code'=>1,'msg'=>'登录成功','data'=>''];
                }
            } catch (ValidateException $e) {
                $data = ['code'=>-1,'msg'=>$e->getError(),'data'=>''];
            }
            return json($data);
        }
        // 输出当前使用的语言
        return view();
    }
}