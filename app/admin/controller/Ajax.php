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
use app\admin\model\Menu as MenuModel;
use app\common\controller\Admin;

class Ajax extends Admin{
    /**
     * 获取指定模块的菜单
     * @param string $app 应用名
     * 
     * @return mixed
     */
    public function getAppMenu($app=''){
        $menus = MenuModel::getMenuTree(0, '', $app);
        $result = [
            'code' => 1,
            'msg'  => '请求成功',
            'data' => format_linkage($menus)
        ];
        return json($result);
    }
}
