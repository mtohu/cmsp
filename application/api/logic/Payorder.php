<?php
namespace app\api\logic;
use think\Db;
use errors\ErrorException;
use services\GeneratService;
/**
 * Created by IntelliJ IDEA.
 * User: gary
 * Date: 2018/11/19
 * Time: 3:08 PM
 */
class Payorder extends Base{

    /******支付订单生成*******/
    public function payOrder($input){
        $resident_id = isset($input['resident_id']) ? $input['resident_id']:0;
        $fee_id = isset($input['fee_id']) ? intval($input['fee_id']):0;
        $trade_type = isset($input['trade_type']) ? trim($input['trade_type']):"JSAPI";
        $pay_mod_id = isset($input['pay_mod_id']) ? intval($input['pay_mod_id']):1;
        $amount  = isset($input['amount']) ? doubleval($input['amount']):0;
        $discount_amount  = isset($input['discount_amount']) ? doubleval($input['discount_amount']):0;
        $jf_amount = $amount+$discount_amount;
        try{

            $now_time =now_time();
            Db::startTrans();
            $fee = Db::name("cmp_fee")->where('id',$fee_id)->lock(true)->find();
            if(!isset($fee['id'])){
                throw new ErrorException("缴费记录不存在");
            }
            if(intval($fee['payment_status']) == 1){
                throw new ErrorException("已经缴费请不要重复缴费");
            }
            if(bccomp($jf_amount,doubleval($fee['fee_amount']),2) != 0){
                throw new ErrorException("支付金额有问题");
            }
            $generatService = new GeneratService();
            $sn = $generatService->generat_add(['add_date'=>date('Ymd',$now_time),'add_time'=>$now_time]);
            if(!$sn){
                throw new ErrorException("生成支付订单编号失败");
            }
            $fee_item = Db::name("cmp_fee_item")->where([['id','=',$fee['fee_item_id']]])->find();
            $pay_sn = create_pay_order_no('p',$sn);
            $order_data=array('resident_id'=>$resident_id,'pay_mod_id'=>$pay_mod_id,'discount_amount'=>$discount_amount,
                'create_date'=>date('Y-m-d H:i:s',$now_time),'trade_type'=>$trade_type,'amount'=>$amount,'fee_id'=>$fee['id']);
            $order_data['pay_sn']=$pay_sn;
            $insert = Db::name('cmp_pay_order')->insertGetId($order_data);
            if(!$insert){
                throw new ErrorException("生成支付订单失败");
            }
            Db::commit();
        } catch (ErrorException $e) {
            Db::rollback();
            $this->error_data['ErrorMsg'] = $e->getMessage();
            return $this->error_data;
        }
        $this->error_data['ErrorMsg'] = "成功";
        $this->error_data['Data'] =['pay_sn'=>$order_data['pay_sn'],'amount'=>$amount,'discount_amount'=>$discount_amount,
            'fee_description'=>$fee['fee_description'],'fee_name'=>isset($fee_item['id'])?$fee_item['name']:"", 'fee_id'=>$fee['id'],'pay_mod_id'=>$pay_mod_id,
            'pay_nid'=>'wxpay','trade_type'=>$trade_type,
            'pay_scene'=>'gzh','resident_id'=>$resident_id];
        $this->error_data['ErrorCode']=0;
        return $this->error_data;
    }

    /*****更新支付订单*****/
    public function updatePayOrder($input){
        $pay_sn = isset($input['pay_sn']) ?trim($input['pay_sn']):'';
        $transaction_id = isset($input['transaction_id']) ? trim($input['transaction_id']):"";
        $amount = isset($input['amount']) ?doubleval($input['amount']):0;
        try{
            $now_time =now_time();
            Db::startTrans();
            $payOrder = Db::name('cmp_pay_order')->where('pay_sn',$pay_sn)->lock(true)->find();
            if(!isset($payOrder['id'])){
                throw new ErrorException("支付订单不存在");
            }
            if($payOrder['pay_state'] !=0){
                throw new ErrorException("支付订单已更新");
            }
            if(bccomp($amount,doubleval($payOrder['amount']),2) != 0){
                throw new ErrorException("支付金额不一致");
            }
            $update = Db::name('cmp_pay_order')->where('id',$payOrder['id'])
                ->data(['pay_state'=>1,'pay_time'=>$now_time,'transaction_id'=>$transaction_id,
                'update_date'=>date('Y-m-d H:i:s',$now_time),'pay_date'=>date('Y-m-d H:i:s',$now_time),
                 ])->update();
            if(!$update){
                throw new ErrorException("更新支付状态失败");
            }
            $update = Db::name('cmp_fee')->where('id',$payOrder['fee_id'])
                      ->data(['payment_status'=>1,'payment_date'=>date('Y-m-d H:i:s',$now_time),
                          'is_online_payment'=>1,'payment_method'=>1,'transaction_number'=>$transaction_id,
                          'actual_payment_amount'=>$payOrder['amount'],'resident_id'=>$payOrder['resident_id'],
                          'update_date'=>date('Y-m-d H:i:s',$now_time)])
                      ->update();
            if(!$update){
                throw new ErrorException("更新支付状态失败");
            }
            Db::commit();
        }catch (ErrorException $e){
            Db::rollback();
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = $e->getMessage();
            return $this->error_data;
        }
        $this->error_data['ErrorCode'] = 0;
        return $this->error_data;

    }

}
