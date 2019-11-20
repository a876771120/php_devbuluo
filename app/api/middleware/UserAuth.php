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
declare(strict_types=1);
namespace app\api\middleware;
use think\App;
use app\api\model\Index as ApiList;
use app\api\helper\ReturnCode;
use app\Request;
/**
 * api权限验证
 * @package app\common\middleware
 * @author 刘勤 <876771120@qq.com>
 */
class UserAuth{
    /**
     * 应用实例
     * @var App
     */
    protected $app;
    /**
     * 初始化
     * @param \think\App $app
     * @author 刘勤 <876771120@qq.com>
     */
    public function __construct(App $app){
        $this->app = $app;
    }
    /**
     * 处理请求
     *
     * @param Request $request
     * @param \Closure $next
     * @return Response
     */
    public function handle(Request $request, \Closure $next){
        // 用户检验
        $userToken = $request->header('x-auth-user-token');
        $authInfo = cache($userToken);
        if(!$userToken || !$authInfo){
            return ['code'=>ReturnCode::USER_TOKEN_TIMEOUT,'msg'=>'用户登录状态失效'];
        }
        return $next($request);
    }
}