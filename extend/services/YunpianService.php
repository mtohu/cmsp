<?php
namespace services;
use errors\ErrorException;
use interfaces\ISms;
require_once "../vendor/Yunpian/YunpianAutoload.php";
class YunpianService extends BaseService implements ISms{
   public $key="6089fdc70d4e10dd12adbbda89b59459";
   public $sendUrl = 'http://v.juhe.cn/sms/send';
   public function __construct(){
   }
   public function send($input){
       $phone = isset($input['phone'])?$input['phone']:"";
       $sms_number = isset($input['sms_number'])?$input['sms_number']:0;
       $smsOperator = new \SmsOperator();
       $data['mobile'] = $phone;
       $data['text'] = '【乐闪派】您的验证码是'.$sms_number;
       try{
           $result = $smsOperator->single_send($data);
           $return = array();
           if(!$result->success){
               $return['status']=2;
               $return['error_msg']=$result->responseData['msg'].'|'.json_encode($result->responseData);
           }else{
               $return['status']=1;
           }
       }catch (ErrorException $e){
           $return['status']=2;
       }
       return $return;
   }
}
