<?php
namespace app\wap\controller;
use think\facade\Cookie;
use think\facade\Session;
use think\facade\Request;
use think\facade\Url;
class RequestApi extends Base{
    public function initialize(){
        parent::initialize();
    }
    public function request_ajax(){
        $ACUUID  = isset($_SERVER["HTTP_ACUUID"])?$_SERVER["HTTP_ACUUID"]:"";
        $ACPHONE = isset($_SERVER["HTTP_ACPHONE"])?$_SERVER["HTTP_ACPHONE"]:"";
        $ACMODEL = isset($_SERVER["HTTP_ACMODEL"])?$_SERVER["HTTP_ACMODEL"]:"";
        $ACTIME  = isset($_SERVER["HTTP_ACTIME"])?$_SERVER["HTTP_ACTIME"]:"";
        $headers=array("ACUUID"=>$ACUUID,"ACPHONE"=>$ACPHONE,"ACMODEL"=>$ACMODEL,"ACTIME"=>$ACTIME);
        unset($this->params["api_action"]);
        $strJson = request_data($this->api_url.$this->api_action,$this->params,$headers);
        $data = json_decode($strJson,1);
        if(!is_array($data) || count($data)<=0){
            return $this->print_result(['ErrorCode'=>4,'ErrorMsg'=>'网络请求超时']);
        }
        if(in_array(intval($data["ErrorCode"]),[0,2])){
            switch($this->api_action){
                case "resident_login":
                $this->loginsn($data);
                break;
                case "register_resient":
                $this->loginsn($data);
                break;
                case "resident_logout":
                $this->logoutsn($data);
                break;
                case "resident_user":
                $udata = $data["Data"];
                $udata["token"] = $this->params["token"];
                if(isset($udata['id'])){
                    $this->ResidentAccount['ResidentID']=$udata['resident_id'];
                    $this->ResidentAccount['AccountName']=$udata['account_name'];
                    $this->ResidentAccount['ResidentName']=$udata['resident_name'];
                    $this->ResidentAccount['Token']=$udata['token'];
                    Session::set('ResidentAccount',$this->ResidentAccount);
                }
                break;
            }
        }
        if(intval($data["ErrorCode"]) == 5 || intval($data["ErrorCode"]) == 401){
            $this->logoutsn($data);
            $data['Data']['third_code'] = $this->third_code;
        }
        return $this->print_result($data);
    }
    private function loginsn($input){
        $data =array();
        if(isset($input['Data']['resident_id'])){
            $data['ResidentID'] = $input['Data']['resident_id'];
        }
        if(isset($input['Data']['account_name'])){
            $data['AccountName'] = $input['Data']['account_name'];
        }
        if(isset($input['Data']['resident_name'])){
            $data['ResidentName'] = $input['Data']['resident_name'];
        }
        if(isset($input['Data']['token'])){
            $data['Token'] = $input['Data']['token'];
        }
        $this->ResidentAccount=$data;
        Session::set('ResidentAccount',$this->ResidentAccount);
        $strCookie=$this->ResidentAccount['ResidentID']."\t".$this->ResidentAccount['AccountName']."\t".
                   $this->ResidentAccount['ResidentName']."\t".
                   $this->ResidentAccount["Token"];
        $encode=uc_authcode($strCookie,'ENCODE','sxcmp');
        Cookie::set('sxcmpauths',$encode,array('expire'=>3600*7));
    }
    private function logoutsn(){
        Session::clear();
        Cookie::delete('sxcmpauths');
        Cookie::clear();
    }
}
