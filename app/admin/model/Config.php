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
    // 列的配置信息
    protected $fields=[
        'id'=>[
            'title'=>'ID',
            'type'=>'integer',
            'list'=>false,
            'form'=>[
                'template'=>'hidden',
            ]
        ],
        'name'=>[
            'title'=>'配置名',
            'list'=>[
                'filter'=>true
            ]
        ],
        'title'=>[
            'title'=>'配置标题',
            'list'=>[
                'filter'=>true
            ]
        ],
        'state'=>[
            'title'=>'状态',
            'type'=>'integer',
            'list'=>[
                'template'=>'switch',
                'options'=>['activeValue'=>1,'inactiveValue'=>0],
                'filter'=>[
                    'type'=>'enum',
                    'options'=>[1=>'启用',0=>'禁用']
                ]
            ]
        ]
    ];
    /**
     * 初始化方法
     * @return void
     */
    protected function initFields(){
        
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

