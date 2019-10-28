<?php
// 中间件配置
return [
    // 别名或分组
    'alias' => [
        'ApiAuth'  => app\api\middleware\Auth::class,//权限认证
        'ApiPermission' => app\api\middleware\Permission::class,//应用是否有该api的权限
        'ApiRequest'=>app\api\middleware\Request::class,//请求参数过滤
        'ApiLog'=>app\api\middleware\Log::class,
    ],
    // 优先级设置，此数组中的中间件会按照数组中的顺序优先执行
    'priority' => [],
];
