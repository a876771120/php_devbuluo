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
use think\facade\View;
use app\common\controller\Base;
/**
 * 后台公共类
 * @author 刘勤 <876771120@qq.com>
 */
class Admin extends Base{
    // 当前模型对象
    protected $model;
    // 当前的模型名称
    protected $model_name;
    // 当前页面的标题
    protected $page_title;
    /**
     * 初始化
     * @author 刘勤 <876771120@qq.com>
     */
    protected function initialize(){
        // 设置后台layout模板
        View::assign('_admin_layout',app()->getBasePath().'/admin/view/layout.html');
        // 传递pop参数
        View::assign('_pop',input('_pop'));
        // 输出页面标题
        View::assign('_page_title',$this->page_title);
        // 检查是否登录
        // $this->CheckLogin();
        
    }
    /**
     * 加载模型
     * @author 刘勤 <876771120@qq.com>
     * @return void
     */
    protected function loadModel(){
        if($name==$this->model_name && is_object($this->model)){
            return $this->model;
        }else{
            if(file_exists(App::getAppPath().'model/'.$name.'.php')){
                return App::factory(App::parseClass('model',$name));
            }else{
                return Db::name($name);
            }
        }
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
    final protected function CheckLogin(){
        //如果是没有登录则跳转到登录
        $login_user = session('admin.loginuser');
        if($login_user){
           return $login_user;
        }else{
            return redirect('member/publics/login');
        }
    }

}