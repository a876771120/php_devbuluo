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

use think\Model;
use app\common\helper\PhpTree;
use app\admin\model\Menu as MenuModel;
use app\member\model\Role as RoleModel;
/**
 * 角色模型
 * @package app\member\model
 * @author 刘勤 <876771120@qq.com>
 */
class Member extends Model{
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
            ->field('a.*,r.name as rname,r.auth,r.status as rstatus,r.id as role_id')
            ->where($where)
            ->find();
        if($data['status']!=1){
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
}