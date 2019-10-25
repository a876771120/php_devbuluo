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
namespace app\common\builder\table;

use think\Exception;
use app\admin\model\Menu;
use app\common\builder\Dbuilder;
use app\member\model\Role as RoleModel;

/**
 * dui框架table构建器
 * @author 刘勤 <876771120@qq.com>
 * @package namespace app\common\builder\table
 */
class Builder extends Dbuilder{
    /**
     * 表格视图模板
     * @author 刘勤 <876771120@qq.com>
     * @var string
     */
    protected $_template='';
    /**
     * 当前table的模型
     *
     * @var \think\Model
     */
    protected $_model;
    /**
     * 顶部搜索框
     * @var array
     */
    protected $_search=[];
    /**
     * 高级搜索字段
     * @var array
     */
    protected $_filterInfo=[];
    /**
     * 树形表格配置信息
     * @var array
     */
    protected $_treeTable=[];

    /**
     * 模板输出变量
     * @author 刘勤 <876771120@qq.com>
     * @var array
     */
    protected $_vars=[
        'pk'                =>'id',   //数据表格主键
        'page_title'        =>'',   //页面标题
        'checkbox'          =>true, //是否有选择框
        'table_tree'        =>[],   //树形表格配置
        'columns'           =>[],   //列集合
        'tab_nav'           =>[],   //顶部导航
        'dataTable_id'      =>'',   //数据表格的id
        'ajax_info'         =>[],   //数据请求地址
        'show_page'         =>true, //是否显示分页
        'tree_table'        =>[],   //树形表格
        'top_buttons'       =>[],   //顶部按钮
        'right_buttons'     =>[],   //右侧操作按钮
    ];
    /**
     * 初始化
     * @author 刘勤 <876771120@qq.com>
     * @return void
     */
    protected function initialize(){
        // 设置模板地址
        $this->_template = app()->getBasePath().'/common/builder/table/layout.html';
        // 设置当前table的id
        $this->_vars['dataTable_id'] = $this->app.'_'.$this->controller.'_'.$this->action;
    }
    /**
     * 设置页面标题
     * @param string $title 页面标题
     * @author 刘勤 <876771120@qq.com>
     * @return $this
     */
    public function setPageTitle($title=''){
        if($title){
            $this->_vars['page_title'] = $title;
        }
        return $this;
    }
    /**
     * 设置设置是否是树形表格
     * @param array $cfg 配置信息
     * @return $this
     * @author 刘勤 <876771120@qq.com>
     */
    public function setTreeTable($cfg=[]){
        if($cfg){
            $this->_treeTable = $cfg;
        }
        return $this;
    }
    /**
     * 设置当前表格模型
     * @param think\Model $model
     * @author 刘勤 <876771120@qq.com>
     * @return $this
     */
    public function setModel(\think\Model $model){
        if($model){
            $this->_model = $model;
        }
        return $this;
    }
    /**
     * 设置Tab按钮列表
     * @param array $list Tab列表  ['title' => '标题', 'href' => '']
     * @param string $curr 当前tab
     * @author 刘勤 <876771120@qq.com>
     * @return $this
     */
    public function setTabNav($list = [], $curr = ''){
        if (!empty($list)) {
            $this->_vars['tab_nav'] = [
                'list' => $list,
                'curr' => $curr,
            ];
        }
        return $this;
    }
    /**
     * 设置请求信息
     * @param array $ajaxInfo 设置ajax请求信息
     * @author 刘勤 <876771120@qq.com>
     * @return $this
     */
    public function setAjaxInfo($ajaxInfo=[]){
        if(!empty($ajaxInfo)){
            $this->_vars['ajax_info'] = $ajaxInfo;
        }
        return $this;
    }
    /**
     * 隐藏选择框
     * @author 刘勤 <876771120@qq.com>
     * @return $this
     */
    public function setCheckbox($state=true){
        $this->_vars['checkbox'] = $state;
        return $this;
    }
    /**
     * 设置是否显示分页
     *
     * @param boolean $show
     * @author 刘勤 <876771120@qq.com>
     * @return $this
     */
    public function setShowPage($show=true){
        $this->_vars['show_page'] = $show;
        return $this;
    }
    /**
     * 设置数据表格的主键
     * @param string $pk
     * @return $this
     */
    public function setPk($pk=''){
        if(!$pk){
            $this->_vars['pk'] = $pk;
        }
        return $this;
    }
    /**
     * 添加一个table列
     *
     * @param array $attribute 列属性
     *          [
     *              field   =>'username',  //列隐藏名
     *              width   =>80,          //列宽
     *              title   =>'用户名’,     //列显示名
     *              fixed   =>true|'right' //浮动
     *              sort    =>true,        //是否允许排序
     *              minWidth=>100,         //列最小宽度
     *              type    =>'numbers'    //列类型normal，checkbox，numbers,switch中的任意值,如果type为checkbox则隐藏标题
     *              teplate =>'<div class="dui-button-group"><button class="dui-button dui-button--mini" data-id="{{username}}">编辑</button></div>',  //使用js模板引擎art-template
     *          ]
     * @author 刘勤 <876771120@qq.com>
     * @return $this
     */
    public function addColumn($attribute=[]){
        $column = $attribute;
        $this->_vars['columns'][] = $column;
        return $this;
    }
    /**
     * 一次性添加多列
     * @param array $columns 数据列
     * @author 刘勤 <876771120@qq.com>
     * @return $this
     */
    public function addColumns($columns=[]){
        if (!empty($columns)) {
            foreach ($columns as $column) {
                call_user_func([$this, 'addColumn'], $column);
            }
        }
        return $this;
    }
    /**
     * 添加一个顶部按钮
     * @param string $type  类型
     * @param array $attribute  其他属性
     * @param boolean $param  额外参数
     * @author 刘勤 <876771120@qq.om>
     * @return $this
     */
    public function addTopButton($type = '', $attribute = [], $param = []){
        //根据不同的类型构建属性
        switch ($type) {
            // 新增按钮
            case 'add':
                // 默认属性
                $btn_attribute = [
                    'title'         => '新增',
                    'class'         => 'dui-button dui-button--primary',
                    'jump'          => '',
                    'href'          => $this->createBtnUrl($type,$param),
                    'jump-mode'   => '_pop'
                ];
                break;
            // 启用按钮
            case 'enable':
                // 默认属性
                $btn_attribute = [
                    'title'         => '启用',
                    'class'         => 'dui-button dui-button--success confirm',
                    'jump'          => 'submit',
                    'href'          => $this->createBtnUrl($type,$param),
                    'jump-mode'     => '_ajax',
                    'jump-form'     => $this->app.'_'.$this->controller.'_index',
                ];
                break;
            // 禁用按钮
            case 'disable':
                // 默认属性
                $btn_attribute = [
                    'title'         => '禁用',
                    'class'         => 'dui-button dui-button--warning confirm',
                    'jump'          => 'submit',
                    'href'          => $this->createBtnUrl($type,$param),
                    'jump-mode'     => '_ajax',
                    'jump-form'     => $this->app.'_'.$this->controller.'_index',
                ];
                break;
            // 禁用按钮
            case 'delete':
                // 默认属性
                $btn_attribute = [
                    'title'         => '删除',
                    'class'         => 'dui-button dui-button--danger confirm',
                    'jump'          => 'submit',
                    'href'          => $this->createBtnUrl($type,$param),
                    'jump-mode'     => '_ajax',
                    'jump-form'     => $this->app.'_'.$this->controller.'_index',
                ];
                break;
            // 自定义按钮
            default:
                // 默认属性
                $btn_attribute = [
                    'title'         => '定义按钮',
                    'class'         => 'dui-button dui-button--default',
                    'jump'          => '',
                    'jump-form'     => 'ids',
                    'href'          => 'javascript:void(0);'
                ];
                break;
        }
        // 合并自定义属性
        if ($attribute && is_array($attribute)) {
            $btn_attribute = array_merge($btn_attribute, $attribute);
        }
        // 判断权限
        if(session('member_auth.role_id') != 1){
            // 如果没有生成
            if($this->checkBtnAuth($btn_attribute)===false){
                return $this;
            }
        }
        // 替换链接
        $this->_vars['top_buttons'][] = $btn_attribute;
        return $this;
    }
    /**
     * 一次性添加多个顶部按钮
     * @param array|string $buttons 按钮类型
     * 例如：
     * $builder->addTopButtons('add');
     * $builder->addTopButtons('add,delete');
     * $builder->addTopButtons(['add', 'delete']);
     * $builder->addTopButtons(['add' => ['model' => '__USER__'], 'delete']);
     * $builder->addTopButtons(['add' => ['attribute'=>['title'=>'新增'],'param'=>['uid'=>1]]])
     * @author 刘勤 <876771120@qq.com>
     * @return $this
     */
    public function addTopButtons($buttons = []){
        if (!empty($buttons)) {
            $buttons = is_array($buttons) ? $buttons : explode(',', $buttons);
            foreach ($buttons as $key => $value) {
                if (is_numeric($key)) {
                    $this->addTopButton($value);
                } else {
                    if(is_array($value) && !empty($value['param']) && !empty($value['attribute'])){
                        $this->addTopButton($key, $value['attribute'],$value['param']);
                    }else{
                        $this->addTopButton($key, $value);
                    }
                }
            }
        }
        return $this;
    }
    /**
     * 添加一个右侧操作按钮
     * @param string $type  类型
     * @param array $attribute  其他属性
     * @param array $param  额外参数
     * @author 刘勤 <876771120@qq.om>
     * @return $this
     */
    public function addRightButton($type = '', $attribute = [], $param = []){
        $newParam['id'] = '{{$thisTablePk}}';
        $param = array_merge($newParam,$param);
        //根据不同的类型构建属性
        switch ($type) {
            // 新增按钮
            case 'edit':
                // 默认属性
                $btn_attribute = [
                    'title'         => '修改',
                    'class'         => 'dui-button dui-button--mini dui-button--primary',
                    'jump'          => '',
                    'href'          => $this->createBtnUrl($type,$param),
                    'jump-mode'     => '_pop'
                ];
                break;
            // 启用按钮
            case 'enable':
                // 默认属性
                $btn_attribute = [
                    'title'         => '启用',
                    'class'         => 'dui-button dui-button--mini dui-button--success confirm',
                    'jump'          => '',
                    'href'          => $this->createBtnUrl($type,$param),
                    'jump-mode'     => '_ajax',
                ];
                break;
            // 禁用按钮
            case 'disable':
                // 默认属性
                $btn_attribute = [
                    'title'         => '禁用',
                    'class'         => 'dui-button dui-button--mini dui-button--warning confirm',
                    'jump'          => '',
                    'href'          => $this->createBtnUrl($type,$param),
                    'jump-mode'     => '_ajax',
                ];
                break;
            // 禁用按钮
            case 'delete':
                // 默认属性
                $btn_attribute = [
                    'title'         => '删除',
                    'class'         => 'dui-button dui-button--mini dui-button--danger confirm',
                    'jump'          => '',
                    'href'          => $this->createBtnUrl($type,$param),
                    'jump-mode'     => '_ajax',
                ];
                break;
            // 自定义按钮
            default:
                // 默认属性
                $btn_attribute = [
                    'title'         => '定义按钮',
                    'class'         => 'dui-button dui-button--mini dui-button--default',
                    'jump'          => '',
                    'href'          => 'javascript:void(0);'
                ];
                break;
        }
        // 合并自定义属性
        if ($attribute && is_array($attribute)) {
            $btn_attribute = array_merge($btn_attribute, $attribute);
        }
        // 判断权限
        if(session('member_auth.role_id') != 1){
            // 如果没有生成
            if($this->checkBtnAuth($btn_attribute)===false){
                return $this;
            }
        }
        // 替换链接
        $this->_vars['right_buttons'][] = $btn_attribute;
        return $this;
    }

