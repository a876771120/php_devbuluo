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

use app\admin\model\Log;
use app\admin\model\Menu as MenuModel;
use app\common\controller\Admin;
use app\common\builder\Dbuilder;
use think\Exception;
use think\exception\ValidateException;
use think\facade\App;
use think\facade\Cache;
use think\Model;
use think\Validate;

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
     * @var \think\Model
     */
    protected $model;
    /**
     * 验证器名
     * @var string
     */
    protected $validate_name='';
    /**
     * 验证器
     * @var \think\Validate
     */
    protected $validate;
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
     * 请求信息
     * @var array
     */
    protected $ajax_info=[];
    /**
     * 当前页
     * @var integer
     */
    protected $page = 1;
    /**
     * 每页显示数量
     * @var integer
     */
    protected $size = 10;
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
     */
    final protected function loadModel($name=''):Model{
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
     * 加载验证器
     * @param string $name
     * @return \think\Validate
     */
    final protected function loadValidate($name=''){
        // 如果为空则获取控制器名为模型名称
        if(!$name) $name = request()->controller();
        // 如果已经实例化则直接返回
        if($name==$this->validate_name && is_object($this->validate)){
            return $this->validate;
        }else{
            // 实例化模型返回
            $this->validate_name = $name;
            if(file_exists(App::getAppPath().'validate/'.$name.'.php')){
                return App::factory(App::parseClass('validate',$name));
            }else{
                return null;
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
                            $sql .= ($sql? ' '.$item['prefix'].' ':'').' `'.$item['field'].'` <> ?';
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
     * 获取列表页顶部简单查询
     * @return array
     */
    final protected function getSearchMap():array{
        $where = input('where',[]);
        if($where){
            $where=[[$where['field'],'like','%'.$where['value'].'%']];
        }
        return $where;
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
     * @author 刘勤 <876771120@qq.com>
     */
    public function index(){
        // 获取当前模型
        $this->model = $this->loadModel();
        // 如果是ajax并且不是pjax
        if($this->request->isAjax() && !$this->request->isPjax()){
            // 如果已经在子页面设置了数据则
            if(!$this->lists){
                // 设置当前页
                $this->page = input('page',1);
                // 设置每页显示条数
                $this->size = input('size',10);
                // 字段设置
                $query = $this->model->field($this->fields);
                // 设置分组的查询
                if($this->group_where){
                    $query = $query->where($this->group_where);
                }
                // 过滤条件设置
                $filterMap = $this->getFilterMap();
                if($filterMap['sql']){
                    $query = $query->whereRaw($filterMap['sql'],$filterMap['param']);
                }
                // 获取基础查询
                $where = $this->getSearchMap();
                if($where){
                    $query = $query->where($where);
                }
                // 排序设置
                $query = $query->order($this->getOrder());
                // 如果设置的是树形表格
                if(!$this->tree_table){
                    $query = $query->paginate([
                        'type' => 'bootstrap',
                        'var_page' => 'page',
                        'list_rows' => $this->size,
                        'page'=>$this->page
                    ]);
                    $this->lists = $query->getCollection();
                    $this->total = $query->total();
                }else{
                    $this->lists = $query->select();
                    $this->total = count($this->lists);
                }
            }
            return json(['code'=>1,'msg'=>'获取成功','count'=>$this->total,'data'=>$this->lists]);
        }
        $this->columns = $this->columns ? $this->columns : $this->model->getListColumns();
        return Dbuilder::create('table')
                ->setModel($this->model)
                ->setCheckbox($this->checkbox)
                ->setAjaxInfo($this->ajax_info)
                ->setPageTitle($this->page_title)
                ->setTabNav($this->group_list,$this->group_curr)
                ->setSearch($this->search)
                ->addColumns($this->columns)
                ->setTreeTable($this->tree_table)
                ->addTopButtons($this->top_buttons)
                ->addRightButtons($this->right_buttons)
                ->view();
    }
    /**
     * 添加方法
     * @return void
     */
    public function add(){
        // 加载模型
        $this->model = $this->loadModel();
        if($this->request->isPost()){
            // 加载验证器
            $this->validate = $this->loadValidate();
            // 获取数据
            $data = input('post.');
            // 判断是否有验证器
            if($this->validate){
                try {
                    // 如果有验证场景则使用验证场景
                    if($this->validate->hasScene('add')){
                        validate(get_class($this->validate))->scene('add')->check($data);
                    }else{
                        validate(get_class($this->validate))->check($data);
                    }
                } catch (ValidateException $e) {
                    return json($e->getError());
                }
            }
            $res = $this->model->create($data);
            if($res){
                Cache::clear();
                // 记录行为日志
                $this->writeLog($this->model->getLastSql(),'',1);
                if($this->group_curr){
                    $param['group'] = $this->group_curr;
                }else{
                    $param = [];
                }
                $this->success('操作成功',(string)url('index').'?'.http_build_query($param));
            }else{
                // 记录行为日志
                $this->writeLog($this->model->getLastSql());
                $this->error('操作失败');
            }
        }
        return Dbuilder::create('form')
        ->setPageTitle($this->page_title)
        ->setTabNav($this->group_list,$this->group_curr)
        ->setFormItems($this->model->getFromItems())
        ->view();
    }
    /**
     * 修改操作
     * @param integer $id
     * @return void
     * @author 刘勤 <876771120@qq.com>
     */
    public function edit($id=0){
        if(!$id) $this->error("参数错误");
        $this->model = $this->loadModel();
        if($this->request->isPost()){
            // 加载验证器
            $this->validate = $this->loadValidate();
            // 获取数据
            $data = input('post.');
            // 判断是否有该验证场景
            if($this->validate){
                try {
                    // 如果有验证场景则使用验证场景
                    if($this->validate->hasScene('edit')){
                        validate(get_class($this->validate))->scene('edit')->check($data);
                    }else{
                        validate(get_class($this->validate))->check($data);
                    }
                } catch (ValidateException $e) {
                    return json($e->getError());
                }
            }
            $res = $this->model->update($data);
            if($res){
                Cache::clear();
                // 记录行为日志
                $this->writeLog($this->model->getLastSql(),'',1);
                $url = (string)url('index');
                if($this->group_curr){
                    $param['group'] = $this->group_curr;
                    $url = $url.'?'.http_build_query($param);
                }else{
                    $param = [];
                }
                $this->success('操作成功',$url);
            }else{
                // 记录行为日志
                $this->writeLog($this->model->getLastSql());
                $this->error('操作失败');
            }
        }
        $formData = $this->model->find($id)->toArray();
        return Dbuilder::create('form')
        ->setPageTitle($this->page_title)
        ->setTabNav($this->group_list,$this->group_curr)
        ->setFormItems($this->model->getFromItems())
        ->setFormData($formData)
        ->view();
    }

    /**
     * 禁用
     * @param array $record 行为日志内容
     * @author 刘勤 <876771120@qq.com>
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function disable(){
        return $this->setStatus('disable');
    }

    /**
     * 启用
     * @author 刘勤 <876771120@qq.com>
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function enable(){
        return $this->setStatus('enable');
    }
    /**
     * 禁用
     * @author 刘勤 <876771120@qq.com>
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delete(){
        return $this->setStatus('delete');
    }
    /**
     * 设置状态
     * 禁用、启用、删除都是调用这个内部方法
     * @param string $type 操作类型：enable,disable,delete
     * @param string $record 行为日志内容
     * @author 刘勤 <876771120@qq.com>
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function setStatus($type = '',$details=''){
        $ids   = $this->request->isPost() ? input('post.ids/a') : input('param.ids');
        $ids   = $ids ? $ids : input('param.id');
        $ids   = (array)$ids;
        $field = input('param.field', 'state');

        empty($ids) && $this->error('缺少主键');
        
        $Model = $this->loadModel();
        $protect_table = [
            config('database.prefix').'admin_user',
            config('database.prefix').'admin_role',
            config('database.prefix').'admin_perm',
            config('database.prefix').'admin_module',
        ];
        // 禁止操作核心表的主要数据
        if (in_array($Model->getTable(), $protect_table) && in_array('1', $ids)) {
            $this->error('禁止操作');
        }

        // 主键名称
        $pk = $Model->getPk();
        $map = [
            [$pk, 'in', $ids]
        ];

        $result = false;
        switch ($type) {
            case 'disable': // 禁用
                $result = $Model->where($map)->update([$field=>0]);
                break;
            case 'enable': // 启用
                $result = $Model->where($map)->update([$field=>1]);
                break;
            case 'delete': // 删除
                $result = $Model->where($map)->delete();
                break;
            default:
                $this->error('非法操作');
                break;
        }

        if (false !== $result) {
            Cache::clear();
            // 记录行为日志
            $this->writeLog($Model->getLastSql());
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }
    /**
     * 写入日志
     * @param string $details 备注
     * @param string $action 操作
     * @author 刘勤 <876771120@qq.com>
     * @return void
     */
    public function writeLog($details='',$title='',$state=0){
        $action = app('http')->getName().'/'.$this->request->controller(true).'/'.$this->request->action(true);
        try {
            $actionInfo = MenuModel::getMenuByUrl($action);
        } catch (Exception $th) {
            
        }
        if(!$actionInfo){
            $actionInfo = [
                'title'=>'没有记录菜单的操作',
                'url_value'=>$action
            ];
        }
        $data = [
            'title'=>$title?$title:$actionInfo['title'],
            'url'=>(string)url($action),
            'param'=>http_build_query(input('param',[])),
            'user_id'=>UID,
            'details'=>$details,
            'state'=>$state,
            'ip'=>get_client_ip(1)
        ];
        $res = Log::create($data);
    }
}