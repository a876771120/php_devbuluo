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
use app\api\controller\api\Base;

class Publics extends Base{
    /**
     * 获取广告数据
     *
     * @return void
     */
    public function splashAd(){
        return json(['code'=>1,'msg'=>'获取成功','data'=>[]]);
    }
}