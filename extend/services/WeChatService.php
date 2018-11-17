<?php
/**
 * Created by gary
 * User: EDZ
 */
namespace services;

require_once "../vendor/tp_wechat/Wechat.php";
use vendor\tp_wechat\Wechat;
use think\facade\Config;
class WeChatService{
    public $option=[];
    public function __construct($config=[]){
        $this->option=$config;
    }
    /**获取token**/
    public function getAccessToken($input){
        $oauth = Wechat::oauth($this->option);
        $code = isset($input['code'])?$input['code']:"";
        if(empty($code)) return false;
        $resToken = $oauth->getOauthAccessToken($code);
        if(!$resToken)return False;
        $resData=array();
        $resData['access_token']=$resToken['access_token'];
        $resData['refresh_token']=$resToken['refresh_token'];
        $resData['expires_in']=$resToken['expires_in'];
        $resData['openid']=$resToken['openid'];
        return $resData;
    }
    //获取微信信息
    public function getWeChatUserInfo($input){
        $oauth = Wechat::oauth($this->option);
        $access_token = isset($input['access_token'])?$input['access_token']:"";
        $openid       = isset($input['openid'])?$input['openid']:"";
        if(empty($access_token) || empty($openid)) return false;
        $userInfo     = $oauth->getOauthUserInfo($access_token,$openid);
        if(!isset($userInfo['openid'])) return false;
        return $userInfo;
    }
    /**刷新token**/
    public function refreshToken($input){
        $refresh_token = isset($input['refresh_token'])?$input['refresh_token']:"";
        if(empty($refresh_token)) return false;
        $oauth = Wechat::oauth($this->option);
        $refreshToken = $oauth->getOauthRefreshToken($refresh_token);
        if(!$refreshToken) return false;
        $resData=array();
        $resData['access_token']=$refreshToken['access_token'];
        $resData['refresh_token']=$refreshToken['refresh_token'];
        $resData['expires_in']=$refreshToken['expires_in'];
        $resData['openid']=$refreshToken['openid'];
        return $resData;
    }
    /*****获取JsApi签名******/
    public function getSignPackage($input){
        $url = $input['url'];
        $script = Wechat::script($this->option);
        $signpackage=$script->getJsSign($url);
        return $signpackage; 
    }

    /**获取信息模板列表**/
    public function getMsgTemplateList(){
        $message = Wechat::message($this->option);
        $data=$message->getAllPrivateTemplate();
        return $data;
    }
    /**发送模版消息**/
    public function sendTemplateMsg($input){
        $message = Wechat::message($this->option);
        $res=$message->sendTemplateMessage($input);
        return $res;
    }

}
