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
namespace app\article\controller\api;
use app\api\controller\api\Base;
use app\common\helper\ElasticsearHelper;
use app\common\helper\PhpTree;
use think\helper\Str;
use think\Exception;

class Category extends Base{
    /**
     * es连接客户端
     * @var ElasticsearHelper
     */
    protected $client;
    /**
     * es7中取消了type的概念，所以这相当于表名
     * @var string
     */
    protected $index = 'tags';
    /**
     * 初始化方法
     *
     * @return void
     */
    protected function init(){
        $this->client = ElasticsearHelper::Create($this->index);
    }
    /**
     * 获取栏目分类
     * @return void
     */
    public function index(){
        $params = $this->client->initParams();
        $params['body']=[];
        $res = $this->client->getClient()->search($params);
        try {
            $data = [];
            if(isset($res['hits']['total']['value']) && $res['hits']['total']['value']>0){
                foreach ($res['hits']['hits'] as $value) {
                    $temp = isset($value['_source'])?$value['_source']:[];
                    if(isset($temp['pid'])){
                        foreach ($temp['pid'] as $key => $pid) {
                            $temp2 = $temp;
                            unset($temp2['pid']);
                            $temp2['pid'] = $pid;
                            $data[] = $temp2;
                        }
                    }else{
                        $temp['pid'] = 0;
                        $data[] = $temp;
                    }
                }
            }
            
            $newdata = PhpTree::toLayer($data);
            return json(['code'=>1,'msg'=>'获取成功','data'=>$newdata]);
        } catch (Exception $th) {
            
        }
    }

    
    protected function createTable(){
        // $fields = [
        //     'id'=>'keyword',//唯一标识
        //     'pid'=>'keyword',//一个tag可能属于多个上级
        //     'background'=>'keyword',//背景
        //     'icon'=>'keyword',//图标
        //     'name'=>'text',//名称
        //     'title'=>'text',//标题
        //     'weight'=>'integer',//权重
        //     'create_time'=>'integer',//创建时间
        //     'update_time'=>'integer',//创建时间
        // ];
        // // 创建索引
        // // dump($this->client->createIndex()); 
        // // 设置maping 
        // // dump($this->client->putMapping($fields));
        // // 添加数据
        // $addData = [
        //     'id'=>strtolower(Str::random()).uniqid().strtolower(Str::random()),
        //     'pid'=>['gcfqha5dc6addacf7b9jbugvo'],
        //     'name'=>'php',
        //     'title'=>'PHP',
        //     'weight'=>8,
        //     'create_time'=>time(),
        //     'update_time'=>time()
        // ];
        // // $editData = [
        // //     'id'=>'sjxzfj5dc6adf28a8desxdczz',
        // //     // 'pid'=>'vnxayd5dc6902025798embwiy',
        // //     'name'=>'frontend',
        // //     'title'=>'前端',
        // //     // 'weight'=>2,
        // //     // 'create_time'=>time()
        // // ];
        // dump($this->client->add($addData));
        // // dump($this->client->edit($editData));
        // // dump(\uniqid());die;
        // // dump($this->client->searchNoScoll());die;
    }
}