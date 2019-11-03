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
declare(strict_types=1);
namespace app\api\middleware;

use app\api\entity\DataType;
use app\api\helper\ReturnCode;
use app\api\model\Index as ApiList;
use think\exception\ValidateException;
use think\App;
use app\Request as tpRequest;
use think\facade\Cache;
use think\facade\Validate;

/**
 * api权限验证
 * @package app\common\middleware
 * @author 刘勤 <876771120@qq.com>
 */
class Request{
    /**
     * 应用实例
     * @var App
     */
    protected $app;
    /**
     * 初始化
     * @param \think\App $app
     * @author 刘勤 <876771120@qq.com>
     */
    public function __construct(App $app){
        $this->app = $app;
    }
    /**
     * 处理请求
     *
     * @param tpRequest $request
     * @param \Closure $next
     * @return Response
     */
    public function handle(tpRequest $request, \Closure $next){
        
        $apiInfo = $request->API_CONF_DETAIL;
        if(!$apiInfo){
            $apiHash = $request->rule()->getRule();
            $cached = Cache::has('ApiInfo:' . $apiHash);
            if ($cached) {
                $apiInfo = Cache::get('ApiInfo:' . $apiHash);
            } else {
                $apiInfo = ApiList::where(['hash' => $apiHash])->find();
                $apiInfo = $apiInfo->toArray();
                Cache::set('ApiInfo:' . $apiHash, $apiInfo);
            }
        }
        $data = $request->param();
        $cached = Cache::has('RequestFields:NewRule:' . $apiInfo['hash']);
        if ($cached) {
            $newRule = cache('RequestFields:NewRule:' . $apiInfo['hash']);
        } else {
            $rule = json_decode($apiInfo['request'],true);
            $newRule = $this->buildValidateRule($rule);
            cache('RequestFields:NewRule:' . $apiInfo['hash'], $newRule);
        }
        if ($newRule) {
            try {
                validate()->rule($newRule)->check($data);
            } catch (ValidateException $e) {
                return json(['code' => ReturnCode::PARAM_INVALID, 'msg' => $e->getError(), 'data' => []]);
            }
        }
        return $next($request);
    }

    /**
     * 将数据库中的规则转换成TP_Validate使用的规则数组
     * @param array $rule
     * @return array
     * @author zhaoxiang <zhaoxiang051405@gmail.com>
     */
    public function buildValidateRule($rule = array()) {
        $newRule = [];
        if ($rule) {
            foreach ($rule as $value) {
                if ($value['require']) {
                    $newRule[$value['name'] . '|' . $value['remark']][] = 'require';
                }
                switch ($value['type']) {
                    case DataType::TYPE_INTEGER:
                        $newRule[$value['name'] . '|' . $value['remark']][] = 'number';
                        if (!isset($value['range'])) {
                            $range = htmlspecialchars_decode($value['range']);
                            $range = json_decode($range, true);
                            if (isset($range['min'])) {
                                $newRule[$value['name'] . '|' . $value['remark']]['egt'] = $range['min'];
                            }
                            if (isset($range['max'])) {
                                $newRule[$value['name'] . '|' . $value['remark']]['elt'] = $range['max'];
                            }
                        }
                        break;
                    case DataType::TYPE_STRING:
                        if (isset($value['range'])) {
                            $range = htmlspecialchars_decode($value['range']);
                            $range = json_decode($range, true);
                            if (isset($range['min'])) {
                                $newRule[$value['name'] . '|' . $value['remark']]['min'] = $range['min'];
                            }
                            if (isset($range['max'])) {
                                $newRule[$value['name'] . '|' . $value['remark']]['max'] = $range['max'];
                            }
                        }
                        break;
                    case DataType::TYPE_ENUM:
                        if (isset($value['range'])) {
                            $range = htmlspecialchars_decode($value['range']);
                            $range = json_decode($range, true);
                            $newRule[$value['name'] . '|' . $value['remark']]['in'] = $range;
                        }
                        break;
                    case DataType::TYPE_FLOAT:
                        $newRule[$value['name'] . '|' . $value['info']][] = 'float';
                        if (isset($value['range'])) {
                            $range = htmlspecialchars_decode($value['range']);
                            $range = json_decode($range, true);
                            if (isset($range['min'])) {
                                $newRule[$value['name'] . '|' . $value['info']]['egt'] = $range['min'];
                            }
                            if (isset($range['max'])) {
                                $newRule[$value['name'] . '|' . $value['info']]['elt'] = $range['max'];
                            }
                        }
                        break;
                    case DataType::TYPE_ARRAY:
                        $newRule[$value['name']][] = 'array';
                        if (isset($value['range'])) {
                            $range = htmlspecialchars_decode($value['range']);
                            $range = json_decode($range, true);
                            if (isset($range['min'])) {
                                $newRule[$value['name'] . '|' . $value['info']]['min'] = $range['min'];
                            }
                            if (isset($range['max'])) {
                                $newRule[$value['name'] . '|' . $value['info']]['max'] = $range['max'];
                            }
                        }
                        break;
                    case DataType::TYPE_MOBILE:
                        $newRule[$value['name'] . '|' . $value['info']]['regex'] = '/^1[3456789]\d{9}$/';
                        break;
                }
            }
        }
        return $newRule;
    }
}