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
        return $this->fetch();
    }

    public function loginOut(){
        Session::clear();
        Cookie::delete('sxcmpauths');
        Cookie::clear();
        return $this->redirect('wap/index/index');
    }
}
