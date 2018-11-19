<?php
namespace app\api\warpper;
use app\api\warpper\abstracts\ThirdLogin;
use services\WeChatService;
use errors\ErrorException;
class WeixinLoginWarpper extends ThirdLogin
{
    protected $wechatService;
    public function __construct($input)
    {
        $option = isset($input['option'])?$input['option']:[];
        $this->wechatService = new WeChatService($option);
    }
    /****微信公众号登录*****/
    public function doLogin($input)
    {
        $option = isset($input['option'])?$input['option']:[];
        $code   = isset($input['code'])?$input['code']:"";
        if(empty($code)){
            throw new ErrorException('code 不能为空 ');
        }
        $tokenArr = $this->wechatService->getAccessToken(["code"=>$code]);
        if(!isset($tokenArr['openid'])){
            throw new ErrorException('获取微信令牌失败 ');
        }
        return $tokenArr;
    }
    /*****获取微信用户信息*******/
    public function getUserInfo($input)
    {
        $access_token = isset($input['access_token'])?$input['access_token']:"";
        $openid = isset($input['openid'])?$input['openid']:"";
        $input_wechat = ['access_token'=>$access_token,'openid'=>$openid];
        $userInfo = $this->wechatService->getWeChatUserInfo($input_wechat);
        if (!isset($userInfo["openid"])) {
            throw new ErrorException('获取微信用户信息失败 ');
        }
        return $userInfo;
    }
}

