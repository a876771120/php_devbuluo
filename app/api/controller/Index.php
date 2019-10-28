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
namespace app\api\controller;

use app\common\builder\Dbuilder;
use app\admin\controller\Common;
/**
 * 配置管理控制器
 * @package app\api\controller
 * @author 刘勤 <876771120@qq.com>
 */
class Index extends Common{
    /**
     * 是否显示多选
     * @var boolean
     */
    protected $checkbox=false;
    /**
     * 后台api首页
     * @return void
     * @author 刘勤 <876771120@qq.com>
     */
    public function index(){
        if($this->request->isPost()){
            return call_user_func(array('parent', __FUNCTION__));          
        }
        $this->top_buttons=[
            'add',
            'route'=>[
                'title'         => '刷新路由',
                'class'         => 'dui-button dui-button--warning confirm',
                'jump'          => '',
                'href'          => (string)url('refresh'),
                'jump-mode'     => '_ajax',
            ],
            'delete'
        ];
        $this->right_buttons=[
            'edit',
            'request'=>[
                'title'         => '请求参数',
                'class'         => 'dui-button dui-button--mini dui-button--success',
                'jump'          => '',
                'href'          => urldecode((string)url('api/field/request',['hash'=>"{{hash}}"])),
                'jump-mode'     => '_pjax',
            ],
            'response'=>[
                'title'         => '返回参数',
                'class'         => 'dui-button dui-button--mini dui-button--warning',
                'jump'          => '',
                'href'          => urldecode((string)url('api/field/response',['hash'=>"{{hash}}"])),
                'jump-mode'     => '_pjax',
            ],
            'delete'
        ];
        return call_user_func(array('parent', __FUNCTION__));
    }
    /**
     * 刷新路由操作
     * @return void
     * @author 刘勤 <876771120@qq.com>
     */
    public function refresh(){
        
    }
}