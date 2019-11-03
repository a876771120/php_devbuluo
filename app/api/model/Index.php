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
use think\facade\Db;
use think\helper\Str;

/**
 * 接口应用分组
 * @package app\admin\model
 * @author 刘勤 <876771120@qq.com>
 */
class Index extends Base{
    // 设置当前模型名称
    protected $name = 'ApiList';
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
    /**
     * 初始化字段方法
     * @return void
     * @author 刘勤 <876771120@qq.com>
     */
    protected function initFields(){
        $groupOptions = Db::name('ApiGroup')->where('state','=',1)->column('name','hash');
        $this->fields=[
            'id'=>[
                'title'=>'ID',
                'list'=>false,
                'form'=>[
                    'template'=>'hidden',
                ]
            ],
            'name'=>[
                'title'=>'接口名称',
                'list'=>[
                    'filter'=>true,
                ]
            ],
            'api_class'=>[
                'title'=>'真实类库',
                'list'=>[
                    'filter'=>true,
                    'width'=>260
                ],
                'form'=>[
                    'tips'=>'如：member/user/login，即为访问member(应用)/user(控制器)/login(方法)'
                ]
            ],
            'group_hash'=>[
                'title'=>'接口分组',
                'list'=>false,
                'form'=>[
                    'template'=>'select',
                    'options'=>$groupOptions,
                    'value'=>key($groupOptions)
                ]
            ],
            'hash'=>[
                'title'=>'接口标识',
                'list'=>[
                    'filter'=>true,
                    'width'=>180
                ],
                'form'=>[
                    'template'=>'text',
                    'attr'=>[
                        'readonly'=>'readonly'
                    ],
                    'value'=>uniqid(),
                ]
            ],
            'method'=>[
                'title'=>'请求方式',
                'type'=>'integer',
                'list'=>[
                    'template'=>'<span class="dui-tag {{if method=="0"}} 
                    dui-tag--warning{{else if method=="1"}} dui-tag--success
                    {{else if method=="2"}} dui-tag--primary{{/if}} dui-tag--small">
                        {{if method=="0"}}不限{{else if method=="1"}}post{{else if method=="2"}}get
                        {{else if method=="3"}}PUT{{else if method=="4"}}DELETE{{else if method=="5"}}HEAD{{/if}}
                    </span>',
                    'align'=>'center',
                    'width'=>100,
                    'filter'=>[
                        'type'=>'enum',
                        'options'=>[
                            '0'=>'不限',
                            '1'=>'POST',
                            '2'=>'GET',
                            '3'=>'PUT',
                            '4'=>'DELETE',
                            '5'=>'HEAD'
                        ]
                    ]
                ],
                'form'=>[
                    'template'=>'select',
                    'options'=>[
                        '0'=>'不限',
                        '1'=>'POST',
                        '2'=>'GET',
                        '3'=>'PUT',
                        '4'=>'DELETE',
                        '5'=>'HEAD'
                    ],
                    'value'=>0
                ]
            ],
            'access_token'=>[
                'title'=>'AccessToken',
                'list'=>false,
                'form'=>[
                    'template'=>'select',
                    'options'=>[
                        0=>'不认证',
                        1=>'简单认证',
                        2=>'复杂认证'
                    ],
                    'value'=>1
                ]
            ],
            'user_token'=>[
                'title'=>'UserToken',
                'list'=>false,
                'form'=>[
                    'template'=>'select',
                    'options'=>[
                        0=>'不认证',
                        1=>'认证'
                    ],
                    'value'=>0
                ]
            ],
            'state'=>[
                'title'=>'状态',
                'type'=>'integer',
                'list'=>[
                    'template'=>'<span class="dui-tag{{ if state=="1"}} dui-tag--success
                    {{else if state=="2" || state=="3" || state=="4"}} dui-tag--warning{{else}}  dui-tag--danger{{/if}} dui-tag--small">
                        {{if state=="1"}}启用{{else if state=="2"}}维护
                        {{else if state=="3"}}开发{{else if state=="4"}}测试{{else if state=="5"}}BUG{{/if}}
                    </span>',
                    'align'=>'center',
                    'width'=>100,
                    'filter'=>[
                        'type'=>'enum',
                        'options'=>[
                            '1'=>'启用',
                            '2'=>'维护',
                            '3'=>'开发',
                            '4'=>'测试',
                            '5'=>'BUG'
                        ]
                    ]
                ],
                'form'=>[
                    'template'=>'switch',
                    'options'=>[
                        '1'=>'启用',
                        '2'=>'维护',
                        '3'=>'开发',
                        '4'=>'测试',
                        '5'=>'BUG',
                    ],
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