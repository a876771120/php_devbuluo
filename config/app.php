<?php
// +----------------------------------------------------------------------
// | 应用设置
// +----------------------------------------------------------------------

use think\facade\Env;

return [
    // 应用地址
    'app_host'         => Env::get('app.host', ''),
    // 应用的命名空间
    'app_namespace'    => '',
    // 是否启用路由
    'with_route'       => true,
    // 是否启用事件
    'with_event'       => true,
    // 默认应用
    'default_app'      => 'index',
    // 默认时区
    'default_timezone' => 'Asia/Shanghai',

    // 应用映射（自动多应用模式有效）
    'app_map'          => [],
    // 域名绑定（自动多应用模式有效）
    'domain_bind'      => [],
    // 禁止URL访问的应用列表（自动多应用模式有效）
    'deny_app_list'    => [],

    // 异常页面的模板文件
    'exception_tmpl'   => app()->getThinkPath() . 'tpl/think_exception.tpl',

    // 错误显示信息,非调试模式有效
    'error_message'    => '页面错误！请稍后再试～',
    // 显示错误信息
    'show_error_msg'   => false,


    
    // 开发新增配置
    // 后台访问文件
    'admin_entrance_file'=>'admin.php',
    // 后台模板布局路径
    'admin_layout_path'=>app()->getBasePath().'admin/view/layout.html',
    // 错误提示模板
    'admin_error_template'=>app()->getBasePath().'admin/view/public/error.html',
    // 成功提示模板
    'admin_success_template'=>app()->getBasePath().'admin/view/public/success.html',
    // elasticsearch服务器配置
    'es_host' => [
        '49.235.160.203:9200' // ip和端口
    ],
];