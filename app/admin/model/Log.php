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
namespace app\admin\model;

use app\common\model\Base;
use think\Exception;
/**
 * 应用模型
 * @package app\admin\model
 * @author 刘勤 <876771120@qq.com>
 */
class Log extends Base{
    // 设置当前模型名称
    protected $name = 'AdminLog';
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
}