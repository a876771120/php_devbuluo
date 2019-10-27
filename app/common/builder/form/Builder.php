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
namespace app\common\builder\form;

use think\Exception;
use app\common\builder\Dbuilder;
use think\facade\View;

/**
 * dui框架form构建器
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
        'form_id'           =>      '',//表单的id
        'page_title'        =>      '',//页面标题
        'tab_nav'           =>      '',//表单分组
        'ajax_info'         =>      [],//请求信息
        'form_items'        =>      [],//表单组合
        'form_data'         =>      [],//表单回显数据
    ];
    /**
     * 初始化
     * @author 刘勤 <876771120@qq.com>
     * @return void
     */
    protected function initialize(){
        // 设置模板地址
        $this->_template = app()->getBasePath().'/common/builder/form/layout.html';
        // 设置当前table的id
        $this->_vars['form_id'] = $this->app.'_'.$this->controller.'_'.$this->action;
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
     * 直接设置form表单元素
     * @param array $items
     * @return $this
     */
    public function setFormItems($items=[]){
        if (!empty($items)) {
            
            // 额外已经构造好的表单项目与单个组装的的表单项目进行合并
            $this->_vars['form_items'] = array_merge($this->_vars['form_items'], $items);
        }
        return $this;
    }
    /**
     * 添加隐藏表单项
     * @param string $field 表单项名
     * @param string $default 默认值
     * @param string $extra_class 额外css类名
     * @author 刘勤 <876771120@qq.com>
     * @return $this
     */
    public function addHidden($field = '', $default = '', $extra_class = ''):Builder{
        $item = [
            'template'        => 'hidden',
            'field'        => $field,
            'value'       => $default,
            'extra_class' => $extra_class,
        ];
        $this->_vars['form_items'][] = $item;
        return $this;
    }
    /**
     * 添加一个文本框
     *
     * @param string $field 文本框提交名
     * @param string $title 标题
     * @param string $tips  提示信息
     * @param string $default 默认值
     * @param string $extra_attr 额外属性
     * @param string $extra_class 额外的class
     * @return Builder
     * @author 刘勤 <876771120@qq.com>
     */
    public function addText($field = '', $title = '', $tips='', $default = '',$extra_attr = '', $extra_class = ''):Builder{
        if(strpos($title, '|')){
            list($title, $placeholder) = explode('|', $title);
        }
        $item = [
            'template'        => 'text',
            'field'        => $field,
            'title'       => $title,
            'tips'        => $tips,
            'value'       => $default,
            'extra_class' => $extra_class,
            'extra_attr'  => $extra_attr,
            'placeholder' => isset($placeholder) ? $placeholder : '请输入'.$title,
        ];
        $this->_vars['form_items'][] = $item;
        return $this;
    }

    /**
     * 添加一个文本框
     *
     * @param string $field 文本框提交名
     * @param string $title 标题
     * @param string $tips  提示信息
     * @param string $default 默认值
     * @param string $extra_attr 额外属性
     * @param string $extra_class 额外的class
     * @return Builder
     * @author 刘勤 <876771120@qq.com>
     */
    public function addTextarea($field = '', $title = '', $tips='', $default = '',$extra_attr = '', $extra_class = ''):Builder{
        if(strpos($title, '|')){
            list($title, $placeholder) = explode('|', $title);
        }
        $item = [
            'template'        => 'textarea',
            'field'        => $field,
            'title'       => $title,
            'tips'        => $tips,
            'value'       => $default,
            'extra_class' => $extra_class,
            'extra_attr'  => $extra_attr,
            'placeholder' => isset($placeholder) ? $placeholder : '请输入'.$title,
        ];
        $this->_vars['form_items'][] = $item;
        return $this;
    }
    /**
     * 添加单选
     * @param string $field 单选名
     * @param string $title 单选标题
     * @param array $options 单选数据
     * @param string $default 默认值
     * @param array $attr 属性，
     *      bordered:边框，默认false
     *      disabled:禁用, 默认fase
     *      buttoned:是否以按钮的形式,默认fasle
     * @param string $extra_attr 额外属性
     * @param string $extra_class 额外css类名
     * @author 刘勤 <876771120@qq.com>
     * @return Builder
     */
    public function addRadio($field = '', $title = '', $options = [], $default = '', $attr = [], $extra_attr = '', $extra_class = ''):Builder{
        $item = [
            'template'    => 'radio',
            'field'        => $field,
            'title'       => $title,
            'options'     => $options == '' ? [] : $options,
            'value'       => $default,
            'attr'        => $attr,
            'extra_attr'  => $extra_attr,
            'extra_class' => $extra_class,
        ];
        $this->_vars['form_items'][] = $item;
        return $this;
    }
    /**
     * 添加单选
     * @param string|array $field 单选名
     * @param string $title 单选标题
     * @param array $options 单选数据
     * @param array $default 默认值
     * @param array $attr 属性，
     *      bordered:边框，默认false
     *      disabled:禁用, 默认fase
     *      buttoned:是否以按钮的形式,默认fasle
     * @param string $extra_attr 额外属性
     * @param string $extra_class 额外css类名
     * @author 刘勤 <876771120@qq.com>
     * @return Builder
     */
    public function addCheckbox($field = '', $title = '', $options = [], $default = [], $attr = [], $extra_attr = '', $extra_class = ''):Builder{
        $item = [
            'template'    => 'checkbox',
            'field'        => $field,
            'title'       => $title,
            'options'     => $options == '' ? [] : $options,
            'value'       => $default == '' ? [] : $default,
            'attr'        => $attr,
            'extra_attr'  => $extra_attr,
            'extra_class' => $extra_class,
        ];
        $this->_vars['form_items'][] = $item;
        return $this;
    }

    /**
     * 添加开关
     * @param string $field 表单项名
     * @param string $title 标题
     * @param string $tips 提示
     * @param string $default 默认值
     * @param array $options 属性，
     *      active-value:开启时的值
     *      inactive-value:关闭时的值
     *      active-text:开启时显示的label
     *      inactive-text:关闭时显示的label
     * @param string $extra_attr 额外属性
     * @param string $extra_class 额外css类名
     * @author 刘勤 <876771120@qq.com>
     * @return mixed
     */
    public function addSwitch($field = '', $title = '', $options = [], $default = '',  $extra_attr = '', $extra_class = ''):Builder{
        // options的默认值
        $optionsDefault = [
            'active-value'=>'1',
            'inactive-value'=>'0',
        ];
        // 合并属性
        $options = array_merge($optionsDefault,$options);
        $item = [
            'template'    => 'switch',
            'field'        => $field,
            'title'       => $title,
            'value'       => $default,
            'extra_class' => $extra_class,
            'extra_attr'  => $extra_attr,
            'extra_label_class' => $extra_attr == 'disabled' ? 'css-input-disabled' : '',
        ];
        $this->_vars['form_items'][] = $item;
        return $this;
    }
    /**
     * 添加普通下拉菜单
     * @param string $field 下拉菜单名
     * @param string $title 标题
     * @param string $tips  提示信息
     * @param array $options 选项
     * @param string $default 默认值
     * @param array $attr   额外属性配置
     * @param string $extra_attr 额外属性
     * @param string $extra_class 额外css类名
     * @author 刘勤 <876771120@qq.com>
     * @return Builder
     */
    public function addSelect($field = '', $title = '',$tips='', $options = [], $default = '',$attr=[], $extra_attr = '', $extra_class = ''):Builder{
        // 默认属性
        $attrDefault = [
            'multiple'=>'false',
            'disabled'=>'false',
            'clearable'=>'true',
            'filterable'=>'true',
        ];
        // 合并属性
        $attr = array_merge($attrDefault,$attr);
        if(isset($attr['multiple'])){
            $placeholder = $attr['multiple']=='true' ? '请选择一项或多项' : '请选择一项';
        }
        if(strpos($title, '|')){
            list($title, $placeholder) = explode('|', $title);
        }
        $item = [
            'template'    => 'select',
            'field'        => $field,
            'title'       => $title,
            'tips'        => $tips,
            'options'     => $options,
            'value'       => $default,
            'attr'        => $attr,
            'extra_class' => $extra_class,
            'extra_attr'  => $extra_attr,
            'placeholder' => $placeholder,
        ];
        $this->_vars['form_items'][] = $item;
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
     * 设置表单数据
     * @param array $form_data 表单数据
     * @author 刘勤 <876771120@qq.com>
     * @return Builder
     */
    public function setFormData($form_data = []):Builder{
        if (!empty($form_data)) {
            $this->_vars['form_data'] = $form_data;
        }
        return $this;
    }
    /**
     * 编译表单
     * @return void
     * @author 刘勤 <876771120@qq.com>
     */
    protected function compileForm(){
        // 设置ajax信息
        // 设置默认ajax请求地址
        if(empty($this->_vars['ajax_info']['url'])){
            $params = [];
            if(input('group')){
                $params['group'] = input('group');
            }
            $this->_vars['ajax_info']['url'] = (string)url($this->app.'/'.$this->controller.'/'.$this->action,$params);
        }
        // 设置默认值
        foreach ($this->_vars['form_items'] as $key => &$info) {
            if(isset($this->_vars['form_data'][$info['field']])){
                $info['value'] = $this->_vars['form_data'][$info['field']];
            }
        }
        // 设置请求类型
        if(empty($this->_vars['ajax_info']['type'])){
            $this->_vars['ajax_info']['type'] = 'post';
        }
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
        $this->compileForm();
        
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