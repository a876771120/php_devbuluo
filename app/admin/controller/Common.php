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
namespace app\admin\controller;

use app\common\controller\Admin;
use app\common\builder\Dbuilder;
use think\Exception;
use think\facade\App;
/**
 * 公共控制器
 * @package app\admin\controller
 * @author 刘勤 <876771120@qq.com>
 */
class Common extends Admin{
    /**
     * table页面顶部按钮配置
     * @var array
     */
    protected $top_menu=[];
    /**
     * 当前模型
     * @var \think\Model
     */
    protected $model;
    /**
     * 模型名
     * @var string
     */
    protected $model_name;
    /**
     * 获取当前模型
     * @param string $name  模型名称，如设置config，则获取在当前应用下找到model\config
     * @return $this->model;
     */
    final protected function loadModel($name=''){
        // 如果为空则获取控制器名为模型名称
        if(!$name) $name = request()->controller();
        // 如果已经实例化则直接返回
        if($name==$this->model_name && is_object($this->model)){
            return $this->model;
        }else{
            // 实例化模型返回
            $this->model_name = $name;
            if(file_exists(App::getAppPath().'model/'.$name.'.php')){
                return App::factory(App::parseClass('model',$name));
            }else{
                throw new Exception("没有获取到模型类：".App::parseClass('model',$name), 9003);
            }
        }
    }
    /**
     * 获取查询条件方法
     * @author 刘勤 <876771120@qq.com>
     * @param array $where  查询条件
     * @return array
     */
    final protected function getWhere($where=[]){
        $where = $where ? $where : input('where',[]);
        $sql = '';
        foreach ($where as $key => $item) {
            if($item['mode']=='group'){
                if(!empty($item['children'])){
                    $sql .= ' '.$item['prefix'].' (';
                    $sql .=$this->getWhere($item['children']);
                    $sql .= ')';
                }
            }else{
                // 处理类型
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
     * 获取order查询条件
     * @author 刘勤 <876771120@qq.com>
     * @return string
     */
    final protected function getOrder(){
        $order_array = input('sort');
        $res = [];
        if(isset($order_array['field'])){
            $res[$order_array['field']] = isset($order_array['sort']) ? $order_array['sort'] : 'desc';
        }
        return $res;
    }
}