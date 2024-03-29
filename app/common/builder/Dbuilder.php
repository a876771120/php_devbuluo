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
namespace app\common\builder;
use think\app;
use think\facade\View;
/**
 * 对dui的界面构建器
 * @package app\common\builder
 * @author 刘勤 <876771120@qq.com>
 */
class Dbuilder{
    // 当前应用
    protected $app;
    // 当前控制器
    protected $controller;
    // 当前操作方法
    protected $action;
    /**
     * 构造方法
     */
    public function __construct()
    {
        $this->app = app('http')->getName();
        $this->controller = request()->controller(true);
        $this->action = request()->action(true);
        // 构造器始化
        $this->initialize();
    }

    // 初始化
    protected function initialize()
    {}
    /**
     * 创建指定类型的构建器
     *
     * @param string $type
     * @author 刘勤 <876771120@qq.com>
     * @return table\Builder|form\Builder
     */
    public static function create($type=''){
        if ($type == '') {
            throw new Exception('未指定构建器名称', 8001);
        } else {
            $type = strtolower($type);
        }
        // 构造器类路径
        $class = '\\app\\common\\builder\\'. $type .'\\Builder';
        if (!class_exists($class)) {
            throw new Exception($type . '构建器不存在', 8002);
        }
        return new $class;
    }
}