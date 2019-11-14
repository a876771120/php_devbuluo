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
namespace app\api\controller\home;
use app\common\controller\Base;

class Miss extends Base{
    /**
     * 没有路由的情况
     * @return void
     */
    public function index(){
        $header = config('api.CROSS');
        // 如果是检验服务器性能请求
        if(request()->isOptions()){
            return json(['code'=>1,'msg'=>'请求到了哦','data'=>[

                ]])->header($header);
        }
        return view(app()->getBasePath().'/admin/view/public/error.html')->assign([
            
        ]);
    }
}