    /**
     * 一次性添加多个右侧操作按钮
     * @param array|string $buttons 按钮类型
     * 例如：
     * $builder->addRightButtons('add');
     * $builder->addRightButtons('add,delete');
     * $builder->addRightButtons(['add', 'delete']);
     * $builder->addRightButtons(['add' => ['model' => '__USER__'], 'delete']);
     * $builder->addRightButtons(['add' => ['attribute'=>['title'=>'新增'],'param'=>['uid'=>1]]])
     * @author 刘勤 <876771120@qq.com>
     * @return $this
     */
    public function addRightButtons($buttons = []){
        if (!empty($buttons)) {
            $buttons = is_array($buttons) ? $buttons : explode(',', $buttons);
            foreach ($buttons as $key => $value) {
                if (is_numeric($key)) {
                    $this->addRightButton($value);
                } else {
                    if(is_array($value) && !empty($value['param']) && !empty($value['attribute'])){
                        $this->addRightButton($key, $value['attribute'],$value['param']);
                    }else{
                        $this->addRightButton($key, $value);
                    }
                }
            }
        }
        return $this;
    }
    /**
     * 添加简单的搜索
     * @param array $field 搜索字段
     * @param string $placeholder 提示
     * @author 刘勤 <876771120@qq.com>
     * @return $this
     */
    public function setSearch($fields=[],$placeholder = ''){
        if (!empty($fields)) {
            $this->_search = [
                'fields'      => is_string($fields) ? explode(',', $fields) : $fields,
                'placeholder' => $placeholder,
            ];
        }
        return $this;
    }
    /**
     * 添加高级搜索
     * @param array $items 搜索字段
     * @author 刘勤 <876771120@qq.com>
     * @return $this
     */
    public function setFilterInfo($fields = []){
        if (!empty($fields)) {
            $this->_filterInfo = is_string($fields) ? explode(',', $fields) : $fields;
        }
        return $this;
    }
    /**
     * 根据类型创建按钮的访问地址
     * @param string $type 链接类型
     * @param array $param 额外参数
     * @author 刘勤 <876771120@qq.com>
     * @return string
     */
    protected function createBtnUrl($type='',$param=[]){
        // 组装url
        $url = $this->app.'/'.$this->controller.'/'.$type;
        // 查询数据库
        $menu = Menu::getMenuByUrl($url);
        if(is_string($param)){
            // 解析参数
            parse_str(!empty($menu['param'])?$menu['param']:'',$orgParam);
            // 合并参数
            $param = array_merge($orgParam);
        }
        // 返回url
        return strtolower(urldecode((string)url($url,$param)));
    }
    /**
     * 检查按钮是否有权限
     * @param array $attr 按钮属性
     * @author 刘勤 <876771120@qq.com>
     * @return bool
     */
    protected function checkBtnAuth($attr=[]){
        $url = !empty($attr['jump-url']) ? $attr['jump-url'] : !empty($attr['href']) ? $attr['href'] :'';
        if (preg_match('/\/(index.php|'.ADMIN_FILE.')\/(.*)/', $url , $match)) {
            $url_value = explode('/', $match[2]);
            if (strpos($url_value[2], '.')) {
                $url_value[2] = substr($url_value[2], 0, strpos($url_value[2], '.'));
            }
            $url_value = $url_value[0].'/'.$url_value[1].'/'.$url_value[2];
            $url_value = strtolower($url_value);
            return RoleModel::checkAuth($url_value, true);
        }
        return true;
    }

