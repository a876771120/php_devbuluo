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
use app\common\builder\Dbuilder;

use app\admin\model\Config as ConfigModel;
use think\facade\App;
use think\facade\Db;
/**
 * 配置管理控制器
 * @package app\admin\controller
 * @author 刘勤 <876771120@qq.com>
 */
class Config extends Common{
    
    /**
     * 管理列表页面
     *
     * @return void
     */
    public function index(){
        // 如果是post则表示在请求数据
        if(request()->isAjax() && request()->isPost()){

        }
        $ceshi = $this->loadModel()->find(1);
        return Dbuilder::create('table')
        ->setPageTitle('配置管理')
        ->setModel($this->loadModel())
        ->addColumns([])
        ->addTopButtons('add,enable,disable,delete')
        ->addSimpleSearch('name')
        ->addSimpleSearch('field')
        ->view();
    }
}