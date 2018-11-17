<?php
namespace app\api\controller;
use app\api\model\Verify;
use services\SmsService;
use think\Db;
class Publics extends Base
{

    /**短信发送**/
    public function smsSend($input){
        $phone = isset($input['phone']) ? trim(strval($input['phone'])) : '';
        $type  = isset($input['type'])?intval($input['type']):0;
        if (empty($phone)) {
            $this->error_data["ErrorMsg"] = '手机号码不能为空';
            return $this->print_result($this->error_data);
        }
        $now_time =now_time();$sms_number="";
        $verifyModel = new Verify();
        $smsService      = new SmsService();
        $verify = $verifyModel->where([['phone','=',$phone],['is_use','=',0],['type','=',$type]])->order("id","desc")->find();
        if(isset($verify['id'])){
            $periodtime = $verify['period'];
            $ctime = $verify['add_time'];
            if($now_time - $ctime <=100){
                $this->error_data['ErrorCode'] = 1;
                $this->error_data['ErrorMsg']  = "请等待上次发送时间100秒后再发送";
                return $this->error_data;
            }
            if($periodtime > $now_time){
                $sms_number=$verify['verify'];
            }
        }
        $returnData      = $smsService->send_sms(['phone' => $phone, 'type' => $type,'sms_number'=>$sms_number]);
        if (!isset($returnData["ErrorCode"]) || $returnData["ErrorCode"] == 1) {
            $this->error_data['ErrorCode'] = 1;
            if (!isset($returnData["ErrorCode"])) {
                $this->error_data['ErrorMsg'] = "发送失败";
            } else {
                $this->error_data['ErrorMsg'] = $returnData["ErrorMsg"];
            }
            return $this->print_result($this->error_data);
        }
        $data        = $returnData['Data'];

        $res         = $verifyModel->data($data)->save();
        if ($res === false || !$res) {
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg']  = "发送失败";
        } else {
            $this->error_data['ErrorCode'] = 0;
            $this->error_data['ErrorMsg']  = "发送成功";
        }
        return $this->print_result($this->error_data);
    }
    /******检查手机验证码是否正确******/
    public  function checkVerifyCode($input){
        $phone = isset($input['phone']) ? trim(strval($input['phone'])) : '';
        $verify_code  = isset($input['verify_code'])?trim($input['verify_code']):"";
        $type = isset($input['type']) ? intval($input['type']) :1;//1=注册2=找回密码
        if (empty($phone)) {
            $this->error_data["ErrorMsg"] = '手机号码不能为空';
            return $this->print_result($this->error_data);
        }
        if (empty($verify_code)) {
            $this->error_data["ErrorMsg"] = '验证码不能为空';
            return $this->print_result($this->error_data);
        }
        $verifyModel = new Verify();
        $verify = $verifyModel->where([['phone','=',$phone],['type','=',$type],['is_use','=',0]])->order("id","desc")->find();
        if(!isset($verify['id']) || (isset($verify['id']) && $verify['verify'] != $verify_code)){
            $this->error_data["ErrorMsg"] = '验证码不正确';
            return $this->print_result($this->error_data);
        }
        $this->error_data['ErrorCode'] = 0;
        return $this->print_result($this->error_data);
    }

}
