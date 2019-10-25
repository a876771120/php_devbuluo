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
use think\facade\Cache;
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
    protected $model_name='';
    /**
     * 模型
     * @var think\Model
     */
    protected $model;
    /**
     * 页面标题
     * @var string
     */
    protected $page_title='';
    /**
     * 顶部操作按钮
     * @var array
     */
    protected $top_buttons=[];
    /**
     * 右侧操作按钮
     * @var array
     */
    protected $right_buttons=[];
    /**
     * 字段配置
     * @var array
     */
    protected $fields = [];
    /**
     * 搜索配置
     * @var array
     */
    protected $search = [];
    /**
     * 选择框
     * @var boolean
     */
    protected $checkbox = true;
    /**
     * 分组列表
     * @var array
     */
    protected $group_list=[];
    /**
     * 当前选中分组
     * @var string
     */
    protected $group_curr='';
    /**
     * 分组查询的条件
     * @var array
     */
    protected $group_where=[];
    /**
     * 列表显示字段
     * @var array
     */
    protected $columns=[];
    /**
     * 树形表格配置
     * @var array
     */
    protected $tree_table=[];
    /**
     * 数据列表
     * @var array
     */
    protected $lists = [];
    /**
     * 总数据量
     * @var array
     */
    protected $total = [];
    /**
     * 加载模型
     * @param string $name
     * @return \think\Model
     * @author 刘勤 <876771120@qq.com>
     */
    final protected function loadModel($name=''):\think\Model{
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
     * 获取过滤条件
     * @param array $filter 过滤条件信息
     * @param array $param 参数
     * @return array
     * @author 刘勤 <876771120@qq.com>
     */
    final protected function getFilterMap($filter=[],&$param=[]):array{
        $filter = $filter ? $filter :json_decode(input('filterData',''),true);
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
                    $sql .=$this->getFilterMap($item['children'],$param)['sql'];
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
     * 获取排序信息
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
     * 公共首页
     * @return void
     */
    public function index(){
        // 获取当前模型
        $this->model = $this->loadModel();
        // 如果是ajax并且不是pjax
        if($this->request->isAjax() && !$this->request->isPjax()){
            // 如果已经在子页面设置了数据则
            if(!$this->lists){
                // 字段设置
                $query = $this->model->field($this->fields);
                // 过滤条件设置
                $filterMap = $this->getFilterMap();
                if($filterMap['sql']){
                    $query = $query->whereRaw($filterMap['sql'],$filterMap['param']);
                }
                // 排序设置
                $query = $query->order($this->getOrder());
                // 如果设置的是树形表格
                if($this->tree_table){
                    $query = $query->paginate([
                        'type' => 'bootstrap',
                        'var_page' => 'page',
                        'list_rows' => $this->size,
                        'page'=>$this->page
                    ]);
                    $this->lists = $query->toArray();
                    $this->total = $query->getCon();
                }else{
                    $this->lists = $query->select();
                    $this->total = count($this->lists);
                }
            }
            return json(['code'=>1,'msg'=>'获取成功','count'=>$this->total,'data'=>$this->lists]);
        }
        $this->columns = $this->model->getListColumns();
        return Dbuilder::create('table')
                ->setModel($this->model)
                ->setPageTitle($this->page_title)
                ->setTabNav($this->group_list,$this->group_curr)
                ->setSearch($this->search)
                ->addColumns($this->columns)
                ->setTreeTable($this->tree_table)
                ->addTopButtons($this->top_buttons)
                ->addRightButtons($this->right_buttons)
                ->view();
    }
}