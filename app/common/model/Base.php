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
     * 配置信息
     *
     * @var array
     */
    protected $form = [];
    /**
     * 架构函数
     * @access public
     * @param array $data 数据
     */
    public function __construct(array $data = []){
        parent::__construct($data);
        
    }
    /**
     * 获取form表单配置信息
     * @author 刘勤 <876771120@qq.com>
     * @return array
     */
    public function getForm(){
        return $this->form;
    }
    /**
     * 获取字段配置信息
     * @author 刘勤 <876771120@qq.com>
     * @return void
     */
    protected function getField(){
        return $this->fields;
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