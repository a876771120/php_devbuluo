<?php

declare(strict_types=1);

namespace app\common\middleware;
use think\App;
use think\Lang;
use app\admin\model\Config as ConfigModel;
use think\facade\View;
use app\Request;

/**
 * 配置初始化
 * @package app\common\middleware
 * @author 刘勤 <876771120@qq.com>
 */
class Config
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
    public function handle(Request $request, \Closure $next)
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
        // 入口文件名称
        $scriptName =pathinfo($request->baseFile(), PATHINFO_FILENAME);
        // 访问的应用
        $app = app('http')->getName();
        // 默认应用的控制器层
        $defualt_layer = ['admin','common','index'];
        // 获取访问信息
        $pathInfo = $request->pathinfo();
        // 如果是后台访问
        if($scriptName=='admin'){
            // 如果没有带应用访问
            if($pathInfo==''){
                header("Location: /admin.php/admin/index/index.".config('route.url_html_suffix'), true, 302);exit();
            }
            // 如果不在默认控制器列表里面
            if(!in_array($app,$defualt_layer)){
                // 设置控制器访问层
                config(['controller_layer'=>'controller\admin'],'route');
                // 设置模板路径
                View::config(['view_path'=>$this->app->getBasePath().$app.'/view/admin/']);
            }else{
                // 设置模板路径
                View::config(['view_path'=>$this->app->getBasePath().$app.'/view/']);
            }
        }else if($scriptName=='index'){
            // 如果是从index.php进入，但是访问的是后台模块
            if($app=='admin'){
                header("Location: /admin.php/admin/index/index.".config('route.url_html_suffix'), true, 302);exit();
            }
            // 如果当前应用是使用默认控制层
            if(!in_array($app,$defualt_layer)){
                // 设置控制器访问层
                config(['controller_layer'=>'controller\home'],'route');
                // 设置模板路径
                View::config(['view_path'=>$this->app->getBasePath().$app.'/view/home/']);
            }else{
                // 设置模板路径
                View::config(['view_path'=>$this->app->getBasePath().$app.'/view/']);
            }
        }
        // 返回
        return $next($request);
    }
}