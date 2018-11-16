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
 * 退款查询接口
 */
class RefundQuery_pub extends Wxpay_client_pub
{

    var $wechat_appid;
    var $wechat_mchid;
    function __construct($config=array()) {
        //设置接口链接
        $this->url = "https://api.mch.weixin.qq.com/pay/refundquery";
        //设置curl超时时间
        $this->curl_timeout = WxPayConf_pub::CURL_TIMEOUT;
        $this->wechat_appid=isset($config['wechat_appid'])?$config['wechat_appid']:Config::get('wxpay.wechat_appid');
        $this->wechat_mchid=isset($config['wechat_mchid'])?$config['wechat_mchid']:Config::get('wxpay.wechat_mchid');
    }

    /**
     * 生成接口参数xml
     */
    function createXml()
    {
        try
        {
            if($this->parameters["out_refund_no"] == null &&
                $this->parameters["out_trade_no"] == null &&
                $this->parameters["transaction_id"] == null &&
                $this->parameters["refund_id "] == null)
            {
                throw new SDKRuntimeException("退款查询接口中，out_refund_no、out_trade_no、transaction_id、refund_id四个参数必填一个！"."<br>");
            }
            $this->parameters["appid"] = $this->wechat_appid;//公众账号ID
            $this->parameters["mch_id"] = $this->wechat_mchid;//商户号
            $this->parameters["nonce_str"] = $this->createNoncestr();//随机字符串
            $this->parameters["sign"] = $this->getSign($this->parameters);//签名
            return  $this->arrayToXml($this->parameters);
        }catch (SDKRuntimeException $e)
        {
            die($e->errorMessage());
        }
    }

    /**
     * 	作用：获取结果，使用证书通信
     */
    function getResult()
    {
        $this->postXmlSSL();
        $this->result = $this->xmlToArray($this->response);
        return $this->result;
    }

}
