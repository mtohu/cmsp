<?php
namespace app\api\controller;
use app\api\factory\PayFactory;
use think\Controller;
/**
 * Created by IntelliJ IDEA.
 * User: gary
 * Date: 2018/11/18
 * Time: 4:59 PM
 */
class Fee extends  Base
{
    /****获取自己的缴费记录列表*****/
    public function myFeeList($input){
        $input['resident_id'] = isset($input['token_resident_id']) ? $input['token_resident_id'] : 0;
        if(empty($input['resident_id'])){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "未登录无法获取信息";
            return $this->print_result($this->error_data);
        }
        $login = Controller('Fee', 'logic');
        $res = $login->myFeeList($input);
        return $this->print_result($res);

    }
    /*******支付订单生成*******/
    public function payOrder($input){
        $payOrderLogic = Controller('Payorder', 'logic');
        $res = $payOrderLogic->payOrder($input);
        if(isset($res['ErrorCode']) && $res['ErrorCode'] ==0){
            if($res['Data']['pay_nid'] == 'wxpay'){
                $json_str = $this->wxPay($res['Data']);
                $res['Data']=['jsapi_json_str'=>$json_str];
            }
        }
        return $this->print_result($res);
    }
    /******获取微信支付信息*****/
    private function wxPay($input){
        $resident_id = $input['resident_id'];
        $payObj=PayFactory::getInstance(['pay_mod'=>1]);
        if($input['pay_scene'] == 'gzh' && $input['trade_type']=='JSAPI'){
            $usersns=Db::name('cmp_resident_sns')->where([['sns_type','=',1],['resident_id','=',$resident_id]])->find();
            $input['sns_id'] = isset($usersns['sns_id'])?$usersns['sns_id']:'';
        }
        $json_str=$payObj->do_pay($input);
        return $json_str;
    }

}
