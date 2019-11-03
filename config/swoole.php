<?php
// +----------------------------------------------------------------------
// | Trace设置 开启调试模式后有效
// +----------------------------------------------------------------------

use think\facade\Env;
return [
    "server"=>[
        "host"=>'0.0.0.0',
        "port"=>'80',
        "options"=>[]
    ],
    "hot_update"=>[
        "enable" => Env::get("APP_DEBUG",false),
        "name"=>['*.php','*.html'],
        "include"=>[app_path()]
    ]
];
