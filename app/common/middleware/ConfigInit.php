<?php

declare(strict_types=1);

namespace app\common\middleware;
use app\admin\model\Config as ConfigModel;
/**
 * 配置初始化
 * @package app\common\middleware
 * @author 刘勤 <876771120@qq.com>
 */
class ConfigInit
{
    /**
     * 处理请求
     *
     * @param Request $request
     * @param \Closure $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        //
        // 读取系统配置
        $system_config = cache('system_config');
        if(!$system_config){
            $system_config = ConfigModel::getConfig();
            // 非开发模式，缓存系统配置
            if ($system_config['develop_mode'] == 0) {
                cache('system_config', $system_config);
            }
        }
        // 设置配置信息
        config($system_config,'app');
        return $next($request);
    }
}