<?php
namespace app\wap\controller;

use think\Controller;
use think\facade\Session;

class Login extends Controller {
    public function initialize(){
        parent::initialize();
    }

    public function residentLogin(){
        return $this->fetch();
    }

    /**
     * 账号密码登录
     */
    public function pwdLogin()
    {
        $this->assign('head_title', '账户登录');
        return $this->fetch();
    }

    /**
     * 找回密码
     */
    public function findPwd()
    {
        $this->assign('head_title', '找回密码');
        return $this->fetch();
    }

    /**
     * 检验登录验证码
     */
    public function checkFindPwdVerifyCode()
    {
        $this->assign('head_title', '安全检测');
        $this->assign('phone', input('phone'));
        return $this->fetch();
    }

    /**
     * 重置密码
     */
    public function resetPwd()
    {
        $this->assign('head_title', '重置密码');
        $this->assign('phone', input('phone'));
        $this->assign('verify_code', input('verify_code'));
        return $this->fetch();
    }

    /**
     * 注册
     */
    public function register()
    {
        $this->assign('head_title', '免费注册');
        return $this->fetch();
    }

    /**
     * 检验登录验证码
     */
    public function checkRegisterVerifyCode()
    {
        $this->assign('head_title', '填写校验码');
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
        $this->assign('head_title', '账户设置');
        $this->assign('verify_code', input('verify_code'));
        $this->assign('phone', input('phone'));
        return $this->fetch();
    }

    /**
     * 设置注册信息
     */
    public function setRegisterInfo()
    {
        $this->assign('head_title', '完善信息');
        return $this->fetch();
    }

    public function loginOut(){
        Session::clear();
        Cookie::delete('sxcmpauths');
        Cookie::clear();
        return $this->redirect('wap/index/center');
    }
}
