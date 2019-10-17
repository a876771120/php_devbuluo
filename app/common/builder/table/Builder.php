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
     * 模板输出变量
     * @author 刘勤 <876771120@qq.com>
     * @var array
     */
    protected $_vars=[
        'page_title'        =>'',   //页面标题
        'checkbox'          =>true, //是否有选择框
        'tab_nav'           =>[],   //顶部导航
        'dataTable_id'      =>'',   //数据表格的id
        'ajax_info'         =>[],   //数据请求地址
        'show_page'         =>true, //是否显示分页
        'tree_table'        =>[],   //树形表格
        'top_buttons'       =>[],   //顶部按钮
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
     * 设置Tab按钮列表
     * @param array $list Tab列表  ['title' => '标题', 'href' => '']
     * @param string $curr 当前tab
     * @author 刘勤 <876771120@qq.com>
     * @return $this
     */
    public function setTabNav($list = [], $curr = ''){
        if (!empty($tab_list)) {
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
    public function setCheckbox($status=true){
        $this->_vars['checkbox'] = $status;
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
        $column = [
            'field'     => !empty($attribute['field']) ? $attribute['field'] : '',      //字段名称
            'width'     => !empty($attribute['width']) ? $attribute['width'] : '',      //宽度
            'title'     => !empty($attribute['title']) ? $attribute['title'] : '',      //标题
            'fixed'     => !empty($attribute['fixed']) ? $attribute['fixed'] : '',      //浮动
            'sort'      => !empty($attribute['sort']) ? $attribute['sort'] : '',        //排序
            'minWidth'  => !empty($attribute['minWidth']) ? $attribute['minWidth'] : '',//最小宽度
            'type'      => !empty($attribute['type']) ? $attribute['type'] : '',        //列类型
            'default'   => !empty($attribute['default']) ? $attribute['default'] : '',  //默认值
            'param'    => !empty($attribute['param']) ? $attribute['param'] : '',       //额外参数
            'align'     => !empty($attribute['align']) ? $attribute['align'] : '',      //排版，居左，居中，居右
            'template'  => !empty($attribute['template']) ? $attribute['template'] : '',//模板
            'unresize'  => !empty($attribute['unresize']) ? $attribute['unresize'] : '',//不允许调整宽度
        ];
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
                    'jump-target'   => '_pop'
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
     * 添加顶部搜索条件
     * @param string $field 搜索字段
     * @param string $title 搜索标题
     * @return $this
     */
    public function addSimpleSearch($field='',$type='string'){



        return $this;
    }
    /**
     * 批量添加搜索条件
     *
     * @param array $searchParam 搜索数据
     * @return $this
     */
    public function addSimpleSearchs($searchParam=[]){
        if (!empty($searchParam)) {
            foreach ($searchParam as $param) {
                call_user_func_array([$this, 'addSearch'], $param);
            }
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
        // 解析参数
        parse_str(!empty($menu['param'])?$menu['param']:'',$orgParam);
        // 合并参数
        $param = array_merge($orgParam);
        // 返回url
        return (string)url($url,$param);
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
        // 组装列
        foreach ($this->_vars['columns'] as &$column) {
            // 如果类型是编辑框，如排序字段，可以修改排序
            if($column['template']=='text.edit'){
                $column['template']='<div class="dui-input">
                    <input type="text" class="dui-input__inner dui-table__input" value="{{'.$column['field'].'}}">
                </div>';
            }
            // 删除为空的配置信息
            foreach ($column as $key => $value) {
                if($value==''){
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
        // 设置默认ajax请求地址
        if(empty($this->_vars['ajax_info']['url'])){
            $this->_vars['ajax_info']['url'] = (string)url($this->app.'/'.$this->controller.'/'.$this->action);
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