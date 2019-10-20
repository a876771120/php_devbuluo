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
namespace app\member\controller\admin;
use app\admin\controller\Common;
use app\common\builder\table\Builder;

/**
 * 控制台控制器
 * @package app\admin\controller
 * @author 刘勤 <876771120@qq.com>
 */
class Index extends Common{
    /**
     * 后台首页显示
     *
     * @return void
     */
    public function index(){
        $model = $this->loadModel('perm');
       
        return Builder::create('table')
        ->view();
    }
    /**
     * 个人信息
     *
     * @return void
     */
    public function profile(){
        return view('');
    }
}