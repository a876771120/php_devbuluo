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
// 获取客户端ip
if (!function_exists('get_client_ip')) {
    /**
     * 获取客户端IP地址
     * @param int $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @param bool $adv 是否进行高级模式获取（有可能被伪装）
     * @return mixed
     */
    function get_client_ip($type = 0, $adv = false) {
        $type       =  $type ? 1 : 0;
        static $ip  =   NULL;
        if ($ip !== NULL) return $ip[$type];
        if($adv){
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos    =   array_search('unknown',$arr);
                if(false !== $pos) unset($arr[$pos]);
                $ip     =   trim($arr[0]);
            }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip     =   $_SERVER['HTTP_CLIENT_IP'];
            }elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip     =   $_SERVER['REMOTE_ADDR'];
            }
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u",ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }
}
// 格式化联动数据
if (!function_exists('format_linkage')) {
    /**
     * 格式化联动数据
     * @param array $data 数据
     * 
     * @return array
     */
    function format_linkage($data = [])
    {
        $list = [];
        foreach ($data as $key => $value) {
            $list[] = [
                'key'   => $key,
                'value' => $value
            ];
        }
        return $list;
    }
}
if(!function_exists('data_build_token')){
    /**
     * 构建token
     * @param array $data 要构建的数据
     * @return void
     */
    function data_build_token($data = []){
        // 数据类型检测
        if(!is_array($data)){
            $data = (array)$data;
        }
        // 排序
        ksort($data);
        // url编码并生成query字符串
        $code = http_build_query($data);
        // 生成签名
        $sign = hash('sha256',$code);
        return $sign;
    }
}