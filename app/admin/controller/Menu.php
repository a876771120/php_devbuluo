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
     * 不显示选择框
     * @var boolean
     */
    protected $checkbox = false;
    /**
     * 是否是树形table
     * @var array
     */
    protected $tree_table =[
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
        // 设置顶部按钮
        $this->top_buttons = [
            'add'=>[
                'param'=>[
                    'group'=>$this->group_curr
                ]
            ],
        ];
        $this->right_buttons = [
            'add'=>[
                'title'=>'新增子菜单',
                'jump'=>'',
                'jump-mode'=>'_pop',
                'href'=>urldecode((string)url('add',['group'=>$this->group_curr,'pid'=>'{{$thistablepk}}']))
            ],
            'edit',
            'enable',
            'disable',
            'delete'
        ];
        return call_user_func(array('parent', __FUNCTION__));
    }
    /**
     * 添加
     * @return void
     */
    public function add(){
        if($this->request->isPost()){
            $this->group_curr = input('app');
            return call_user_func(array('parent', __FUNCTION__));
        }
        return call_user_func(array('parent', __FUNCTION__));
    }
    /**
     * 修改
     * @param integer $id
     * @return void
     */
    public function edit($id = 0){
        if($this->request->isPost()){
            $this->group_curr = input('app');
            return call_user_func(array('parent', __FUNCTION__),$id);
        }
        return call_user_func(array('parent', __FUNCTION__),$id);
    }
}