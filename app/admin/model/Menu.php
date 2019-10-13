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
namespace app\admin\model;

use app\common\helper\PhpTree;
use think\Model;
/**
 * 配置模型
 * @package app\admin\model
 * @author 刘勤 <876771120@qq.com>
 */
class Menu extends Model{
    // 设置当前模型名称
    protected $name = 'AdminMenu';
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
    /**
     * 根据菜单id获取当前访问节点数组，如果没有id则获取当前节点数组
     * @param string $id 当前访问的菜单节点如果没有指定，则取当前节点
     * @param boolean $del_last_url 是否删除最后一个节点的url地址
     * @param boolean $check 检查节点是否存在，不存在则抛出错误
     * @author 刘勤 <876771120@qq.com>
     * @return array
     * @throws \think\Exception
     */
    public static function getLocation($id = '', $del_last_url = false, $check = true){
        // 获取当前应用
        $app      = app('http')->getName();
        // 获取当前控制器
        $controller = request()->controller();
        // 获取当前方法
        $action     = request()->action();
        if ($id != '') {
            $cache_name = 'location_menu_'.$id;
        } else {
            $cache_name = 'location_'.$app.'_'.$controller.'_'.$action;
        }
        $location = cache($cache_name);
        if(!$location){
            $map = [
                ['pid', '<>', 0],
                ['url_value', '=', strtolower($app.'/'.trim(preg_replace("/[A-Z]/", "_\\0", $controller), "_").'/'.$action)]
            ];
            // 当前操作对应的节点ID
            $curr_id = $id == '' ? self::where($map)->value('id') : $id;

            // 获取节点ID是所有父级节点
            $location = PhpTree::getParents(self::column('id,pid,title,url_value,url_params'), $curr_id);
            
            if ($check && empty($location)) {
                throw new Exception('获取不到当前节点地址，可能未添加节点', 9001);
            }
            // 剔除最后一个节点url
            if ($del_last_url) {
                $location[count($location) - 1]['url_value'] = '';
            }

            // 非开发模式，缓存菜单
            if (config('develop_mode') == 0) {
                cache($cache_name, $location);
            }
        }
        return $location;
    }
}