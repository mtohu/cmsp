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
 * 统一支付接口类
 */
class UnifiedOrder_pub extends Wxpay_client_pub
{
    var $wechat_appid;
    var $wechat_mchid;
    function __construct($config=array())
    {
        parent::__construct($config);
        //设置接口链接
        $this->url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        //设置curl超时时间
        // $this->curl_timeout = WxPayConf_pub::CURL_TIMEOUT;
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
            //检测必填参数
            if($this->parameters["out_trade_no"] == null)
            {
                throw new SDKRuntimeException("缺少统一支付接口必填参数out_trade_no！"."<br>");
            }elseif($this->parameters["body"] == null){
                throw new SDKRuntimeException("缺少统一支付接口必填参数body！"."<br>");
            }elseif ($this->parameters["total_fee"] == null ) {
                throw new SDKRuntimeException("缺少统一支付接口必填参数total_fee！"."<br>");
            }elseif ($this->parameters["notify_url"] == null) {
                throw new SDKRuntimeException("缺少统一支付接口必填参数notify_url！"."<br>");
            }elseif ($this->parameters["trade_type"] == null) {
                throw new SDKRuntimeException("缺少统一支付接口必填参数trade_type！"."<br>");
            }elseif ($this->parameters["trade_type"] == "JSAPI" &&
                $this->parameters["openid"] == NULL){
                throw new SDKRuntimeException("统一支付接口中，缺少必填参数openid！trade_type为JSAPI时，openid为必填参数！"."<br>");
            }
            $this->parameters["appid"] = $this->wechat_appid;//公众账号ID
            $this->parameters["mch_id"] = $this->wechat_mchid;//商户号
            $this->parameters["spbill_create_ip"] = $_SERVER['REMOTE_ADDR'];//终端ip
            $this->parameters["nonce_str"] = $this->createNoncestr();//随机字符串
            $this->parameters["sign"] = $this->getSign($this->parameters);//签名
            return  $this->arrayToXml($this->parameters);
        }catch (SDKRuntimeException $e)
        {
            die($e->errorMessage());
        }
    }

    /**
     * 获取prepay_id
     */
    function getPrepayId()
    {
        $this->postXml();
        $this->result = $this->xmlToArray($this->response);
        $prepay_id = isset($this->result["prepay_id"]) ? $this->result["prepay_id"] : false ;
        return $prepay_id;
    }

}
