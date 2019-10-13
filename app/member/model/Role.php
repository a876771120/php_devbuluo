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
/**
 * 角色模型
 * @package app\member\model
 * @author 刘勤 <876771120@qq.com>
 */
class Role extends Model{
    // 设置当前模型名称
    protected $name = 'AdminRole';
    // 主键
    protected $pk = 'id';
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
    /**
     * 获取当前角色的权限
     * @author 刘勤 <876771120@qq.com>
     * @return array
     */
    public static function getCurrenAuth(){
        $menu_auth = cache('role_menu_auth_'.session('member_auth.role_id'));
        if (!$menu_auth) {
            $menu_auth = self::where('id', session('member_auth.role_id'))->value('auth');
            $menu_auth = json_decode($menu_auth, true);
            $menu_auth = MenuModel::where('id', 'in', $menu_auth)->column('url_value','id');
        }
        // 非开发模式，缓存数据
        if (config('develop_mode') == 0) {
            cache('role_menu_auth_'.session('member_auth.role_id'), $menu_auth);
        }
        return $menu_auth;
    }
    /**
     * 检查当前用户是否有该菜单权限
     * @author 刘勤 <876771120@qq.com>
     * @param String|int $mid 当前菜单id或者url
     * @param bool $url 是否是url
     * @return bool
     * @throws \think\Exception
     */
    public static function checkAuth($mid=0,$url = false){
        // 当前用户的角色编号
        $role = session('member_auth.role_id');
        // id为1的是超级管理员，或者角色为1的，拥有最高权限
        if (session('member_auth.uid') == '1' || $role == '1') {
            return true;
        }
        // 获取当前用户的权限
        $menu_auth = session('role_menu_auth');
        // 检查权限
        if ($menu_auth) {
            if ($mid !== 0) {
                return $url === false ? isset($menu_auth[$mid]) : in_array($mid, $menu_auth);
            }
            // 获取当前操作的id
            $location = MenuModel::getLocation();
            // 取最后一个访问地址
            $action   = end($location);
            return $url === false ? isset($menu_auth[$action['id']]) : in_array($action['url_value'], $menu_auth);
        }

        // 其他情况一律没有权限
        return false;
    }
}