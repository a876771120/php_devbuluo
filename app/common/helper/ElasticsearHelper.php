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
namespace app\common\helper;

use app\api\helper\ReturnCode;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Exception;

/**
 * es相关帮助类
 * @package app\common\helper
 * @author 刘勤 <876771120@qq.com>
 */
class ElasticsearHelper{
    /**
     * 索引名，相当于关系型数据的database
     * @var string|array
     */
    protected $indexName;
    /**
     * 类型，相当于关系型数据库的table，但是7.0后已经不用了
     * @var string
     */
    protected $type;
    /**
     * 客户端
     * @var Client
     */
    protected $client;
    /**
     * 创建实例
     * @return $this
     */
    public static function Create($indexName,$type='_doc'){
        $ins = new ElasticsearHelper($indexName,$type);
        return $ins;
    }
    /**
     * 初始化方法
     */
    public function __construct($indexName,$type='_doc'){
        try {
            $this->indexName = $indexName;
            $this->type = $type;
            $this->client = ClientBuilder::create()
            ->setHosts(config('elasticsearch.host'))
            ->build();
        } catch (exception $e) {
            return [
                'code'=>ReturnCode::ES_CONNET_ERROR,
                'msg'=>'es连接错误'.$e->getMessage(),
                'data'=>[]
            ];
        }
    }
    /**
     * 初始化参数
     * @author 刘勤 <876771120@qq.com>
     * @return array
     */
    protected function initParams(){
        return [
            'index'=>$this->indexName,
            'type'=>$this->type
        ];
    }
    /**
     * 创建索引，在设置mapping之前,也可以直接连mapping一起设置
     * @param array $fields 字段集合
     * @author 刘勤 <876771120@qq.com>
     * @return array
     */
    public function createIndex(array $fields=[]){
        try {
            $indexParams = [
                'index'=>$this->indexName,
                'body'=>[
                    'settings' => [
                        'number_of_shards' => 3,
                        'number_of_replicas' => 2
                    ],
                ]
            ];
            // 设置mapping,7.0版本以后一个索引只对应一个type
            $indexParams['body']['mappings'] = [
                '_source' => [
                    'enabled' => true,
                ],
            ];
            if($fields){
                foreach ($fields as $field => $field_type) {
                    // 设置类型
                    $mapParams[$field] = [
                        'type'=>$field_type
                    ];
                    switch ($field_type) {
                        case 'text':
                            $mapParams[$field]['analyzer']='ik_max_word';
                            $mapParams[$field]['search_analyzer']='ik_max_word';
                            break;
                        case 'string':
                            $mapParams[$field]['type'] = 'keyword';
                        default:
                            # code...
                            break;
                    }
                }
                $indexParams['body']['mappings']['properties'] = $mapParams;
            }
            // dump($indexParams);die;
            $data = $this->client->indices()->create($indexParams);
            return $this->success($data);
        } catch (Exception $e) {
            return $this->error(ReturnCode::ES_CREATE_INDEX_ERROR,'创建索引失败'.$e->getMessage());
        }
    }
    /**
     * 设置maping
     * @param array $fields 字段集合
     * @author 刘勤 <876771120@qq.com>
     * @return void
     */
    public function putMapping(array $fields=[]){
        try {
            $indexParams = ['index'=>$this->indexName];
            $mapParams = [];
            if($fields){
                foreach ($fields as $field => $field_type) {
                    // 设置类型
                    $mapParams[$field] = [
                        'type'=>$field_type
                    ];
                    switch ($field_type) {
                        case 'text':
                            $mapParams[$field]['analyzer']='ik_max_word';
                            $mapParams[$field]['search_analyzer']='ik_max_word';
                            break;
                        case 'string':
                            $mapParams[$field]['type'] = 'keyword';
                        default:
                            # code...
                            break;
                    }
                }
                $indexParams['body']['properties'] = $mapParams;
            }
            // dump($indexParams);die;
            $data = $this->client->indices()->putMapping($indexParams);
            return $this->success($data);
        } catch (Exception $e) {
            return $this->error(ReturnCode::ES_PUT_MAPING_ERROR,'设置映射失败'.$e->getMessage());
        }
    }
    /**
     * 简单查询
     * @param array $data
     * @author 刘勤 <876771120@qq.com>
     * @return void
     */
    public function searchNoScoll(array $data=[],bool $highlight = false){
        try {
            $params = [
                'index' => $this->indexName,   // 索引：数据库
                'type' => $this->type,    // 类型：数据表
            ];
            $field = key($data);
            $field_arr = explode(",", $field);
            $query = [
                'multi_match'=>[
                    'query'         =>  $data[$field],
                    'type'          =>  "best_fields",  //# 我们希望完全匹配的文档占的评分比较高，则需要使用best_fields
                    'fields'        =>  $field_arr,
                    'tie_breaker'   =>  0.3
                ]
            ];
            // 如果需要有高亮
            if($highlight){
                // 高亮
                $highlight = [];
                foreach ($field_arr as $field){
                    $highlight['fields'][$field] = [
                        'pre_tags'=>'<em>',
                        'post_tags'=>'</em>'
                    ];
                }
                $params['body']['highlight'] = $highlight;
            }
            $params['body']['query'] = $query;
            // dump($params);die;
            $data = $this->client->search($params);
            return $this->success($data);
        } catch (Exception $e) {
            return $this->error(ReturnCode::ES_SEARCH_ERROR,'查询失败');
        }
    }
    /**
     * 添加数据
     * @param array $data 要添加的数据
     * @author 刘勤 <876771120@qq.com>
     * @return void
     */
    public function add(array $data=[]){
        try {
            $params = $this->initParams();
            if(!is_array($data)){
                if(method_exists($data,'toArray')){
                    $data = $data->toArray();
                }else{
                    $data = json_decode(json_encode($data),true);
                }
            }
            if(array_key_exists('id',$data)){
                $params['id'] = $data['id'];
            }
            $params['type'] = '_doc';
            $params['body'] = $data;
            // dump($params);die;
            $data =$this->client->create($params);
            return $this->success($data);
        } catch (Exception $e) {
            return $this->error(ReturnCode::ES_CREATE_INDEX_ERROR,'添加数据失败'.$e->getMessage());
        }
    }
    /**
     * 修改方法
     * @param array $data
     * @author 刘勤 <876771120@qq.com>
     * @return void
     */
    public function edit(array $data=[]){
        try {
            //1.先查询出来
            if(!isset($data['id'])){
                return $this->error(ReturnCode::ES_EDITE_ERROR,'缺少主键id');
            }
            $params = $this->initParams();
            $params['id'] = $data['id'];
            $params['body']['doc'] = $data;
            $data =$this->client->update($params);
            return $this->success($data);
        } catch (Exception $e) {
            return $this->error(ReturnCode::ES_EDITE_ERROR,'修改数据失败'.$e->getMessage());
        }
    }
    /**
     * 删除
     * @param string $id
     * @author 刘勤 <876771120@qq.com>
     * @return void
     */
    public function delete($id=''){
        try {
            $params = $this->initParams();
            $params['id'] = $id;
            $data = $this->client->delete($params);
            return $this->success($data);
        } catch (Exception $e) {
            return $this->error(ReturnCode::ES_DELETE_ERROR,'删除失败'.$e->getMessage());
        }
    }
    /**
     * 成功返回
     * @param array $data 成功数据
     * @param integer $code 成功码
     * @param string $msg 成功提示
     * @author 刘勤 <876771120@qq.com>
     * @return void
     */
    protected function success(array $data=[],int $code=1,string $msg='操作成功'){
        return [
            'code'=>$code,
            'msg'=>$msg,
            'data'=>$data
        ];
    }
    /**
     * 失败返回
     * @param int $code
     * @param string $msg
     * @param array $data
     * @author 刘勤 <876771120@qq.com>
     * @return void
     */
    protected function error(int $code=-1,string $msg='操作失败',array $data=[]){
        return [
            'code'=>$code,
            'msg'=>$msg,
            'data'=>$data
        ];
    }
}