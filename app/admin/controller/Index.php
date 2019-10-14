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
use app\admin\model\Config as ConfigModel;
/**
 * 控制台控制器
 * @package app\admin\controller
 * @author 刘勤 <876771120@qq.com>
 */
class Index extends Admin{
    // 不限是面包屑导航
    protected $page_breadcrumb = false;
    /**
     * 后台首页显示
     *
     * @return void
     */
    public function index(){
        return view('');
    }
}