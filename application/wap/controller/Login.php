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
    public function checkLoginVerifyCode()
    {
        $this->assign('head_title', '安全检测');
        return $this->fetch();
    }

    /**
     * 重置密码
     */
    public function resetPwd()
    {
        $this->assign('head_title', '重置密码');
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
        return $this->fetch();
    }

    /**
     * 注册时，设置密码
     */
    public function setRegisterPwd()
    {
        $this->assign('head_title', '账户设置');
        return $this->fetch();
    }

    /**
     * 设置注册信息
     */
    public function setRegisterInfo()
    {
        $this->assign('head_title', '绑定房产物业');
        return $this->fetch();
    }

    public function loginOut(){
        Session::clear();
        Cookie::delete('sxcmpauths');
        Cookie::clear();
        return $this->redirect('wap/index/center');
    }
}
