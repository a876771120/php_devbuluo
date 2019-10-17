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

use app\common\controller\Admin;
use app\common\builder\Dbuilder;
use think\facade\App;
use think\facade\Db;
/**
 * 配置管理控制器
 * @package app\admin\controller
 * @author 刘勤 <876771120@qq.com>
 */
class Config extends Admin{
    
    /**
     * 管理列表页面
     *
     * @return void
     */
    public function index(){
        
        // dump(App::factory(App::parseClass('model','Config'))->db()->getTable());
        // dump(Db::name('AdminConfig'));

        // 如果是post则表示在请求数据
        if(request()->isAjax() && request()->isPost()){

        }
        return Dbuilder::create('table')
        ->setPageTitle('配置管理')
        ->addColumns([
            [
                'field'=>'name',
                'title'=>'配置名称',
            ],
            [
                'field'=>'title',
                'title'=>'配置标题',
            ],
            [
                'field'=>'group',
                'title'=>'分组',
            ],
            [
                'field'=>'type',
                'title'=>'类型',
            ],
            [
                'field'=>'sort',
                'title'=>'排序',
                'template'=>'text.edit'
            ]
        ])
        ->addTopButtons('add,enable,disable,delete')
        ->addSimpleSearch('name')
        ->addSimpleSearch('field')
        ->view();
    }
}