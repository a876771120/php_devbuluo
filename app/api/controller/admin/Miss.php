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
namespace app\api\controller\admin;
use app\common\controller\Base;

class Miss extends Base{
    /**
     * 没有路由的情况
     * @return void
     */
    public function index(){
        return view(app()->getBasePath().'/admin/view/public/error.html')->assign([
            
        ]);
    }
}