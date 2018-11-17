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
        $smsService      = new SmsService();
        $returnData      = $smsService->send_sms(['phone' => $phone, 'type' => $type]);
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
        $verifyModel = new Verify();
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

}
