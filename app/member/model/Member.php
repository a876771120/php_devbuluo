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
namespace app\member\model;
use app\member\model\Role as RoleModel;
use app\common\model\Base;
/**
 * 角色模型
 * @package app\member\model
 * @author 刘勤 <876771120@qq.com>
 */
class Member extends Base{
    // 设置当前模型名称
    protected $name = 'CommonMember';
    // 主键
    protected $pk = 'id';
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    /**
     * 后台的登录方法并且设置用户信息与权限信息
     *
     * @param string $username 用户名
     * @param string $password 密码
     * @param boolean $remember_me 记住我
     * @author 刘勤 <876771120@qq.com>
     * @return bool
     */
    public static function adminLogin($username='',$password=''){
        $where[] = ['username|email|mobile','=',$username];
        $data = self::alias('a')
            ->join('admin_perm p','a.id=p.uid')
            ->join('admin_role r','p.role_id=r.id')
            ->field('a.*,r.name as rname,r.auth,r.state as rstate,r.id as role_id')
            ->where($where)
            ->find();
        if($data['state']!=1){
            return '账号被禁用';
        }
        if($data['password']!=md5(md5($password).$data['salt'].$data['jointime'])){
            return '账号或者密码错误';
        }
        // 设置用户信息
        session('member_auth',$data->getData());
        // 获取当前用户的权限
        $auth = RoleModel::getCurrenAuth();
        // 设置当前用户角色的权限
        session('role_menu_auth',$auth);
        return true;
    }
    /**
     * api登录方法
     * @param string $username 用户名
     * @param string $password 密码
     * @param string $device_id 设备编号
     * @param boolean $remember_me 记住我
     * @return void
     */
    public static function apiLogin($username='',$password='',$device_id='',$rememberme=false){
        $where[] = ['username|email|mobile','=',$username];
        $user = self::alias('member')->where($where)->find();
        if($user['state']!=1){
            return ['code'=>-1,'msg'=>'账号被禁用'];
        }
        if($user['password']!=md5(md5($password).$user['salt'].$user['jointime'])){
            return ['code'=>-1,'msg'=>'账号或者密码错误'];
        }else{
            $uid = $user['id'];
            // 更新登录信息
            $user['last_login_time'] = request()->time();
            $user['last_login_ip']   = get_client_ip(1);
            if ($user->save()) {
                // 保存用户信息在缓存
                return self::autoLogin(self::find($uid)->getData(),$device_id,$rememberme);
            } else {
                // 更新登录信息失败
                return ['code'=>-1,'msg'=>'登录时发生错误,请重新登录'];
            }
        }
    }
    /**
     * 自动检测并登录
     * @param array $user 用户信息
     * @param string $device_id 设备编号，web端是客户传递的时间戳
     * @param boolean $rememberme
     * @return void
     */
    protected function autoLogin($user=[],$device_id='',$rememberme=false){
        // 记录到cache
        $uid = uniqid().$user['id'];
        $auth = array(
            'uid'             => $user['id'],
            'avatar'          => $user['avatar'],
            'device_id'       => $device_id,
            'mobile'          => $user['mobile'],
            'nickname'        => $user['nickname'],
            'last_login_time' => $user['last_login_time'],
            'last_login_ip'   => get_client_ip(1),
        );
        $signin_token = data_build_token($user['device_id'].$user['id'].$user['last_login_time']);
        // 默认2小时过期
        $cache_time = 2*3600;
        // 记住登录
        if ($rememberme) {
            $cache_time = 7*24*3600;
        }
        $auth_sign = base64_encode(json([
            'clientId'=>$device_id,
            'token'=>$signin_token,
            'user_id'=>$uid
        ]));
        cache($uid.'_'.$device_id,$auth,$cache_time);
        cookie('auth',$auth_sign);
        return ['code'=>1,'msg'=>'登录成功'];
    }
}