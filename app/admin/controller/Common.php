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
     * 模型名
     * @var string
     */
    protected $model_name;
    /**
     * 当前模型
     * @var \think\Model
     */
    protected $model;
    /**
     * table页面顶部按钮配置
     * @var array
     */
    protected $top_buttons=[];
    /**
     * table右侧操作按钮配置
     * @var array
     */
    protected $right_buttons=[];
    /**
     * 请求地址
     * @var string
     */
    protected $ajax_url;
    /**
     * 页面标题
     * @var string
     */
    protected $page_title;
    /**
     * 分组查询的条件
     * @var array
     */
    protected $group_where;
    /**
     * 分组信息配置
     * @var array
     */
    protected $group_info;
    /**
     * 当前选中的分组
     * @var string
     */
    protected $group_curr;
    /**
     * 顶部搜索信息
     * @var string||array
     */
    protected $search_info;
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
     * 获取高级查询条件，根据前对dui传入参数解析
     * @return string
     */
    final protected function getFilter($filterList=[],&$param=[]){
        $filter = $filterList ? $filterList :json_decode(input('filterData',''),true);
        $sql = '';
        if($filter){
            foreach ($filter as $i => $item) {
                // 过滤连接符
                if(!empty($item['prefix']) && $item['prefix']=='and'){
                    $item['prefix']='and';
                }else{
                    $item['prefix']='or';
                }
                if(!empty($item['mod']) && $item['mod']=='group'){
                    $sql .= ' '.$item['prefix'].' (';
                    $sql .=$this->getFilter($item['children'],$param)['sql'];
                    $sql .= ')';
                }else{
                    // 处理处理value
                    // 处理between，这种是2个值
                    if($item['condition']=='between'){
                        $item['value'] = explode(',',$item['value']);
                    }
                    if($item['type']=='integer'){
                        $item['value'] = intval($item['value']);
                    }else if($item['type']=='float'){
                        $item['value'] = floatval($item['value']);
                    }else if($item['type']=='timestamp'){
                        if($item['condition']=='between'){
                            $item['value'] = [strtotime($item['value'][0]||0),strtotime($item['value'][1]||0)];
                        }else{
                            $item['value'] = strtotime($item['value']||0);
                        }
                    }else{
                        $item['value'] = strval($item['value']);
                    }
                    
                    // 根据条件组装sql
                    switch ($item['condition']) {
                        case 'eq':
                            $param[] = $item['value'];
                            $sql .= ($sql? ' '.$item['prefix']:'').' `'.$item['field'].'` = ?';
                            break;
                        case 'neq':
                            $param[] = $item['value'];
                            $sql .= ($sql? ' '.$item['prefix'].' ':'').' `'.$item['field'].'` != ?';
                            break;
                        case 'gt':
                            $param[] = $item['value'];
                            $sql .= ($sql? ' '.$item['prefix'].' ':'').' `'.$item['field'].'` > ?';
                            break;
                        case 'gte':
                            $param[] = $item['value'];
                            $sql .= ($sql? ' '.$item['prefix'].' ':'').' `'.$item['field'].'` >= ?';
                            break;
                        case 'lt':
                            $param[] = $item['value'];
                            $sql .= ($sql? ' '.$item['prefix'].' ':'').' `'.$item['field'].'` < ?';
                            break;
                        case 'lte':
                            $param[] = $item['value'];
                            $sql .= ($sql? ' '.$item['prefix'].' ':'').' `'.$item['field'].'` <= ?';
                            break;
                        case 'contain':
                            $param[] = '%'.$item['value'].'%';
                            $sql .= ($sql? ' '.$item['prefix'].' ':'').' `'.$item['field'].'` LIKE ?';
                            break;
                        case 'notContain':
                            $param[] = '%'.$item['value'].'%';
                            $sql .= ($sql? ' '.$item['prefix'].' ':'').' `'.$item['field'].'` NOT LIKE ?';
                            break;
                        case 'between':
                            $param[] = $item['value'][0];
                            $param[] = $item['value'][1];
                            $sql .= ($sql? ' '.$item['prefix'].' ':'').' `'.$item['field'].'` BETWEEN ? AND ?';
                            break;
                    }
                }
            }
        }
        return ['sql'=>$sql,'param'=>$param];
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
    /**
     * 列表页
     * @return void
     * @author 刘勤 <876771120@qq.com>
     */
    public function index(){
        // 加载模型
        $model = $this->loadModel($this->model_name);
         // 如果是post则表示在请求数据
         if(request()->isAjax() && request()->isPost()){
            // 获取查询字段
            $field = $model->getQueryField();
            // 获取排序信息
            $order = $this->getOrder();
            // 获取高级查询
            $filter = $this->getFilter();
            // 获取queryBuilder
            $listBuilder = $model->buildQuery($field,$order);
            // 如果有分组信息
            if($this->group_where){
                $listBuilder = $listBuilder->where($this->group_where);
            }
            // 如果有高级查询信息
            if($filter['sql']){
                $listBuilder = $listBuilder->where($filter['sql'],$filter['param']);
            }
            // 获取列表数据分页
            $list = $listBuilder->paginate([
                'list_rows'=> input('size',10),
                'page' => input('page',1),
            ]);
            return json(['code'=>1,'msg'=>'获取成功','count'=>$list->total(),'data'=>$list->getCollection()]);
         }
        $url_param = $this->group_curr ? ['group'=>$this->group_curr] : [];
         // 显示列表
         return Dbuilder::create('table')
            ->setPageTitle($this->page_title)
            ->setAjaxInfo(['url'=>$this->ajax_url ? $this->ajax_url: url('index',$url_param)])
            ->setTabNav($this->group_info,$this->group_curr)
            ->setModel($model)
            ->addColumns($model->getTableConfig())
            ->addTopButtons($this->top_buttons)
            ->addRightButtons($this->right_buttons)
            ->setSearch($this->search_info)
            ->view();


    }
}