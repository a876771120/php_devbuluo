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
use app\member\model\Role as RoleModel;
use app\common\model\Base;
use think\facade\Db;
use think\Exception;
/**
 * 配置模型
 * @package app\admin\model
 * @author 刘勤 <876771120@qq.com>
 */
class Menu extends Base{
    // 设置当前模型名称
    protected $name = 'AdminMenu';
    /**
     * 初始化列设置
     * @return void
     */
    public function initFields(){
        $appoption = $this->getOptionModule();
        $menuOption = $this->getMenuTree(0,'',input('group',key($appoption)));
        $this->fields = [
            'id'=>[
                'title'=>'ID',
                'type'=>'integer',
                'list'=>false,
                'form'=>[
                    'template'=>'hidden'
                ]
            ],
            'app'=>[
                'title'=>'所属应用',
                'list'=>false,
                'form'=>[
                    'template'=>'select',
                    'attr'=>[
                        'linkage-field'=>'pid',
                        'linkage-url'=>url('/admin/ajax/getAppMenu'),
                    ],
                    'options'=>$appoption,
                    'value'=>input('group',key($appoption))
                ]
            ],
            'pid'=>[
                'title'=>'上级菜单',
                'list'=>false,
                'form'=>[
                    'template'=>'select',
                    'options'=>$menuOption,
                    'value'=>input('pid')
                ]
            ],
            'title'=>[
                'title'=>'菜单标题',
            ],
            'url_value'=>[
                'title'=>'菜单地址',
            ],
            'icon'=>[
                'title'=>'图标',
                'list'=>[
                    'template'=>'icon'
                ],
            ],
            'sort'=>[
                'title'=>'排序',
                'list'=>[
                    'template'=>'text.edit',
                    'width'=>80,
                    'align'=>'center'
                ],
                'form'=>[
                    'value'=>100
                ]
            ],
            'state'=>[
                'title'=>'状态',
                'type'=>'integer',
                'list'=>[
                    'template'=>'switch',
                    'options'=>['active-value'=>1,'inactive-value'=>0]
                ],
                'form'=>[
                    'template'=>'switch',
                    'options'=>['active-value'=>1,'inactive-value'=>0],
                    'value'=>1
                ]
            ],
            'create_time'=>[
                'title'=>'创建时间',
                'list'=>[
                    'width'=>180,
                    'align'=>'center'
                ],
                'form'=>false
            ],
            'update_time'=>[
                'title'=>'修改时间',
                'list'=>[
                    'width'=>180,
                    'align'=>'center'
                ],
                'form'=>false
            ]
        ];
    }
    /**
     * 获取所属模块选项
     * @author 刘勤 <876771120@qq.com>
     * @return array
     */
    public function getOptionModule(){
        $data = Db::name('AdminApp')->column('title','name');
        return $data;
    }
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
            if (config('app.develop_mode') == 0) {
                cache($cache_name, $location);
            }
        }
        return $location;
    }
    /**
     * 获取顶部菜单
     * @author 刘勤 <876771120@qq.com>
     * @return array
     */
    public static function getAllMenuByRole():array{
        $cache_name = 'all_menu_by_role_'.session('member_auth.role_id');
        $menus = cache($cache_name);
        if(!$menus){
            // 非开发模式，只显示可以显示的菜单
            if (config('app.develop_mode') == 0) {
                $map['online_hide'] = 0;
            }
            $map['state'] = 1;
            $menus     = self::where($map)->order('sort,id')->column('id,pid,app,title,url_value,url_target,icon,url_params','id');
            // 检验权限
            foreach ($menus as $key => &$menu) {
                // 没有访问权限的节点不显示
                if (!RoleModel::checkAuth($menu['id'])) {
                    unset($menus[$key]);
                    continue;
                }
                if ($menu['url_value'] != '') {
                    $menu['url_value'] = strtolower((string)url($menu['url_value'],json_decode($menu['url_params'],true)??[]));
                }
            }
            $menus = PhpTree::toLayer($menus, 0, 3);
            // 非开发模式，缓存菜单
            if (config('app.develop_mode') == 0) {
                cache($cache_name, $menus);
            }
        }
        return $menus;
    }
    /**
     * 获取菜单根据url，如果url为空则根据当前访问的url
     * @param string $url 要获取菜单信息的url，如：admin/member/index
     * @param bool $check
     * @author 刘勤 <876771120@qq.com>
     * @return array
     */
    public static function getMenuByUrl($url='',$check=false){
        // 获取当前应用
        $app      = app('http')->getName();
        // 获取当前控制器
        $controller = request()->controller();
        // 获取当前方法
        $action     = request()->action();
        if($url!=''){
            $cache_name = 'menu_'.$url;
        }else{
            $cache_name = 'menu_'.$app.'_'.$controller.'_'.$action;
        }
        $menu = cache($cache_name);
        if(!$menu){
            $map = [
                ['pid', '<>', 0],
                ['url_value', '=', $url??strtolower($app.'/'.trim(preg_replace("/[A-Z]/", "_\\0", $controller), "_").'/'.$action)]
            ];
            $menu = self::where($map)->find();
            // 如果需要检查
            if($check && empty($menu)){
                throw new Exception('没有获取到相关菜单节点', 9002);
            }
            // 非开发模式，缓存菜单
            if (config('app.develop_mode') == 0) {
                cache($cache_name, $menu);
            }
        }
        return $menu;
    }

    /**
     * 获取树形节点
     * @param int $id 需要隐藏的节点id
     * @param string $default 默认第一个节点项，默认为“顶级节点”，如果为false则不显示，也可传入其他名称
     * @param string $app 所属应用
     * @author 刘勤 <876771120@qq.com>
     * @return mixed
     */
    public static function getMenuTree($id = 0, $default = '', $app = ''){
        $result[0] = '顶级节点';
        $where = [
            ['state', '>=', 0]
        ];
        if ($app != '') {
            $where[] = ['app', '=', $app];
        }
        // 排除指定节点及其子节点
        if ($id !== 0) {
            $hide_ids = array_merge([$id], self::getChildsId($id));
            $where[]  = ['id', 'not in', $hide_ids];
        }
        // 获取节点
        $menus = PhpTree::toList(Db::name('AdminMenu')->where($where)->order('pid,id')->column('id,pid,title','id'));
        foreach ($menus as $menu) {
            $result[$menu['id']] = $menu['title_display'];
        }
        // 设置默认节点项标题
        if ($default != '') {
            $result[0] = $default;
        }

        // 隐藏默认节点项
        if ($default === false) {
            unset($result[0]);
        }

        return $result;
    }

    /**
     * 获取所有子节点id
     * @param int $pid 父级id
     * @return array
     * @author 刘勤 <876771120@qq.com>
     */
    public static function getChildsId($pid = 0){
        $ids = self::where('pid', $pid)->column('id');
        foreach ($ids as $value) {
            $ids = array_merge($ids, self::getChildsId($value));
        }
        return $ids;
    }
}