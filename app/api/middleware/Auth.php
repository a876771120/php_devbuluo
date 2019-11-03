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

use app\admin\model\App as ApiApp;
use think\App;
use app\Request;
use think\facade\Cache;
use app\api\helper\ReturnCode;
use app\api\model\Index as ApiList;

/**
 * api权限验证
 * @package app\common\middleware
 * @author 刘勤 <876771120@qq.com>
 */
class Auth{
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
        $apiHash = $request->rule()->getRule();
        if($apiHash){
            $cached = Cache::has('ApiInfo:' . $apiHash);
            if ($cached) {
                $apiInfo = Cache::get('ApiInfo:' . $apiHash);
            } else {
                $apiInfo = ApiList::where(['hash' => $apiHash])->find();
                $apiInfo = $apiInfo->toArray();
                Cache::set('ApiInfo:' . $apiHash, $apiInfo);
            }
            $accessToken = $request->header('access-token', '');
            if (!$accessToken) {
                return json([
                    'code' => ReturnCode::AUTH_ERROR,
                    'msg'  => '缺少必要参数access-token',
                    'data' => []
                ])->header($header);
            }
            if ($apiInfo['access_token']==1) {
                $appInfo = $this->simpleCheck($accessToken);
            } else if($apiInfo['access_token']==2) {
                $appInfo = $this->check($accessToken);
            }
            if ($appInfo === false) {
                return json([
                    'code' => ReturnCode::ACCESS_TOKEN_TIMEOUT,
                    'msg'  => 'access-token已过期',
                    'data' => []
                ])->header($header);
            }
            $request->APP_CONF_DETAIL = $appInfo;
            $request->API_CONF_DETAIL = $apiInfo;
        }else{
            return json([
                'code' => ReturnCode::AUTH_ERROR,
                'msg'  => '缺少接口Hash',
                'data' => []
            ])->header($header);
        }
        return $next($request);
    }
    /**
     * 简单检查认证accessToken
     * @param string $accessToken
     * @return void
     */
    protected function check($accessToken=''){
        $appInfo = cache('AccessToken:' . $accessToken);
        if (!$appInfo) {
            return false;
        } else {
            return $appInfo;
        }
    }
    /**
     * 复杂认证
     * @param string $accessToken
     * @return void
     */
    protected function simpleCheck($accessToken=''){
        $appInfo = cache('AccessToken:' . $accessToken);
        if (!$appInfo) {
            $appInfo = ApiApp::where(['app_secret' => $accessToken])->find();
            if (!$appInfo) {
                return false;
            } else {
                $appInfo = $appInfo->toArray();
                cache('AccessToken:' . $accessToken, $appInfo);
            }
        }
        return $appInfo;
    }
}