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
        dump($this->model);die;
    }
}