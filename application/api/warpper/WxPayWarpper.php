<?php
namespace app\api\warpper;
use app\api\warpper\interfaces\IPay;
use services\WxPayService;
use errors\ErrorException;
class WxPayWarpper implements IPay
{
    protected $wxpay;
    public function __construct($option=array())
    {
        $this->wxpay = new WxPayService();
    }
    /*****微信支付****/
    public function do_pay($input)
    {
        $order_arr=['out_trade_no'=>$input['pay_sn'],'body'=>$input['fee_name'],'attach'=>'石祥物业',
            'total_fee'=>$input['amount'] * 100,'time_start'=>date("YmdHis"),
            'time_expire'=>date("YmdHis", time() + 600),
            'product_id'=>$input['fee_id'],'spbill_create_ip'=>get_ips()];
        $order_arr['trade_type']=$input['trade_type'];
        if($input['pay_scene'] == 'gzh' && $order_arr['trade_type']=='JSAPI'){
            $order_arr['trade_type']='JSAPI';
            $order_arr['openid'] =$input['sns_id'];
        }
        $json_str=$this->wxpay->unifiedOrder($order_arr);
        return $json_str;
    }
    /*****微信通知******/
    public function do_notify($input)
    {
        $xml = isset($input['xml'])?$input['xml']:"";
        $retrun=$this->wxpay->wxNotify($xml);
        if(!$retrun) return false;
        return $retrun;
    }
    /******回复通知********/
    public function replyNotify($input){
        return $this->wxpay->replyNotify($input);
    }
}
