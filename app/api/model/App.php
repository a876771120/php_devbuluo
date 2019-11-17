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

/**
 * 应用模型
 * @package app\admin\model
 * @author 刘勤 <876771120@qq.com>
 */
class App extends Base{
    // 设置当前模型名称
    protected $name = 'ApiApp';
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
    /**
     * 初始化字段设置
     * @return void
     * @author 刘勤 <876771120@qq.com>
     */
    protected function initFields(){
        $group = Db::name('ApiAppGroup')->where('state','=',1)->column('name','hash');
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
                'title'=>'应用名称',
                'list'=>[
                    'filter'=>true,
                    'width'=>250,
                ]
            ],
            'app_group'=>[
                'title'=>'应用分组',
                'list'=>[
                    'filter'=>[
                        'template'=>'select',
                        'options'=>$group
                    ],
                    'width'=>150,
                    'options'=>$group,
                ],
                'form'=>[
                    'template'=>'select',
                    'options'=>$group,
                    'value'=>key($group)
                ]
            ],
            'app_id'=>[
                'title'=>'AppId',
                'list'=>[
                    'filter'=>true,
                    'width'=>120,
                ],
                'form'=>[
                    'template'=>'text',
                    'attr'=>[
                        'readonly'=>'readonly'
                    ],
                    'value'=>$this->makeAppId()
                ]
            ],
            'app_secret'=>[
                'title'=>'AppSecret',
                'list'=>[
                    'filter'=>true,
                    'width'=>280,
                ],
                'form'=>[
                    'template'=>'refresh_text',
                    'attr'=>[
                        'ajax-url'=>(string)url('getSecret')
                    ],
                    'value'=>$this->makeAppSecret(),
                ]
            ],
            'description'=>[
                'title'=>'应用说明',
                'list'=>[
                    'filter'=>true,
                    'minWidth'=>250
                ],
                'form'=>[
                    'template'=>'textarea'
                ]
            ],
            'app_api'=>[
                'type'=>'json',
                'title'=>'接口访问',
                'list'=>false,
                'form'=>[
                    'template'=>'checkbox_groups',
                    'options'=>$this->getAppApi(),
                    'value'=>[]
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
            ]
        ];
    }
    /**
     * 生成app_id的方法,保证不重复
     * @return void
     */
    public function makeAppId(){
        return (mt_rand(1, 9).substr(time(),4,6).mt_rand(1, 9));
    }
    /**
     * 生成app密匙，保证唯一
     *
     * @return void
     */
    public function makeAppSecret(){
        return md5(uniqid(mt_rand(), true));
    }
    /**
     * 获取器
     *
     * @return void
     */
    public function getAppGroupAttr($value,$data){
        $group = Db::name('ApiAppGroup')->where('state','=',1)->column('name','hash');
        return $group[$value];
    }
    /**
     * 获取所有的api并分组
     *
     * @return void
     */
    public function getAppApi(){
        $group_data = Db::name('ApiGroup')->where('state','=',1)->column('name','hash');
        $res = [];
        foreach ($group_data as $hash => $name) {
            $group = [];
            $group['value']= $hash;
            $group['title'] = $name;
            $where = [];
            $where[] = ['state','in',['1','2','3','4']];
            $where[] = ['group_hash','=',$hash];
            $group['child'] = Db::name('ApiList')->where($where)->column('name','hash');
            $res[] = $group;
        }
        return $res;
    }
}