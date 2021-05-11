<?php
namespace app\wap\controller;

use think\Controller;
use think\facade\Cookie;
use think\facade\Session;

class Login extends Controller {
    public function initialize(){
        parent::initialize();
    }

    /**
     * 登录页
     */
    public function residentLogin()
    {
        return $this->fetch();
    }

    /**
     * 微信登录
     */
    public function wechatLogin()
    {
        $user_agent=$this->request->header('user-agent');
        if(strpos($user_agent, 'MicroMessenger') === false){
            $error_msg="<h1>请使用微信扫码</h1>";
            return response()->data($error_msg)->code(200)->header(['Content-Type' =>'text/html']);
        }
        Session::clear();
        Cookie::delete('sxcmpauths');
        Cookie::clear();
        $url = "http://www.g3-logistics.com:8081/wap/index/index";
        $url = urlencode($url);
        $url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxab0a577057dc9089&redirect_uri=".$url."&response_type=code&scope=snsapi_userinfo#wechat_redirect";
        return $this->redirect($url,301);
    }

    /**
     * 账号密码登录
     */
    public function pwdLogin()
    {
        $head = [
            'left_nav' => [
                'icon' => 'icon-fanhui',
                'url' => url('Index/index')
            ],
            'title' => '账户登录',
            'right_btn' => [
                'is_show' => false,
                'btn_name' => '',
                'url' => ''
            ]
        ];
        $this->assign('head', $head);
        return $this->fetch();
    }

    /**
     * 找回密码
     */
    public function findPwd()
    {
        $head = [
            'left_nav' => [
                'icon' => 'icon-fanhui',
                'url' => url('Index/index')
            ],
            'title' => '找回密码',
            'right_btn' => [
                'is_show' => false,
                'btn_name' => '',
                'url' => ''
            ]
        ];
        $this->assign('head', $head);
        return $this->fetch();
    }

    /**
     * 检验登录验证码
     */
    public function checkFindPwdVerifyCode()
    {
        $head = [
            'left_nav' => [
                'icon' => 'icon-fanhui',
                'url' => url('Index/index')
            ],
            'title' => '安全检测',
            'right_btn' => [
                'is_show' => false,
                'btn_name' => '',
                'url' => ''
            ]
        ];
        $this->assign('head', $head);
        $this->assign('phone', input('phone'));
        return $this->fetch();
    }

    /**
     * 重置密码
     */
    public function resetPwd()
    {
        $head = [
            'left_nav' => [
                'icon' => 'icon-fanhui',
                'url' => url('Index/index')
            ],
            'title' => '重置密码',
            'right_btn' => [
                'is_show' => false,
                'btn_name' => '',
                'url' => ''
            ]
        ];
        $this->assign('head', $head);
        $this->assign('phone', input('phone'));
        $this->assign('verify_code', input('verify_code'));
        return $this->fetch();
    }

    /**
     * 注册
     */
    public function register()
    {
        $head = [
            'left_nav' => [
                'icon' => 'icon-fanhui',
                'url' => url('Index/index')
            ],
            'title' => '免费注册',
            'right_btn' => [
                'is_show' => false,
                'btn_name' => '',
                'url' => ''
            ]
        ];
        $this->assign('head', $head);
        return $this->fetch();
    }

    /**
     * 检验登录验证码
     */
    public function checkRegisterVerifyCode()
    {
        $head = [
            'left_nav' => [
                'icon' => 'icon-fanhui',
                'url' => url('Login/register')
            ],
            'title' => '填写校验码',
            'right_btn' => [
                'is_show' => false,
                'btn_name' => '',
                'url' => ''
            ]
        ];
        $this->assign('head', $head);
        $phone = input('phone');
        $this->assign('phone', $phone);
        $this->assign('hide_phone', '*******' . substr($phone, -4));
        return $this->fetch();
    }

    /**
     * 注册时，设置密码
     */
    public function setRegisterPwd()
    {
        $head = [
            'left_nav' => [
                'icon' => 'icon-fanhui',
                'url' => url('Index/index')
            ],
            'title' => '账户设置',
            'right_btn' => [
                'is_show' => false,
                'btn_name' => '',
                'url' => ''
            ]
        ];
        $this->assign('head', $head);
        $this->assign('verify_code', input('verify_code'));
        $this->assign('phone', input('phone'));
        return $this->fetch();
    }

    /**
     * 设置注册信息
     */
    public function setRegisterInfo()
    {
        $head = [
            'left_nav' => [
                'icon' => 'icon-fanhui',
                'url' => url('Index/index')
            ],
            'title' => '完善信息',
            'right_btn' => [
                'is_show' => false,
                'btn_name' => '',
                'url' => ''
            ]
        ];
        $this->assign('head', $head);
        //获取房间数据
        $regions = \app\wap\logic\Room::getRegions();
        $buildings = $buildings = \app\wap\logic\Room::getBuildings($regions[0]);
        $units = \app\wap\logic\Room::getUnits($regions[0], $buildings[0]);
        $rooms = \app\wap\logic\Room::getRooms($regions[0], $buildings[0], $units[0]);

        $this->assign('regions', $regions);
        $this->assign('buildings', $buildings);
        $this->assign('units', $units);
        $this->assign('rooms', $rooms);
        return $this->fetch();
    }

    public function loginOut(){
        Session::clear();
        Cookie::delete('sxcmpauths');
        Cookie::clear();
        return $this->redirect('wap/index/index');
    }
}
