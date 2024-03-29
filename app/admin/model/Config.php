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
    // 设置当前模型名称
    protected $name = 'AdminConfig';
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
    /**
     * 初始化方法
     * @return void
     */
    protected function initFields(){
        $this->fields = [
            'id'=>[
                'title'=>'ID',
                'type'=>'integer',
                'list'=>false,
                'form'=>[
                    'template'=>'hidden',
                ]
            ],
            'group'=>[
                'title'=>'配置组',
                'list'=>false,
                'form'=>[
                    'template'=>'radio',
                    'options'=>config('app.config_group'),
                    'value'=>input('group','base')
                ],
            ],
            'field'=>[
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
            'template'=>[
                'title'=>'表单模板',
                'form'=>[
                    'template'=>'select',
                    'options'=>config('app.form_items_template')
                ]
            ],
            'value'=>[
                'title'=>'配置值',
                'list'=>false,
                'form'=>[
                    'template'=>'textarea'
                ]
            ],
            'options'=>[
                'title'=>'配置项',
                'list'=>false,
                'form'=>[
                    'template'=>'textarea'
                ]
            ],
            'sort'=>[
                'title'=>'排序',
                'type'=>'integer',
                'list'=>[
                    'template'=>'text.edit'
                ]
            ],
            'state'=>[
                'title'=>'状态',
                'type'=>'integer',
                'list'=>[
                    'template'=>'switch',
                    'options'=>['active-value'=>1,'inactive-value'=>0],
                    'filter'=>[
                        'type'=>'enum',
                        'options'=>[1=>'启用',0=>'禁用']
                    ]
                ],
                'form'=>false
            ],
            'create_time'=>[
                'title'=>'创建时间',
                'list'=>[
                    'width'=>180,
                    'align'=>'center'
                ],
                'form'=>false
            ],
            'update_time'=>[
                'title'=>'修改时间',
                'list'=>[
                    'width'=>180,
                    'align'=>'center'
                ],
                'form'=>false
            ]
        ];
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
            switch ($config['template']) {
                case 'array':
                    $result[$config['field']] = parse_attr($config['value']);
                    break;
                case 'checkbox':
                    if ($config['value'] != '') {
                        $result[$config['field']] = explode(',', $config['value']);
                    } else {
                        $result[$config['field']] = [];
                    }
                    break;
                default:
                    $result[$config['field']] = $config['value'];
                    break;
            }
        }
        return $name != '' ? $result[$name] : $result;
    }
}

