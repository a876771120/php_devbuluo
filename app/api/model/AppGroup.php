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
namespace app\api\model;
use app\common\model\Base;
use think\helper\Str;

/**
 * 接口应用分组
 * @package app\admin\model
 * @author 刘勤 <876771120@qq.com>
 */
class AppGroup extends Base{
    // 设置当前模型名称
    protected $name = 'ApiAppGroup';
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
    /**
     * 初始化字段信息
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
            'name'=>[
                'title'=>'应用组名称',
                'list'=>[
                    'filter'=>true
                ]
            ],
            'description'=>[
                'title'=>'应用组描述',
                'list'=>[
                    'filter'=>true
                ],
                'form'=>[
                    'template'=>'textarea'
                ]
            ],
            'hash'=>[
                'title'=>'应用组标识',
                'list'=>[
                    'filter'=>true
                ],
                'form'=>[
                    'template'=>'text',
                    'attr'=>[
                        'readonly'=>'readonly'
                    ],
                    'value'=>uniqid(),
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
                'form'=>[
                    'template'=>'switch',
                    'options'=>['active-value'=>1,'inactive-value'=>0],
                    'value'=>1,
                ]
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
}