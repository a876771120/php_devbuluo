<?php
// +----------------------------------------------------------------------
// | 应用设置
// +----------------------------------------------------------------------

use think\facade\Env;

return [
    //AccessToken失效时间
    'ACCESS_TOKEN_TIME_OUT' => 7200,
    //UserToken失效时间
    'USERTOKEN_TOKEN_TIME_OUT' => 7200,
    //跨域配置
    'CROSS'          => [
        'Access-Control-Allow-Origin'      => '*',
        'Access-Control-Allow-Methods'     => 'POST,PUT,GET,DELETE',
        'Access-Control-Allow-Headers'     => 'Api-Version, X-Auth-Access-Token, X-Auth-User-Token, User-Agent, Keep-Alive, Origin, No-Cache, X-Requested-With, If-Modified-Since, Pragma, Last-Modified, Cache-Control, Expires, Content-Type, X-E4M-With',
        'Access-Control-Allow-Credentials' => 'true'
    ]
];