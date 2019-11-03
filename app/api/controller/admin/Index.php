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
namespace app\api\controller\admin;

use app\common\builder\Dbuilder;
use app\admin\controller\Common;
use app\api\entity\DataType;
use think\Exception;
use think\exception\ValidateException;
/**
 * 配置管理控制器
 * @package app\api\controller\admin
 * @author 刘勤 <876771120@qq.com>
 */
class Index extends Common{
    /**
     * 是否显示多选
     * @var boolean
     */
    protected $checkbox=true;
    /**
     * 参数类型
     * @var array
     */
    private $dataType = array(
        DataType::TYPE_STRING  => 'String',
        DataType::TYPE_INTEGER => 'Integer',
        DataType::TYPE_FLOAT   => 'Float',
        DataType::TYPE_BOOLEAN => 'Boolean',
        DataType::TYPE_FILE    => 'File',
        DataType::TYPE_ENUM    => 'Enum',
        DataType::TYPE_JSON    => 'JSON',
        DataType::TYPE_OBJECT  => 'Object',
        DataType::TYPE_ARRAY   => 'Array'
    );
    /**
     * 后台api首页
     * @return void
     * @author 刘勤 <876771120@qq.com>
     */
    public function index(){
        if($this->request->isPost()){
            return call_user_func(array('parent', __FUNCTION__));          
        }
        $this->top_buttons=[
            'add'=>[
                'jump-mode'     => '_pjax',
            ],
            'refresh'=>[
                'title'         => '刷新路由',
                'class'         => 'dui-button dui-button--warning confirm',
                'jump'          => '',
                'href'          => (string)url('refresh'),
                'jump-mode'     => '_ajax',
            ],
            'delete'
        ];
        $this->right_buttons=[
            'edit'=>[
                'jump-mode'     => '_pjax',
                'jump-url'      => urldecode((string)url('edit',['id'=>'{{id}}']))
            ],
            'delete'
        ];
        return call_user_func(array('parent', __FUNCTION__));
    }
    /**
     * 添加方法
     * @return void
     */
    public function add(){
        $this->model = $this->loadModel();
        if($this->request->isPost()){
            $data = input('post.');
            try {
                validate(get_class($this->loadValidate()))->check($data);
            } catch (ValidateException $e) {
                $this->error($e->getError());
            }
            $res = $this->model->create($data);
            if($res){
                $this->success('添加成功',(string)url('index'));
            }else{
                $this->error('添加失败');
            }

        }
        $formItems = array_column($this->model->getFromItems(), null, 'field');
        return view()->assign(['formItems'=>$formItems]);
    }
    /**
     * 修改方法
     * @return void
     */
    public function edit($id=''){
        if(!$id) $this->error('参数错误！');
        $this->model = $this->loadModel();
        // 如果是post提交
        if($this->request->isPost()){
            $data = input('post.');
            try {
                validate(get_class($this->loadValidate()))->check($data);
            } catch (ValidateException $e) {
                $this->error($e->getError());
            }
            $res = $this->model->update($data);
            if($res){
                $this->success('修改成功',(string)url('index'));
            }else{
                $this->error('修改失败');
            }
        }
        // 获取数据
        $data = $this->model->find($id);
        $formItems = array_column($this->model->getFromItems(), null, 'field');
        $data['request'] = json_decode($data['request'],true);
        $data['response'] = json_decode($data['response'],true);
        return view()->assign(['data'=>$data,'formItems'=>$formItems]);
    }
    /**
     * 刷新路由操作
     * @return void
     * @author 刘勤 <876771120@qq.com>
     */
    public function refresh(){
        // 路由路径
        $tplPath = app()->getBasePath().'api/data/Api.tpl';
        // 路由模板路径
        $apiRoutePath = app()->getRootPath().'route/api/Api.php';
        // 支持的请求方式
        $methodArr = ['*', 'POST', 'GET', 'PUT', 'DELETE', 'HEAD'];
        // 获取模板内容
        $tplStr = file_get_contents($tplPath);
        // 获取所有的接口
        $listInfo = $this->loadModel()->where('state','in',['1','2','3','4'])->column('api_class,method,user_token,access_token','hash');
        // 路由字符串
        $routeStr = [];
        // 组装路由字符串
        foreach ($listInfo as $hash=>&$rule) {
            $middleware = ['"LogStart"'];
            // 解析url
            try {
                list($app,$controller,$action) = explode('/',$rule['api_class']);
            } catch (Exception $th) {
                // 如果报错则表示没有输入应用则使用api应用
                $app = 'api';
                list($controller,$action) = explode('/',$rule['api_class']);
            }
            if(in_array($rule['access_token'],['1','2'])){
                $middleware = array_merge($middleware,['"ApiAuth"','"ApiPermission"']);
            }
            $middleware[] = '"ApiRequest"';
            if($rule['user_token']==1){
                $middleware[] = '"UserAuth"';
            }
            $middleware[] = '"LogEnd"';
            array_push($routeStr, "Route::rule('".addslashes($hash)."','app\\".$app."\\controller\\interface\\".$controller."@".$action."','".$methodArr[$rule['method']]."')->middleware([".implode(',',$middleware)."]);");
        }
        $routeStr = str_replace('{$API_RULE}',implode(PHP_EOL,$routeStr),$tplStr);
        // 写入路由文件
        file_put_contents($apiRoutePath, $routeStr);
        $this->success('路由刷新成功');
    }
}