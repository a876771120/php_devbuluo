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
namespace app\api\controller;
use app\admin\controller\Common;
use app\common\builder\Dbuilder;
/**
 * 配置管理控制器
 * @package app\api\controller
 * @author 刘勤 <876771120@qq.com>
 */
class Group extends Common{
    /**
     * 右侧操作按钮
     * @var array
     */
    protected $top_buttons = ['add','enable','disable','delete'];
    /**
     * 右侧操作按钮
     * @var array
     */
    protected $right_buttons = ['edit','enable','disable','delete'];
    /**
     * 顶部搜索信息
     * @var array
     */
    protected $search = ['name','description'];
}