    /**
     * 编译表格
     * @author 刘勤 <876771120@qq.com>
     * @return void
     */
    protected function compileTable(){
        // 设置表的主键
        if($this->_model){
            $this->_vars['pk'] = $this->_model->getPk();
        }
        // 组装顶部按钮
        foreach ($this->_vars['top_buttons'] as &$button) {
            // 编译html的属性
            $button['attribute'] = $this->compileHtmlAttr($button);
            $newButton = "<a {$button['attribute']}>";
            if (isset($button['icon']) && $button['icon'] != '') {
                $newButton .= '<i class="'.$button['icon'].'"></i> ';
            }
            $newButton .= "{$button['title']}</a>";
            $button = $newButton;
        }
        // 处理搜索框
        if ($this->_search) {
            $_temp_fields = [];
            foreach ($this->_search['fields'] as $key => $field) {
                if (is_numeric($key)) {
                    $_temp_fields[$field] = !empty($fieldConfig['title'])?$fieldConfig['title']:'';
                } else {
                    $_temp_fields[$key]   = $field;
                }
            }
            $this->_vars['search'] = [
                'fields'      => $_temp_fields,
                'field_all'   => implode('|', array_keys($_temp_fields)),
                'placeholder' => $this->_search['placeholder'] != '' ? $this->_search['placeholder'] : '请输入'. implode('/', $_temp_fields),
            ];
        }
        // 处理高级搜索
        if($this->_filterInfo){
            $_temp_fields = [];
            foreach ($this->_filterInfo as $key => $field) {
                if (is_numeric($key)) {
                    $_temp_fields[$field] = !empty($fieldConfig['title'])?$fieldConfig['title']:'';
                } else {
                    $_temp_fields[$key]   = $field;
                }
            }
            $this->_filterInfo = $_temp_fields;
        }
        // 处理是否是树形表格
        if($this->_treeTable){
            $this->_vars['tree_table'] = $this->_treeTable;
        }
        // 组装列
        foreach ($this->_vars['columns'] as $index => &$column) {
            // 如果类型是编辑框，如排序字段，可以修改排序
            if(!empty($column['template']) && $column['template']=='text.edit'){
                $column['template']='<div class="dui-input">
                    <input type="text" class="dui-input__inner dui-table__input" value="{{'.$column['field'].'}}">
                </div>';
            }else if(!empty($column['template']) && $column['template']=='switch'){
                // 居中显示
                if(empty($column['align'])){
                    $column['align'] = 'center';
                }
                // 状态模板
                $column['template']='<input type="checkbox" dui-switch data-field="'.$column['field'].'" value="{{'.$column['field'].'}}" inactive-value="'.$column['options']['inactiveValue'].'" 
                active-value="'.$column['options']['activeValue'].'"/>';
            }
            // 组装高级查询
            if(!empty($column['filter'])){
                if($column['filter']===true){
                    $column['filter'] = [
                        'type'=>!empty($column['type']) ? $column['type'] : 'string',
                    ];
                }
            }else{
                if(!empty($this->_filterInfo[$column['field']])){
                    $column['filter'] = [
                        'type'=>!empty($column['type']) ? $column['type'] : 'string',
                    ];
                    if($column['filter']['type']=='enum'){
                        if(empty($column['options'])){
                            unset($column['filter']);
                        }
                    }else{
                        $column['filter'] = array_merge($column['filter'],$this->_filterInfo[$column['field']]);
                    }
                }
            }
            // 删除为空的配置信息
            foreach ($column as $key => $value) {
                if(!$value){
                    unset($column[$key]);
                }
            }
        }
        // 是否有选择框
        if($this->_vars['checkbox']){
            array_unshift($this->_vars['columns'],[
                'field'=>'',
                'type' =>'checkbox',
                'fixed'=>true
            ]);
        }
        // 构建右侧操作按钮
        if($this->_vars['right_buttons']){
            $right_btns_with = 0;
            // 组装右侧按钮
            foreach ($this->_vars['right_buttons'] as &$button) {
                $len = mb_strlen($button['title'],'UTF-8');
                $font_with = $len*12;
                $right_btns_with += $font_with+18;
                $right_btns_with += !empty($button['icon'])?16:0;
                // 编译html的属性
                $button['attribute'] = $this->compileHtmlAttr($button);
                $newButton = "<a {$button['attribute']}>";
                if (isset($button['icon']) && $button['icon'] != '') {
                    $newButton .= '<i class="'.$button['icon'].'"></i> ';
                }
                $newButton .= "{$button['title']}</a>";
                if($this->_model){
                    $pk = $this->_model->getPk();
                }
                $newButton = str_replace('$thistablepk', $pk, $newButton);
                $button = $newButton;
            }
            
            $this->_vars['columns'][] = [
                'field'=>'',
                'title'=>'操作',
                'align'=>'center',
                'fixed'=>'right',
                'width'=>$right_btns_with+60,
                'template'=>'<div class="dui-button-group">'.join('',$this->_vars['right_buttons']).'</div>'
            ];
        }
        // 设置默认ajax请求地址
        if(empty($this->_vars['ajax_info']['url'])){
            $this->_vars['ajax_info']['url'] = (string)url($this->app.'/'.$this->controller.'/'.$this->action,input('get.'));
        }
        // 设置请求类型
        if(empty($this->_vars['ajax_info']['type'])){
            $this->_vars['ajax_info']['type'] = 'post';
        }
    }
    /**
     * 编译html属性
     * @param array $attrs 属性数组
     * @author 刘勤 <876771120@qq.com>
     * @return string
     */
    protected function compileHtmlAttr($attrs=[]){
        $result = [];
        if ($attrs) {
            foreach ($attrs as $key => &$value) {
                if ($key == 'title') {
                    $value = trim(htmlspecialchars(strip_tags(trim($value))));
                } else {
                    $value = htmlspecialchars($value);
                }
                array_push($result, $value?"$key=\"$value\"":"$key");
            }
        }
        return join(' ', $result);
    }
    /**
     * 模板赋值
     * @param string|array $name 变量名称
     * @param string $value 变量值
     * @author 刘勤 <876771120@qq.com>
     * @return $this
     */
    public function assign($name, $value = ''){
        if (is_array($name)) {
            $this->_vars = array_merge($this->_vars, $name);
        } else {
            $this->_vars[$name] = $value;
        }
        return $this;
    }
    /**
     * 渲染视图
     * @param string $template  自定义显示模板
     * @param array $vars   额外变量
     * @author 刘勤 <876771120@qq.com>
     * @return mixed
     */
    public function view($template = '', $vars = []){
        // 编译表格数据
        $this->compileTable();

        if ($template != '') {
            $this->_template = $template;
        }

        if (!empty($vars)) {
            $this->_vars = array_merge($this->_vars, $vars);
        }
        // 实例化视图并渲染
        return view($this->_template)->assign($this->_vars);
    }
}