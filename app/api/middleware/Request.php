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
use app\member\model\Member;
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
        if($request->isOptions()){
            return json(['code' => ReturnCode::SUCCESS, 'msg' => '检验成功哦', 'data' => []])->header(config('api.CROSS'));
        }
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
            $rule = json_decode($apiInfo['request']?:"",true);
            $newRule = $this->buildValidateRule($rule);
            cache('RequestFields:NewRule:' . $apiInfo['hash'], $newRule);
        }
        // 参数检测
        if ($newRule) {
            try {
                validate()->rule($newRule)->check($data);
            } catch (ValidateException $e) {
                return json(['code' => ReturnCode::PARAM_INVALID, 'msg' => $e->getError(), 'data' => []])->header(config('api.CROSS'));
            }
        }
        // 用户检验
        $userToken = $request->header('x-auth-user-token');
        // 续约token
        if($userToken){
            $authInfo = cache($userToken);
            if($authInfo){
                // 如果有记住我，继续缓存7天，否则缓存2个小时
                cache($userToken,$authInfo,$authInfo['rememberme']?(7*24*3600):(3600*2));
            }else{
                // 检测token是否被串改
                // 联合查询出最后一次登录信息
                $tokenInfo = json_decode(base64_decode($userToken),true);
                $where=[];
                $where[] = ['client_id','=',$tokenInfo['clientId']];//客户端编号
                $where[] = ['type','=',1];//登录日志
                $where[] = ['m.id','=',$tokenInfo['user_id']];//当前用户
                $user = Member::alias('m')->field('l.*,m.nickname,m.id as uid,m.avatar,mobile,l.create_time as last_login_time')
                ->join('CommonMemberLog l','m.id=l.user_id')->where($where)
                ->order('l.create_time desc')->find();
                $auth = array(
                    'uid'             => $user['uid'],
                    'avatar'          => $user['avatar'],
                    'client_id'       => $user['client_id'],
                    'rememberme'      => $user['rememberme'],
                    'mobile'          => $user['mobile'],
                    'nickname'        => $user['nickname'],
                    'last_login_time' => $user['last_login_time'],
                    'ip'   => $user['ip'],
                );
                $checkToken = data_build_token($user['client_id'].$user['mobile'].$user['uid'].$user['last_login_time']);
                if($tokenInfo['token']==$checkToken){
                    // 如果有记住我，继续缓存7天，否则缓存2个小时
                    cache($userToken,$auth,$auth['rememberme']?(7*24*3600):(3600*2));
                }else{
                    return json(['code'=>ReturnCode::EXCEPTION,'msg'=>'您当前的操作异常，服务器已经记录'])->header(config('api.CROSS'));
                }
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