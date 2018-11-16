<?php
/**
 * Created by PhpStorm.
 * Power By Mikkle
 * Email：776329498@qq.com
 * Date: 2017/8/30
 * Time: 9:21
 */
namespace vendor\tp_wxpay;
use think\facade\Config;
/**
 * 请求商家获取商品信息接口
 */
class NativeCall_pub extends Wxpay_server_pub
{
    /**
     * 生成接口参数xml
     */
    function createXml($config=[])
    {
        
        if($this->returnParameters["return_code"] == "SUCCESS"){
            $this->returnParameters["appid"] = isset($config['wechat_appid'])?$config['wechat_appid']:Config::get('wxpay.wechat_appid');//公众账号ID
            $this->returnParameters["mch_id"] = isset($config['wechat_mchid'])?$config['wechat_mchid']:Config::get('wxpay.wechat_mchid');//商户号
            $this->returnParameters["nonce_str"] = $this->createNoncestr();//随机字符串
            $this->returnParameters["sign"] = $this->getSign($this->returnParameters);//签名
        }
        return $this->arrayToXml($this->returnParameters);
    }

    /**
     * 获取product_id
     */
    function getProductId()
    {
        $product_id = $this->data["product_id"];
        return $product_id;
    }

}

