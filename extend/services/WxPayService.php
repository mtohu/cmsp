<?php
/**
 * Created by gary
 * User: EDZ
 */
namespace services;

require_once "../vendor/tp_wxpay/WxPayConf_pub.php";
require_once "../vendor/tp_wxpay/Common_util_pub.php";
require_once "../vendor/tp_wxpay/SDKRuntimeException.php";
require_once "../vendor/tp_wxpay/Wxpay_client_pub.php";
require_once "../vendor/tp_wxpay/UnifiedOrder_pub.php";
require_once "../vendor/tp_wxpay/JsApi_pub.php";
require_once "../vendor/tp_wxpay/ShortUrl_pub.php";
require_once "../vendor/tp_wxpay/OrderQuery_pub.php";
require_once "../vendor/tp_wxpay/Wxpay_server_pub.php";
require_once "../vendor/tp_wxpay/Refund_pub.php";
require_once "../vendor/tp_wxpay/RefundQuery_pub.php";
require_once "../vendor/tp_wxpay/DownloadBill_pub.php";
require_once "../vendor/tp_wxpay/NativeLink_pub.php";
require_once "../vendor/tp_wxpay/NativeCall_pub.php";
require_once "../vendor/tp_wxpay/Notify_pub.php";
use vendor\tp_wxpay\UnifiedOrder_pub;
use vendor\tp_wxpay\JsApi_pub;
use vendor\tp_wxpay\Notify_pub;
use \vendor\tp_wxpay\OrderQuery_pub;
use vendor\tp_wxpay\Refund_pub;
use vendor\tp_wxpay\RefundQuery_pub;
use think\facade\Config;
class WxPayService{
    public $option=[];
    public $notify_url="http://xcxapi.ourhonour.com/wxpaynotify.php";
    public function __construct($config=[]){
        $this->option=empty($config)?Config::pull('wxpay'):$config;
        if(isset($config['notify_url']))
            $this->notify_url=$config['notify_url'];
    }
    /*****下单****/
    public function unifiedOrder($input){
        if(!is_array($input)){
            return false;
        }
        try{
            $input['notify_url'] = $this->notify_url;
            $input['appid'] = $this->option['wechat_appid'];
            $input['mch_id'] = $this->option['wechat_mchid'];
            $unorder = new UnifiedOrder_pub($this->option);
            foreach($input as $k=>$v){
                $unorder->setParameter($k,$v);
            }
            $unorder->createXml();
            $prepay_id =$unorder->getPrepayId();
            if($input['trade_type'] == 'JSAPI'){
                $str=$this->jsApiPub(['prepay_id'=>$prepay_id]);
                $json_arr = json_decode($str,1);
                return $json_arr;
            }elseif($input['trade_type'] == 'NATIVE'){
                $result=$unorder->getResult();
                return $result;
            }
            return $prepay_id;
        }catch(vendor\tp_wechat\SDKRuntimeException $e){
            return false;
        }
        return false;
    }
    /******jsapi*******/
    public function jsApiPub($input){
        $jsapi = new JsApi_pub($this->option);
        $jsapi->setPrepayId($input['prepay_id']);
        $json_str = $jsapi->getParameters();
        return $json_str;
    }

    /****微信通知****/
    public function wxNotify($xml){
        if(!$xml) return false;
        $notify= new Notify_pub($this->option);
        $notify->saveData($xml);
        $values = $notify->getData();
	if(!isset($notify->data['return_code']) || $notify->data['return_code'] != 'SUCCESS'){
            $values['return_msg']='通知数据失败';
	    $xml=$this->replyNotify($values);
            return ['code'=>1,'xml'=>$xml];
	}
	$res=$notify->checkSign();
        if(!$res){
            $values['return_code']='FAIL';
            $values['return_msg']='签名比对错误';
	    $xml=$this->replyNotify($values);
            return ['code'=>1,'xml'=>$xml];
        }
        $return=$this->queryOrder($values);
        if($return['code'] == 1){
            $values['return_code']='FAIL';
            $values['return_msg']=$return['msg'];
	    $xml=$this->replyNotify($values);
            return ['code'=>1,'xml'=>$xml];
        }else{
            $values['return_code']='SUCCESS';
            $values['return_msg']='';
	    $xml=$this->replyNotify($values);
        }
        return ['code'=>0,'data'=>$values,'xml'=>$xml];


    }
    /******回复通知********/
    public function replyNotify($input){
        $notify= new Notify_pub($this->option);
        foreach($input as $k =>$v){
            $notify->setReturnParameter($k,$v);
        }
        $xml = $notify->returnXml();
        return $xml;
    }
    /******查单*******/
    public function queryOrder($input){
       if(!array_key_exists("transaction_id", $input)){
            return ['code'=>1,'msg'=>'输入参数不正确'];
       }
       $query = new OrderQuery_pub($this->option);
       $query->setParameter('transaction_id',$input['transaction_id']);
       $query->setParameter('out_trade_no',$input['out_trade_no']);
       $result = $query->getResult();
       if(array_key_exists("return_code", $result) && $result["return_code"] == "SUCCESS")
       {
	    return ['code'=>0,'msg'=>'成功','data'=>$result];
       }
       return ['code'=>1,'msg'=>'查询订单失败','result'=>$result];

    }
    /********申请退款*********/
    public function applyRefundOrder($input){
        if(!is_array($input)){
            return false;
        }
        try{
            //$input['notify_url'] = $this->notify_url;
            $input['appid'] = $this->option['wechat_appid'];
            $input['mch_id'] = $this->option['wechat_mchid'];
            $reorder = new Refund_pub($this->option);
            foreach($input as $k=>$v){
                $reorder->setParameter($k,$v);
            }
            $reorder->createXml();
            $result=$reorder->getResult();
            return $result;
        }catch(vendor\tp_wechat\SDKRuntimeException $e){
            return false;
        }
        return false;
    }
    /******查退款单*******/
    public function queryRefundOrder($input){
       if(!array_key_exists("transaction_id", $input)){
            return ['code'=>1,'msg'=>'输入参数不正确'];
       }
       $query = new RefundQuery_pub($this->option);
       $query->setParameter('transaction_id',$input['transaction_id']);
       $query->setParameter('out_trade_no',$input['out_trade_no']);
       $query->setParameter('out_refund_no',$input['out_refund_no']);
       $query->setParameter('refund_id',$input['refund_id']);
       $result = $query->getResult();
       if(array_key_exists("return_code", $result) && $result["return_code"] == "SUCCESS")
       {
            return ['code'=>0,'msg'=>'成功'];
       }
       return ['code'=>1,'msg'=>'查询订单失败'];
    }


}
