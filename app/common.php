<?php
// 应用公共文件
// 字符串命名风格转换
if(!function_exists('parseName')){
    /**
     * 字符串命名风格转换
     * type 0 将Java风格转换为C的风格 1 将C风格转换为Java的风格
     * @deprecated
     * @access public
     * @param string  $name    字符串
     * @param integer $type    转换类型
     * @param bool    $ucfirst 首字母是否大写（驼峰规则）
     * @return string
     */
    function parseName(string $name = null, int $type = 0, bool $ucfirst = true): string
    {
        if ($type) {
            $name = preg_replace_callback('/_([a-zA-Z])/', function ($match) {
                return strtoupper($match[1]);
            }, $name);
            return $ucfirst ? ucfirst($name) : lcfirst($name);
        }
        return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
    }
}
// 解析配置文件的方法
if (!function_exists('parse_attr')) {
    /**
     * 解析配置
     * @param string $value 配置值
     * @return array|string
     */
    function parse_attr($value = '') {
        $array = preg_split('/[,;\r\n]+/', trim($value, ",;\r\n"));
        if (strpos($value, ':')) {
            $value  = array();
            foreach ($array as $val) {
                list($k, $v) = explode(':', $val);
                $value[$k]   = $v;
            }
        } else {
            $value = $array;
        }
        return $value;
    }
}
// 生成后台url
if(function_exists('adminUrl')){
    /**
     * Url生成
     * @param string      $url    路由地址
     * @param array       $vars   变量
     * @param bool|string $suffix 生成的URL后缀
     * @param bool|string $domain 域名
     * @return String
     */
    function adminUrl(string $url = '', array $vars = [], $suffix = true, $domain = false){
        $url = (string)url($url, $vars, $suffix, $domain);
        if (defined('ADMIN') && ADMIN) {
            return $url;
        } else {
            return preg_replace('/\/index.php/', '/'.ADMIN_FILE, $url);
        }
    }
}

