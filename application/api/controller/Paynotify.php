<?php
/***
支付通知
***/
namespace app\api\controller;
use think\Db;
use services\WxPayService;
class Paynotify extends  Base
{

    /*********微信支付通知**********/
    public function wxPayNotify(){
        //获取通知的数据
        $xml = file_get_contents('php://input');
        $file = basename(__FILE__).'/wxPayNotify';
        write_log($xml,$file);
        if(!$xml){
            return 'FAIL';
        }
        $wxpay = new WxPayService();
        $retrun=$wxpay->wxNotify($xml);
        if(!$retrun) return 'FAIL';
        if($retrun['code'] == 1){
            write_log($retrun['code'].'========errror======='.$retrun['xml'],$file);
            return XML($retrun['xml']);
        }
        write_log("wxpaynotify=========SUCCESS111========",$file);
        //根据订单号更新状态
        $data  = $retrun['data'];
        $xml  = $retrun['xml'];
        $order_sn = $data['out_trade_no'];
        $transaction_id = $data['transaction_id'];
        $amount = $data['total_fee'] * 0.01;
        $ordersLogic = Controller('Orders', 'logic');
        $res = $ordersLogic->updatePayOrder(['order_sn'=>$order_sn,'transaction_id'=>$transaction_id,'amount'=>$amount]);
        if(isset($res['ErrorCode']) && $res['ErrorCode'] == 1){
            $data['return_code']='FAIL';
            $data['return_msg']=$res['ErrorMsg'];
            write_log("wxpaynotify=========error==".$res['ErrorMsg']."========",$file);
            $xml=$wxpay->replyNotify($data);
            return XML($xml);
        }
        if(isset($res['ErrorCode']) && $res['ErrorCode'] == 2){
            $data['return_code']='SUCCESS';
            $data['return_msg']=$res['ErrorMsg'];
            write_log("wxpaynotify=========error==".$res['ErrorMsg']."========",$file);
            $xml=$wxpay->replyNotify($data);
            return XML($xml);
        }
         write_log("wxpaynotify=========SUCCESS2222========",$file);
        return XML($xml);
    }

}
