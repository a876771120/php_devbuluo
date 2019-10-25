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

use app\admin\model\App;
use app\common\utils\Hash;
use think\helper\Str;
use think\Exception;
use think\Model;
/**
 * 配置模型
 * @package app\admin\model
 * @author 刘勤 <876771120@qq.com>
 */
class Base extends Model{
    /**
     * 列的定义
     * @var array
     */
    protected $fields = [];
    /**
     * 表格字段
     * @var array
     */
    protected $listColumns = [];
    /**
     * 表单字段
     * @var array
     */
    protected $formItems =[];
    /**
     * 获取器配置
     * @var array
     */
    protected $getter = [];
    /**
     * 重写初始化方法
     * @param array $data
     */
    public function __construct(array $data = []){
        // 初始化列设置
        $this->initFields();
        // 父类初始化
        parent::__construct($data);
        // 初始化列的设置根据列配置
        if(!empty($this->fields)){
            foreach ($this->fields as $field => $info) {
                // 必须是当前表的数据才类型转换
                if(count(explode('.',$field))<2){
                    $this->type[$field]=isset($info['type'])?$info['type']:'string'; 
                }
                // 修改器的配置
                if(isset($info['options'])){
                    // 配置
                    $this->getter[$field]['options'] = $info['options'];
                    $this->getter[$field]['default'] = isset($info['default'])?$info['default']:'';
                }
                // 设置表格显示字段
                if(!(isset($info['list']) && $info['list']===false)){
                    $listItem = [];
                    // 字段
                    $listItem['field'] = $field;
                    // 标题
                    $listItem['title'] = isset($info['title']) ? $info['title']:$field;
                    // 合并属性
                    $listItem = array_merge($listItem,isset($info['list'])?$info['list']:[]);
                    // 添加一个列
                    $this->listColumns[] = $listItem;
                }
                // 设置表单字段
                if(!(isset($info['form']) && $info['form']===false)){
                    $formItem = [];
                    // 字段
                    $formItem['field'] = $field;
                    // 标题
                    $formItem['title'] = isset($info['title']) ? $info['title']:$field;
                    // 合并属性
                    $formItem = array_merge($formItem,isset($info['form'])?$info['form']:[]);
                    // 添加一个列
                    $this->formItems[] = $formItem;
                }
            }
        }
    }
    /**
     * 初始化列设置
     * @return void
     */
    protected function initFields(){
        
    }
    /**
     * 获取表格的配置信息
     * @return array
     * @author 刘勤 <a876771120@qq.com>
     */
    public function getListColumns():array{
        if($this->listColumns){
            return $this->listColumns;
        }
        return [];
    }
    /**
     * 获取表单的配置信息
     * @return array
     * @author 刘勤 <876771120@qq.com>
     */
    public function getFromItems():array{
        if($this->formItems){
            return $this->formItems;
        }
        return [];
    }
}