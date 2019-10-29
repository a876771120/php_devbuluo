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

use app\common\builder\Dbuilder;
use app\admin\controller\Common;
use think\Exception;
/**
 * 配置管理控制器
 * @package app\api\controller\admin
 * @author 刘勤 <876771120@qq.com>
 */
class Index extends Common{
    /**
     * 右侧按钮
     *
     * @var array
     */
    protected $right_buttons=['edit','enable','disable','delete'];
    /**
     * 是否显示多选
     * @var boolean
     */
    protected $checkbox=false;
    /**
     * 后台api首页
     * @return void
     * @author 刘勤 <876771120@qq.com>
     */
    public function index(){
        if($this->request->isPost()){
            return call_user_func(array('parent', __FUNCTION__));          
        }
        $this->top_buttons=[
            'add'=>[
                'jump-mode'     => '_pjax',
            ],
            'refresh'=>[
                'title'         => '刷新路由',
                'class'         => 'dui-button dui-button--warning confirm',
                'jump'          => '',
                'href'          => (string)url('refresh'),
                'jump-mode'     => '_ajax',
            ],
            'delete'
        ];
        return call_user_func(array('parent', __FUNCTION__));
    }
    /**
     * 添加方法
     * @return void
     */
    public function add(){
        $this->model = $this->loadModel();
        if($this->request->isPost()){

        }
        
        $formItems = array_column($this->model->getFromItems(), null, 'field');
        return view()->assign(['formItems'=>$formItems]);
    }
    /**
     * 刷新路由操作
     * @return void
     * @author 刘勤 <876771120@qq.com>
     */
    public function refresh(){
        // 路由路径
        $tplPath = app()->getBasePath().'api/data/Api.tpl';
        // 路由模板路径
        $apiRoutePath = app()->getRootPath().'route/api/Api.php';
        // 支持的请求方式
        $methodArr = ['*', 'POST', 'GET', 'PUT', 'DELETE', 'HEAD'];
        // 获取模板内容
        $tplStr = file_get_contents($tplPath);
        // 获取所有的接口
        $listInfo = $this->loadModel()->where('state','=',1)->column('api_class,method','hash');
        // 路由字符串
        $routeStr = [];
        // 组装路由字符串
        foreach ($listInfo as $hash=>&$rule) {
            // 解析url
            try {
                list($app,$controller,$action) = explode('/',$rule['api_class']);
            } catch (Exception $th) {
                // 如果报错则表示没有输入应用则使用api应用
                $app = 'api';
                list($controller,$action) = explode('/',$rule['api_class']);
            }
            array_push($routeStr, "Route::rule('".addslashes($hash)."','app\\".$app."\\controller\\interface\\".$controller."@".$action."','".$methodArr[$rule['method']]."')->middleware(['ApiPermission','ApiAuth','ApiRequest','ApiLog']);");
        }
        $routeStr = str_replace('{$API_RULE}',implode(PHP_EOL,$routeStr),$tplStr);
        // 写入路由文件
        file_put_contents($apiRoutePath, $routeStr);
        $this->success('路由刷新成功');
    }
}