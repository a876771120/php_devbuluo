<?php

declare(strict_types=1);

namespace app\common\middleware;
use think\App;
use think\Lang;
use app\admin\model\Config as ConfigModel;
/**
 * 配置初始化
 * @package app\common\middleware
 * @author 刘勤 <876771120@qq.com>
 */
class LoadConfig
{
    protected $app;

    protected $lang;

    public function __construct(App $app, Lang $lang)
    {
        $this->app  = $app;
        $this->lang = $lang;
    }
    /**
     * 处理请求
     *
     * @param Request $request
     * @param \Closure $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        // 读取系统配置
        $system_config = cache('system_config');
        if(!$system_config){
            $system_config = ConfigModel::getConfig();
            // 非开发模式，缓存系统配置
            if (intval(config('app.develop_mode')) === 0) {
                cache('system_config', $system_config);
            }
        }
        // 设置配置信息
        config($system_config,'app');
        // 返回
        return $next($request);
    }
}