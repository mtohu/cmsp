<?php
namespace services;
use think\facade\Session;
/**
 * Created by IntelliJ IDEA.
 * User: gary
 * Date: 2018/11/17
 * Time: 11:22 AM
 */
class SmsService extends BaseService{
    /***发送短信***/
    public  function send_sms($input){
        $ins = $this->Instance($input);
        $phone = isset($input["phone"])?$input["phone"]:"";
        $type = isset($input["type"])?intval($input['type']):0;
        $sms_number = isset($input["sms_number"])?$input["sms_number"]:"";
        if(empty($phone)){
            $this->error_data['ErrorMsg']='请输入手机号码';
            return $this->error_data;
        }
        if(!preg_match("/^1[0-9]{10}$/i",$phone)){
            $this->error_data['ErrorMsg']='手机号格式不对';
            return $this->error_data;
        }
        $now_time = time();
        /*$strCode=Session::get('SMSCMP'.$phone);
        $CodeAr = explode("\t",$strCode);
        $sms_number=isset($CodeAr[0])?$CodeAr[0]:"";$ctime = isset($CodeAr[1])?abs($CodeAr[1]):0;
        if($now_time - $ctime <=100){
            $this->error_data['ErrorCode']=1;
            $this->error_data['ErrorMsg']='请等待上次发送时间100秒后再发送';
            return $this->error_data;
        }*/
        if(empty($sms_number)){
            $sms_number=rand(111111,999999);
        }
        $info=array('phone'=>$phone,'verify'=>$sms_number);
        if($type == 0 || $type == 1){
            $info['type']=1;
        }else{
            $info['type']=2;
        }
        $this->error_data['ErrorCode']=1;
        $this->error_data['ErrorMsg']="发送失败";
        $res_arr=$ins->send(['phone'=>$phone,'sms_number'=>$sms_number]);
        if(isset($res_arr['status']) && $res_arr['status'] == 1){
            //Session::set('SMSCMP'.$phone,$sms_number."\t".$now_time);
            $info['period']=$now_time+600;
            $this->error_data['ErrorCode']=0;
            $this->error_data['ErrorMsg']="发送成功";
        }
        $info['add_time']=$now_time;
        $this->error_data['Data']=$info;
        return $this->error_data;
    }
    public  function Instance($input){
        return new YunpianService();
    }
}
