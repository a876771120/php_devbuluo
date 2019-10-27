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
        
    }
}