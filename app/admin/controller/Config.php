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
namespace app\admin\controller;

use app\admin\controller\Common;
use app\common\builder\Dbuilder;

use app\admin\model\Config as ConfigModel;
use think\facade\App;
use think\facade\Db;
/**
 * 配置管理控制器
 * @package app\admin\controller
 * @author 刘勤 <876771120@qq.com>
 */
class Config extends Common{
    
    /**
     * 管理列表页面
     *
     * @return void
     */
    public function index(){
        $model = $this->loadModel();
        $group = input('group','base');
        // 如果是post则表示在请求数据
        if(request()->isAjax() && request()->isPost()){
            $field = $model->getQueryField();
            $order = $this->getOrder();
            $where[] = ['group','=',$group];
            $list = $model->buildQuery([],$field,$order)->where("id=? and name like ?", [1,'%web%'])->paginate([
                'list_rows'=> input('size',10),
                'page' => input('page',1),
            ]);
            // dump($list->getCollection());die;
            return json(['code'=>1,'msg'=>'获取成功','count'=>$list->total(),'data'=>$list->getCollection()]);
        }
        $tabNav = [];
        foreach (config('app.config_group') as $name => $title) {
            $item['title']=$title;
            $item['name'] = $name;
            $item['href'] = strtolower((string)url('index',['group'=>$name]));
            $tabNav[] = $item;
        }
        return Dbuilder::create('table')
        ->setPageTitle('配置管理')
        ->setTabNav($tabNav,$group)
        ->setModel($model)
        ->addColumns($model->getTableConfig())
        ->addTopButtons('add,enable,disable,delete')
        ->setSearch(['name','title'])
        ->setSearchArea(['name','title'])
        ->view();
    }
}