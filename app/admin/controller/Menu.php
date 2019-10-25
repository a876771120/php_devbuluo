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
namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\App;
use app\common\builder\Dbuilder;
use app\admin\model\Menu as MenuModel;
/**
 * 配置管理控制器
 * @package app\admin\controller
 * @author 刘勤 <876771120@qq.com>
 */
class Menu extends Common{
    /**
     * 顶部按钮配置
     * @var array
     */
    protected $top_buttons=['add','enable','disable','delete'];
    /**
     * 右侧操作按钮
     * @var array
     */
    protected $right_buttons = ['edit','enable','disable','delete'];
    /**
     * 不显示选择框
     * @var boolean
     */
    protected $checkbox = false;
    /**
     * 是否是树形table
     * @var array
     */
    protected $table_tree =[
        'expandColumn'=>"title",//折叠图标显示在哪个列
    ];

    /**
     * 首页
     * @return void
     * @author 刘勤 <876771120@qq.com>
     */
    public function index(){
        // 设置当前选中分组
        $this->group_curr = input('group','admin');
        // 设置分组查询条件
        $this->group_where[] = ['app','=',$this->group_curr];
        //设置分组
        // 获取分组信息
        $groups = App::column('title','name');
        foreach ($groups as $name => $title) {
            $item['title']=$title;
            $item['name'] = $name;
            $item['href'] = strtolower((string)url('index',['group'=>$name]));
            $this->group_list[] = $item;
        }
        return call_user_func(array('parent', __FUNCTION__));
    }
}