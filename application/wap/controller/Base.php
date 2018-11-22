<?php
namespace app\wap\controller;
use think\Controller;
use think\facade\Cookie;
use think\facade\Session;
use think\facade\Url;
class Base extends Controller{
    public $action_no = array("resident_login","third_resident_login","register_resient");//这里填写不需要验证登录调的接口
    public $error_data=['ErrorCode'=>1,'ErrorMsg'=>'','ErrorSql'=>'','Data'=>[]];
    public $nopage=array("cmplogin","cmpsuccess","loginout");//这里填写不需要验证登录能打开的页面
    public $ResidentAccount=[];
    public $params=[];
    public $api_action="";
    public $api_url="http://001.pt-job1.com/api/";//请求接口地址
    public $controller_name="";
    public $action_name="";
    public $third_code="";
    public function initialize(){
        //Session::clear();
        //Cookie::delete('sxcmpauths');
        //Cookie::clear();
        $this->controller_name=strtolower($this->request->controller());
        $this->action_name=strtolower($this->request->action());
        $this->params=$this->request->post();
        $this->api_action=isset($this->params["api_action"])?strval(trim($this->params["api_action"])):"";
        $this->third_code = isset($_GET['code'])?$_GET['code']:"";
        if(!Session::has('ResidentAccount.ResidentID')){
            $cookievalue=Cookie::get('sxcmpauths');
            if(strlen($cookievalue)>2){
                $destr=uc_authcode($cookievalue,'DECODE','sxcmp');
                list($ResidentID,$AccountName,$ResidentName,$Token) = explode("\t",$destr);
                if(intval($ResidentID) > 0){
                    $this->ResidentAccount['ResidentID']=$ResidentID;
                    $this->ResidentAccount['AccountName']=$AccountName;
                    $this->ResidentAccount['ResidentName']=$ResidentName;
                    $this->ResidentAccount['Token']=$Token;
                    Session::set('ResidentAccount',$this->ResidentAccount);
                    $strJson = request_data($this->api_url."resident_info",["token"=>$Token]);
                    $dataMsg = @json_decode($strJson,1);
                    $data = isset($dataMsg["Data"])?$dataMsg["Data"]:[];
                    $data["token"] = $Token;
                    if(isset($data['resident_id'])){
                        Session::set('ResidentAccount',$this->ResidentAccount);
                    }
                }
            }
        }
        if(Session::has('ResidentAccount.ResidentID')){
            $this->ResidentAccount=Session::get('ResidentAccount');
            if(empty($this->ResidentAccount["Token"])){
                Session::clear();
                Cookie::delete('sxcmpauths');
                Cookie::clear();
                if($this->request->isAjax()){
                    return $this->print_result(["ErrorCode"=>401,"ErrorMsg"=>"未授权"]);
                }else{
                    return $this->third_login();
                }
            }
            $this->params["token"] = $this->ResidentAccount["Token"];
        }else{
            if($this->action_name == 'request_ajax' && !in_array($this->api_action,$this->action_no)){
                if($this->request->isAjax()){
                    return $this->print_result(["ErrorCode"=>401,"ErrorMsg"=>"未授权"]);
                }else{
                    return $this->third_login();
                }
            }else if(!in_array($this->action_name,$this->nopage) && $this->action_name !== 'request_ajax'){
                if($this->request->isAjax()){
                    return $this->print_result(["ErrorCode"=>401,"ErrorMsg"=>"未授权"]);
                }else{
                    return $this->third_login();
                }
            }
        }
    }
    public function print_result($error_data){
        if(!is_array($error_data)){
            $error_data['ErrorCode']=1;
            $error_data['ErrorMsg']='输出信息不符合规范';
        }
        return json($error_data)->code(200)->header(['Content-Type' => 'application/json']);
    }
    //第三方登录调用接口
    public function third_login(){
        $sns_type=1;//微信授权
        $code = isset($_GET['code'])?$_GET['code']:"";
        if($sns_type == 1 && !empty($code)){
            $json_str=request_data($this->api_url."third_resident_login",["code"=>$code,"sns_type"=>1]);
        }
        //write_log($json_str);
        $json_arr = @json_decode($json_str,1);
        if(isset($json_arr["ErrorCode"]) && $json_arr["ErrorCode"]==0 && isset($json_arr["Data"]["Token"])){
            $this->ResidentAccount['ResidentID']=$json_arr["Data"]['resident_id'];
            $this->ResidentAccount['AccountName']=$json_arr["Data"]['account_name'];
            $this->ResidentAccount['ResidentName']=$json_arr["Data"]['resident_name'];
            $this->ResidentAccount['Token']=$json_arr["Data"]['token'];
            Session::set('ResidentAccount',$this->ResidentAccount);
            $strCookie= $this->ResidentAccount['ResidentID']."\t".$this->ResidentAccount['AccountName']."\t".
                        $this->ResidentAccount['ResidentName']."\t". $this->ResidentAccount["Token"];
            $encode=uc_authcode($strCookie,'ENCODE','sxcmp');
            Cookie::set('sxcmpauths',$encode,array('expire'=>3600*7));

            return $this->redirect('wap/index/index');
        }
        return $this->redirect('wap/login/residentLogin');
    }

    public function getToken()
    {
        $resident_account = Session::get('ResidentAccount');
        if(isset($resident_account['Token'])){
            return $resident_account['Token'];
        }
        return '';
    }

}
