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

use app\api\helper\ReturnCode;
use think\App;
use app\Request;
/**
 * api权限验证
 * @package app\common\middleware
 * @author 刘勤 <876771120@qq.com>
 */
class Permission{
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
        $header = config('api.CROSS');
        $appInfo = $request->APP_CONF_DETAIL;
        $apiInfo = $request->API_CONF_DETAIL;
        $allRules = json_decode($appInfo['app_api'],true);
        if (!in_array($apiInfo['hash'], $allRules)) {
            return json([
                'code' => ReturnCode::INVALID,
                'msg'  => '您当前的应用没有该权限，可联系管理员添加',
                'data' => []
            ])->header($header);
        }
        return $next($request);
    }
}