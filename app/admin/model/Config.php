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
use think\Model;
/**
 * 配置模型
 * @package app\admin\model
 * @author 刘勤 <876771120@qq.com>
 */
class Config extends Model{
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
    // 设置当前模型名称
    protected $name = 'AdminConfig';

    // 设置字段信息
    // protected $schema = [
    //     'id'          => 'int',
    //     'name'        => 'string',
    //     'status'      => 'int',
    //     'score'       => 'float',
    //     'create_time' => 'datetime',
    //     'update_time' => 'datetime',
    // ];
    /**
     * 获取字段信息
     *
     * @return void
     */
    public function getSchema(){
        return $this->schema;
    }
    /**
     * 获取配置信息
     * @param  string $name 配置名
     * @author 刘勤 <876771120@qq.com>
     * @return mixed
     */
    public static function getConfig($name = ''){
        $configs = self::where('status','=',1)->select();
        $result = [];
        foreach ($configs as $config) {
            switch ($config['type']) {
                case 'array':
                    $result[$config['name']] = parse_attr($config['value']);
                    break;
                case 'checkbox':
                    if ($config['value'] != '') {
                        $result[$config['name']] = explode(',', $config['value']);
                    } else {
                        $result[$config['name']] = [];
                    }
                    break;
                default:
                    $result[$config['name']] = $config['value'];
                    break;
            }
        }
        return $name != '' ? $result[$name] : $result;
    }
}

