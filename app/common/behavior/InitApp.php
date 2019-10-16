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
namespace app\common\behavior;
use app\admin\model\Config as ConfigModel;
use think\facade\Request;
use think\facade\View;
use think\facade\App;
class initApp{
    public function handle(){
        // 获取当前访问的文件
        $base_file  = Request::baseFile();
        // 配置使用默认的app
        $defualt_layer = ['admin','common','index'];
        // 获取当前访问的应用，控制器，方法
        $path_array = explode('/',Request::pathinfo());
        // 当前访问的应用
        $app = !empty($path_array[0])?$path_array[0]:config('app.default_app');
        // 当前访问的控制器
        $controller = !empty($path_array[1])?$path_array[1]:config('route.default_controller');
        // 当前访问的方法
        $action = !empty($path_array[2])?$path_array[2]:config('route.default_action');
        // dump($path_array);die;
        // 如果是后台入口进入
        if($base_file=="/admin.php"){
            if($path_array[0]==''){
                header("Location: /admin.php/admin/index/index.".config('route.url_html_suffix'), true, 302);exit();
            }
            // 如果当前应用是使用默认控制层
            if(!in_array($app,$defualt_layer)){
                // 设置控制器访问层
                config(['controller_layer'=>'controller\admin'],'route');
                // 设置模板路径
                View::config(['view_path'=>App::getBasePath().$app.'/view/admin/']);
            }else{
                // 设置模板路径
                View::config(['view_path'=>App::getBasePath().$app.'/view/']);
            }
        }else{
            // 如果是从index.pgp进入，但是访问的是后台模块
            if($app=='admin'){
                header("Location: /admin.php/admin/index/index.".config('route.url_html_suffix'), true, 302);exit();
            }
            // 如果当前应用是使用默认控制层
            if(!in_array($app,$defualt_layer)){
                // 设置控制器访问层
                config(['controller_layer'=>'controller\home'],'route');
                // 设置模板路径
                View::config(['view_path'=>App::getBasePath().$app.'/view/home/']);
            }else{
                // 设置模板路径
                View::config(['view_path'=>App::getBasePath().$app.'/view/']);
            }
        }
    }
}