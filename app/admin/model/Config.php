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
namespace app\admin\model;
use app\common\model\Base;
/**
 * 配置模型
 * @package app\admin\model
 * @author 刘勤 <876771120@qq.com>
 */
class Config extends Base{
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
    // 设置当前模型名称
    protected $name = 'AdminConfig';
    // 字段定义
    protected $fields=[
        'id'=>[
            'title'     =>  'ID',           //标题
            'type'      =>  'integer',      //类型
            'table'     =>  false,          //table列的显示样式，如果为false则表示该列隐藏
            'form'      =>  [               
                'template'  =>  'hidden',
                'default'   =>  0
            ]                               //form的固有属性
        ],
        'name'=>[
            'title'     =>  '配置名称',           //标题
            'table'     =>  [
                'sort'      =>true,
                'filter'    =>true
            ]
        ],
        'title'=>[
            'title'     =>  '配置标题',           //标题
            'filter'    =>  true
        ],
        'type'=>[
            'title'     =>  '类型',           //标题
            'table'     =>  [
                'width'     =>  80,             //列表页面的宽度
            ],
            'form'      =>  [
                'template'  =>  'text',
                'default'   =>  0,
            ]
        ],
        'group'=>[
            'title'     =>  '分组',           //标题
            'table'     =>  [
                'width'     =>  80,             //列表页面的宽度
                'filter'    => [
                    'type'  => 'enum',
                    'options'=>[],
                ]
            ],
            'form'      =>  [
                'template'  =>  'text',
                'default'   =>  0,
            ]
        ],
        'state'=>[
            'title'     =>  '状态',           //标题
            'type'      =>  'integer',
            'table'     =>  [
                'width'     =>  80,             //列表页面的宽度
                'template'  =>  'switch',       //模板
                'options'=>['inactiveValue'=>0,'activeValue'=>1],
                'filter'=>[
                    'type'  =>'enum',
                    'options'=>[0=>'禁用',1=>'启用']
                ]
            ],
            'form'      =>  [
                'template'  =>  'text',
                'default'   =>  0,
            ]
        ],
        'create_time'=>[
            'title'     =>  '创建时间',           //创建时间
            'table'     => [
                'width' => 180,
                'filter'=>true
            ],
            'type'      =>  'timestamp',
            'form'      =>  false
        ],
        'update_time'=>[
            'title'     =>  '创建时间',           //创建时间
            'table'     => [
                'width' => 180,
                'filter'=> true
            ],
            'type'      =>  'timestamp',
            'form'      =>  false
        ],
    ];
    /**
     * 初始化字段方法
     * @author 刘勤 <876771120@qq.com>
     * @return void
     */
    protected function setFields(){
        $this->fields['group']['options'] = config('app.config_group');
        $this->fields['group']['table']['filter']['options']=config('app.config_group');
    }
    /**
     * 获取配置信息
     * @param  string $name 配置名
     * @author 刘勤 <876771120@qq.com>
     * @return mixed
     */
    public static function getConfig($name = ''){
        $configs = self::where('state','=',1)->select();
        $result = [];
        foreach ($configs as $config) {
            switch ($config['type']) {
                case 'array':
                    $result[$config['name']] = parse_attr($config['value']);
                    break;
                case 'checkbox':
                    if ($config['value'] != '') {
                        $result[$config['name']] = explode(',', $config['value']);
                    } else {
                        $result[$config['name']] = [];
                    }
                    break;
                default:
                    $result[$config['name']] = $config['value'];
                    break;
            }
        }
        return $name != '' ? $result[$name] : $result;
    }
}

