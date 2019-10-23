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
namespace app\common\model;
use think\Model;
/**
 * 配置模型
 * @package app\admin\model
 * @author 刘勤 <876771120@qq.com>
 */
class Base extends Model{
    /**
     * 字段配置信息
     * @var array
     */
    protected $fields = [];
    /**
     * form表单配置信息
     * @var array
     */
    protected $_form = [];
    /**
     * 数据表格的配置信息
     * @var array
     */
    protected $_table = [];
    /**
     * 查询的字段
     * @var array
     */
    protected $_query_field=[];
    /**
     * 修改器配置
     * @var array
     */
    protected $_attrs=[];
    /**
     * 架构函数
     * @access public
     * @param array $data 数据
     */
    public function __construct(array $data = []){
        // 设置字段信息
        $this->setFields();
        // 父类初始化
        parent::__construct($data);
        // 初始化字段设置
        if(!empty($this->fields)){
            foreach ($this->fields as $field => $config) {
                $tableConfig = [];$formConfig=[];
                // 设置字段
                $tableConfig['field'] = $formConfig['field'] = $field;
                $tableConfig['type'] = $formConfig['type'] = isset($config['type'])?$config['type']:'string';;
                $tableConfig['title'] = $formConfig['title'] = isset($config['title'])?$config['title']:$field;
                // 设置修改器字段
                if(!empty($config['options'])){
                    $this->_attrs[$field]['attrs']=$config['options'];
                    $this->_attrs[$field]['default']=!empty($config['default'])?$config['default']:'';
                }
                $tableConfig['options'] = $formConfig['options'] = !empty($config['options']) ? $config['options']:[];
                // 如果table配置信息不为空并且不是为false
                if(!(isset($config['table']) && $config['table']==false)){
                    $config['table'] = $config['table'] ?? [];
                    $tableConfig = array_merge($tableConfig,(!empty($config['table'])?$config['table']:[]));
                    $tableConfig['template'] = !empty($tableConfig['template'])?$tableConfig['template']:'';
                    $this->_table[$field] = $tableConfig;
                }
                if(!(isset($config['form']) && $config['form']==false)){
                    $formConfig = array_merge($formConfig,(!empty($config['form'])?$config['form']:[]));
                    $tableConfig['template'] = !empty($tableConfig['template'])?$tableConfig['template']:'text';
                    $this->_form[$field] = $formConfig;
                }
                // 初始化类型转换设置
                if(!empty($config['type'])){
                    $this->type[$field] = $config['type'];
                }
                $this->_query_field[] = $field;
            }
        }
    }
    /**
     * 设置字段信息方法
     * @author 刘勤 <876771120@qq.com>
     * @return void
     */
    protected function setFields(){
        
    }
    
    /**
     * 获取fields配置信息
     * @param string $field 字段名称
     * @author 刘勤 <876771120@qq.com>
     * @return array
     */
    public function getFieldConfig($field=''){
        if(!$field){
            return $this->fields;
        }else{
            if(!empty($this->fields[$field])){
                return $this->fields[$field];
            }else{
                return null;
            }
        }
    }

    /**
     * 获取form表单配置信息
     * @param string $field 字段名称
     * @author 刘勤 <876771120@qq.com>
     * @return array
     */
    public function getFormConfig($field=''){
        if(!$field){
            return $this->_form;
        }else{
            if(!empty($this->_form[$field])){
                return $this->_form[$field];
            }else{
                return null;
            }
        }
    }
    /**
     * 获取table的配置信息
     * @param string $field 字段名称
     * @author 刘勤 <876771120@qq.com>
     * @return array
     */
    public function getTableConfig($field=''){
        if(!$field){
            return $this->_table;
        }else{
            if(!empty($this->_table[$field])){
                return $this->_table[$field];
            }else{
                return null;
            }
        }
    }
    /**
     * 获取列表数据
     * @param array $where 条件
     * @param array $field  查询字段
     * @param array $order  排序
     * @param integer $page 页数
     * @param integer $size 每页显示条数
     * @param array $with   联合查询条件
     * @author 刘勤 <876771120@qq.com>
     * @return void
     */
    public function buildQuery($where=[],$field=[],$order=[],$page=1,$size=10,$joins=[]){
        // dump('进来了');die;
        $queryBuilder = $this->where($where);
        foreach ($joins as $key => $condition) {
            
        }
        // 字段设置
        $queryBuilder = $queryBuilder->field($field);
        // 排序设置
        $queryBuilder = $queryBuilder->order($order);
        // 修改器
        $getAttr = $this->getAttrConfig();
        foreach ($getAttr as $key => $options) {
            // dump($options);die;
            $queryBuilder = $queryBuilder->withAttr($key,function($value, $data)use($options){
                if(!empty($options['attrs'][$value])){
                    return $options['attrs'][$value];
                }else{
                    return !empty($options[$value]['default']) ? $options[$value]['default']:'';
                }
            });
        }
        // $list = $queryBuilder->paginate([
        //     'list_rows'=> $size,
        //     'page'=>$page
        // ]);
        return $queryBuilder;
    }

    /**
     * 获取联合查询条件
     * @author 刘勤 <876771120@qq.com>
     * @return array
     */
    public function getQueryWidth(){

    }

    /**
     * 获取修改器属性
     * @author 刘勤 <876771120@qq.com>
     * @return array
     */
    public function getAttrConfig(){
        if($this->_attrs){
            return $this->_attrs;
        }
        return [];
    }

    /**
     * 获取查询的字段
     * @author 刘勤 <876771120@qq.com>
     * @return array
     */
    public function getQueryField(){
        if(!empty($this->_query_field)){
            if(!in_array($this->getPk(),$this->_query_field)){
                array_unshift($this->_query_field,$this->getPk());
            }
            return $this->_query_field;
        }else{
            return [];
        }
    }

    /**
     * 获取字段定义
     * @author 刘勤 <876771120@qq.com>
     * @return array
     */
    public function getSchema(){
        return $this->schema;
    }
}