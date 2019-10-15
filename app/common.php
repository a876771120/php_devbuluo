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
// 找到最后一个数组当中的第一个元素的url
if(!function_exists('find_first_url')){
    /**
     * 找到URL数组中最后一个子元素
     * @param array $urlData 要查找的数组
     * @return string
     */
    function find_first_url($urlData=[]){
        // dump($urlData);die;
        $res = '';
        $thisData = $urlData['child'];
        $resUdata = array_shift($thisData);
        if(!empty($resUdata['child'])){
            $res = find_first_url($resUdata);
        }else{
            $res = $resUdata['url_value'];
        }
        return $res;
    }
}
