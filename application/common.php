<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
//用户的密码加密
function get_resident_pwd($str){
    return md5('sxcmp'.$str);
}
/**
生成支付订单编号
ws 特殊字符 比如的订单标示符
no 序号
 **/
function create_pay_order_no($ws='p',$no=0){
    $num = 100000+$no;
    if(strlen($num) > 6){
        $s = strlen($num)-6;
        $num = substr($num,$s,strlen($num));
    }
    $rand = rand(10, 99);
    $dates=date('ymd');
    $sn = $ws.$dates.$num.$rand;
    return $sn;
}

/**加解密**/
function uc_authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    $ckey_length = 4;
    $key = md5($key ? $key : 'sxcmp');
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if($operation == 'DECODE') {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc.str_replace('=', '', base64_encode($result));
    }
}

function safe_array_entry($array, $key, $default=NULL, $unset = FALSE){
    if (($array == null) || ($key === null) || !is_array($array)) {
        return $default;
    }
    if(isset($array[$key])) {
        $value = $array[$key];
        if ($unset === FALSE) {
            unset($array[$key]);
        }
        if($value == 0)
            return strval($value);

        return $value;
    }
    return $default;
}

function copy_partial_array($array_src, $keys, $ignoreNull=FALSE, $default=null){
    if(!is_legal_array($array_src) || !is_legal_array($keys)) {
        //illegal parameters
        return array();
    }
    $result_array = array();
    foreach($keys as $key=>$val) {
        $value = safe_array_entry($array_src, $key);
        if ($value === NULL) {
            if($ignoreNull) {
                continue;
            } else {
                $value = $default;
            }
        }
        if(isset($val['type'])){
            switch($val['type']){
                case 'string':
                    $value = trim($value);
                    break;
                case 'int':
                    $value = intval($value);
                    break;
                case 'double':
                    $value = doubleval($value);
                    break;
            }
        }
        $result_array[$key] = $value;
    }
    return $result_array;
}


function is_legal_array($var){
    if (is_array($var) && count($var) >0) {
        return TRUE;
    }
    return FALSE;
}
function is_legal_string($var){
    if (is_string($var) || is_numeric($var)) {
        $var = trim($var);
        if (strlen($var) >0) {
            return TRUE;
        }
    }
    return FALSE;
}

function get_img_content($pic_str){
    $pic_str=substr($pic_str,strpos($pic_str,'base64,')+7);
    $img=base64_decode($pic_str);
    return $img;
}

/**请求时间**/
function now_time(){
    return $_SERVER['REQUEST_TIME'];
}

function get_newpic_url($str){
    if(is_array($str)){
        $arr=array();
        foreach($str as $item){
            //$arr[]="http://oss.yidexcx.com/".$item;
            $arr[]="http://oss.ourhonour.com/".$item;
        }
        $str=$arr;
    }else{
        if(!empty($str)){
            //$str="http://oss.yidexcx.com/".$str;
            $str="http://oss.ourhonour.com/".$str;
        }
    }
    return $str;
}

/*****身份证号验证****/
function checkIdCard($idcard)
{
    if(strlen($idcard) == 15){
        $sBirthday = '19'.substr($idcard,6,2).'-'.substr($idcard,8,2).'-'.substr($idcard,10,2);
        $d = abs(strtotime($sBirthday));
        if($d <=0) return false;
        if (array_search(substr($idcard, 12, 3), array('996', '997', '998', '999')) !== false){
            $idcard = substr($idcard, 0, 6) . '18'. substr($idcard, 6, 9);
        }else{
            $idcard = substr($idcard, 0, 6) . '19'. substr($idcard, 6, 9);
        }
        $year = substr($idcard,6,4);
        if($year<1900 || $year>2078) return false;
        return true ;
    }
    $idcard = strtoUpper($idcard);
    // 只能是18位
    if (strlen($idcard) != 18) {
        return false;
    }
    // 取出本体码
    $idcard_base = substr($idcard, 0, 17);
    // 取出校验码
    $verify_code = substr($idcard, 17, 1);
    // 加权因子
    $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
    // 校验码对应值
    $verify_code_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
    // 根据前17位计算校验码
    $total = 0;
    for ($i = 0; $i < 17; $i++) {
        $total += substr($idcard_base, $i, 1) * $factor[$i];
    }
    // 取模
    $mod = $total % 11;
    // 比较校验码
    if ($verify_code !== $verify_code_list[$mod])
        return false;

    return true;
}

//写日志
function write_log($log,$file=''){
    $file=empty($file)?basename(__FILE__):$file;
    $str = "";
    $str.="\r\n";
    $str.="=========================================";
    $str.="\r\n";
    $str.="POST::".$file."  time:".date('Y-m-d H:i:s');
    $str.="\r\n";
    $str.=$log;
    $str.="\r\n";
    $str.="-----------------------------------------";
    $logurl=dirname(__FILE__)."/../logs/".date('Y-m-d').".log";
    $fp = @fopen($logurl, 'ab');
    @flock($fp, LOCK_EX);
    @fwrite($fp, $str);
    @flock($fp, LOCK_UN);
    @fclose($fp);
}

/**
 * 请求接口返回内容
 * @param  string $url [请求的URL地址]
 * @param  string $params [请求的参数]
 * @param  int $ipost [是否采用POST形式]
 * @return  string
 */
function juhecurl($url,$params=false,$ispost=0){
    $httpInfo = array();
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
    curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
    curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
    if( $ispost )
    {
        curl_setopt( $ch , CURLOPT_POST , true );
        curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
        curl_setopt( $ch , CURLOPT_URL , $url );
    }
    else
    {
        if($params){
            curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
        }else{
            curl_setopt( $ch , CURLOPT_URL , $url);
        }
    }
    $response = curl_exec( $ch );
    if ($response === FALSE) {
        //echo "cURL Error: " . curl_error($ch);
        return false;
    }
    $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
    $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
    curl_close( $ch );
    return $response;
}

function list_order(&$array, $orderKey, $orderType = 'asc', $orderValueType = 'string') {
    if (is_array($array)) {
        $orderArr = array();
        foreach ($array as $val) {
            $orderArr[] = $val[$orderKey];
        }
        $orderType = ($orderType == 'asc') ? SORT_ASC : SORT_DESC;
        $orderValueType = ($orderValueType == 'string') ? SORT_STRING : SORT_NUMERIC;
        array_multisort($orderArr, $orderType, $orderValueType, $array);
    }
    return TRUE;
}

function xmlToArrays($xml){
    //禁止引用外部xml实体
    libxml_disable_entity_loader(true);
    //将XML转为array
    $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    return $array_data;
}

function is_mobile()
{
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    }
    if (isset ($_SERVER['HTTP_VIA']))
    {
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
        );
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        }
    }
    if (isset ($_SERVER['HTTP_ACCEPT']))
    {
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        }
    }
    return false;
}


function get_ips()
{
    static $realip;
    if (isset($_SERVER)){
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $realip = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $realip = $_SERVER["REMOTE_ADDR"];
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR")){
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $realip = getenv("HTTP_CLIENT_IP");
        } else {
            $realip = getenv("REMOTE_ADDR");
        }
    }
    return $realip;
}
/*****房屋类型***/
function resident_type($n=0){
    $type = [1=>"房屋所有者",2=>"房屋所有者家人",3=>"租客"];
    if($n){
        return isset($type[$n])?$type[$n]:[];
    }
    return $type;
}
