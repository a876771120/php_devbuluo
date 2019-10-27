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

use app\admin\model\App;
use app\admin\model\Config;
use app\common\builder\Dbuilder;
/**
 * 配置管理控制器
 * @package app\admin\controller
 * @author 刘勤 <876771120@qq.com>
 */
class System extends Common{
    /**
     * 管理列表页面
     * @return void
     */
    public function index(){
        if($this->request->isAjax() && $this->request->isPost()){
            $data = $this->request->post();
        }
        // 设置当前选中分组
        $this->group_curr = input('group','base');
        //设置分组
        foreach (config('app.config_group') as $name => $title) {
            $item['title']=$title;
            $item['name'] = $name;
            $item['href'] = strtolower((string)url('index',['group'=>$name]));
            $this->group_list[] = $item;
        }
        // 读取除了系统应用之外的分组
        $apps = App::where('config', '<>', '')
        ->where('state', 1)
        ->column('config,title,name', 'name');
        foreach ($apps as $name => $app) {
            $item['title']=$title;
            $item['name'] = $name;
            $item['href'] = strtolower((string)url('index',['group'=>$name]));
            $this->group_list[] = $item;
        }
        // 如果是系统配置
        if(isset(config('app.config_group')[$this->group_curr])){
            // 查询条件
            $where[] = ['group','=',$this->group_curr];// 当前分组
            $where[] = ['state','=',1];// 状态为启用
            // 数据列表
            $this->lists =  Config::where($where)
                ->order('sort asc,id asc')
                ->field([])
                ->select();
            $formItems = $this->lists->toArray();
            // 整理成需要formitem
            foreach ($formItems as $key => &$value) {
                // 解析options
                if ($value['options'] != '') {
                    $value['options'] = parse_attr($value['options']);
                }
                switch ($value['template']) {
                    // 日期时间
                    case 'date':
                        $value['value'] = $value['value'] != '' ? date('Y-m-d', $value['value']) : '';
                        break;
                    case 'time':
                        $value['value'] = $value['value'] != '' ? date('H:i:s', $value['value']) : '';
                        break;
                    case 'datetime':
                        $value['value'] = $value['value'] != '' ? date('Y-m-d H:i:s', $value['value']) : '';
                        break;
                }
            }
        }else{
            
        }
        return Dbuilder::create('form')
        ->setPageTitle('系统设置')
        ->setTabNav($this->group_list,$this->group_curr)
        ->setFormItems($formItems)
        ->view();
    }
}