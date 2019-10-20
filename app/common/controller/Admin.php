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
namespace app\common\controller;
use think\facade\Db;
use think\facade\App;
use think\facade\Request;
use think\Response;
use think\facade\View;
use app\common\controller\Base;
use think\exception\HttpResponseException;
use app\member\model\Role as RoleModel;
use app\admin\model\Menu as MenuModel;
/**
 * 后台公共类
 * @author 刘勤 <876771120@qq.com>
 */
class Admin extends Base{
    // 是否显示面包屑导航
    protected $page_breadcrumb=true;
    /**
     * 初始化
     * @author 刘勤 <876771120@qq.com>
     */
    protected function initialize(){
        // 设置后台layout模板
        View::engine()->assign(['_admin_base_layout'=>config('app.admin_layout_path')]);
        // 传递pop参数
        $this->assign('_pop',$this->request->get('_pop'));
        // 是否显示面包屑导航
        $this->assign('_page_breadcrumb',$this->page_breadcrumb);
        // 判断是否登录，并定义用户ID常量
        defined('UID') or define('UID', $this->isLogin());
        // 检查权限
        if (!RoleModel::checkAuth()) $this->error('权限不足！');
        // 如果不是弹窗形式展现
        if(!$this->request->get('_pop')){
            // 如果当前不是ajax访问
            if(!$this->request->isAjax()){
                // 获取所有的菜单
                $this->assign('_role_all_menu',MenuModel::getAllMenuByRole());
            }
            // 面包屑导航在pjax的时候也需要
            if(!$this->request->isAjax()  || $this->request->isPjax()){
                // 获取面包屑导航
                $this->assign('_location', MenuModel::getLocation());
            }
        }
        $this->init();
    }
    /**
     * 初始化方法
     *
     * @return void
     */
    protected function init(){

    }

    /**
     * 构建查询条件
     * @author 刘勤 <876771120@qq.com>
     * @return array
     */
    protected function buildMap($where=[]){
        $where = $where ? $where : input('where',[]);
        $sql = '';
        foreach ($where as $key => $item) {
            if($item['mode']=='group'){
                $sql .= ' '.$item['prefix'].' (';
                $sql .=$this->buildMap($item['children']);
                $sql .= ')';
            }else{
                switch ($item['type']) {
                    case 'eq':
                        $sql .= ($sql? ' '.$item['prefix'].' ':'').$item['field'].' = "'.$item['value'].'"';
                        break;
                    case 'neq':
                        $sql .= ($sql? ' '.$item['prefix'].' ':'').$item['field'].' <> "'.$item['value'].'"';
                        break;
                    case 'gt':
                        $sql .= ($sql? ' '.$item['prefix'].' ':'').$item['field'].' > '.$item['value'];
                        break;
                    case 'gte':
                        $sql .= ($sql? ' '.$item['prefix'].' ':'').$item['field'].' >= '.$item['value'];
                        break;
                    case 'lt':
                        $sql .= ($sql? ' '.$item['prefix'].' ':'').$item['field'].' < '.$item['value'];
                        break;
                    case 'lte':
                        $sql .= ($sql? ' '.$item['prefix'].' ':'').$item['field'].' <= '.$item['value'];
                        break;
                    case 'contain':
                        $sql .= ($sql? ' '.$item['prefix'].' ':'').$item['field'].' LIKE "%'.$item['value'].'%"';
                        break;
                    case 'notContain':
                        $sql .= ($sql? ' '.$item['prefix'].' ':'').$item['field'].' NOT LIKE "%'.$item['value'].'%"';
                        break;
                    case 'between':
                        $sql .= ($sql? ' '.$item['prefix'].' ':'').$item['field'].' BETWEEN '.explode(',',$item['value'])[0].' AND '.explode(',',$item['value'])[1];
                        break;
                    default:
                        # code...
                        break;
                }
            }
        }
        return $sql?$sql:[];
    }
    /**
     * 构建排序方式
     * @author 刘勤 <876771120@qq.com>
     * @return string
     */
    protected function buildOrder($order=[]){
        $order = !empty($order['field']) ? $order : input('sort',[]);
        if(!empty($order['field'])){
            $order = ($this->model->alias && count(explode('.',$order['field']))<=1)?($this->model->alias.'.'.$order['field']):$order['field'].(!empty($order['sort'])?' '.$order['sort']:'');
        }else{
            $order = [];
        }
        return $order;
    }
    /**
     * 检查是否已经登录，没有登录则跳转到登录页面
     * @author 刘勤 <876771120@qq.com>
     * @return void
     */
    final protected function isLogin(){
        //如果是没有登录则跳转到登录
        $login_user = session('member_auth');
        if($login_user){
           return $login_user['id'];
        }else{
            $this->redirect(url('member/publics/login'));
        }
    }
    
    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param  mixed     $msg 提示信息
     * @param  string    $url 跳转的URL地址
     * @param  mixed     $data 返回的数据
     * @param  integer   $wait 跳转等待时间
     * @param  array     $header 发送的Header信息
     * @return void
     */
    protected function error($msg = '', string $url = null, $data = '', int $wait = 3, array $header = []){
        if (is_null($url)) {
            $url = $this->request->isAjax() ? '' : 'javascript:history.back(-1);';
        } elseif ($url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : $this->app->route->buildUrl($url);
        }
        $template = config('app.admin_error_template');
        if(request()->isPjax()){
            $response = Response::create($template,'view')->assign([
                'msg'=>$msg,
                'url'=>$url,
                'wait'=>$wait
            ]);
        }else if(request()->isAjax()){
            $response = json([
                'code'=>-1,
                'msg'=>$msg,
                'url'=>$url,
                'wait'=>$wait,
                'data'=>$data
            ]);
        }else{
            $response = Response::create($template,'view')->assign([
                'msg'=>$msg,
                'url'=>$url,
                'wait'=>$wait
            ]);
        }
        throw new HttpResponseException($response);
    }
    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param  mixed     $msg 提示信息
     * @param  string    $url 跳转的URL地址
     * @param  mixed     $data 返回的数据
     * @param  integer   $wait 跳转等待时间
     * @param  array     $header 发送的Header信息
     * @return void
     */
    protected function success($msg = '', string $url = null, $data = '', int $wait = 3, array $header = []){
        if (is_null($url)) {
            $url = $this->request->isAjax() ? '' : 'javascript:history.back(-1);';
        } elseif ($url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : $this->app->route->buildUrl($url);
        }
        $template = config('app.admin_success_template');
        if(request()->isPjax()){
            $response = Response::create($template,'view')->assign([
                'msg'=>$msg,
                'url'=>$url,
                'wait'=>$wait
            ]);
        }else if(request()->isAjax()){
            $response = json([
                'code'=>-1,
                'msg'=>$msg,
                'url'=>$url,
                'wait'=>$wait,
                'data'=>$data
            ]);
        }else{
            $response = Response::create($template,'view')->assign([
                'msg'=>$msg,
                'url'=>$url,
                'wait'=>$wait
            ]);
        }
        throw new HttpResponseException($response);
    }

    /**
     * 渲染视图
     * @param string $template  自定义显示模板
     * @param array $vars   额外变量
     * @param array $config 配置信息
     * @author 刘勤 <876771120@qq.com>
     * @return mixed
     */
    public function view($template = '', $vars = []){
        // 变量合并
        if (!empty($vars)) {
            $this->_vars = array_merge($this->_vars, $vars);
        }
        $response = Response::create($template,'view')->assign($this->_vars);

        throw new HttpResponseException($response);
    }
}