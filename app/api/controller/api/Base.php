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
namespace app\api\controller\api;
use app\common\controller\Base as BaseController;
class Base extends BaseController{
    // 初始化
    protected function initialize(){
        $this->init();
    }
    /**
     * 初始化方法
     * @return void
     */
    protected function init(){

    }
}