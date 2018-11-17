<?php
namespace app\wap\controller;
use think\Controller;
use think\facade\Session;
class Login extends Controller {
    public function initialize(){
        parent::initialize();
    }

    public function cmpLogin(){
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
     * 检验验证码
     */
    public function checkVerifyCode()
    {
        $this->assign('head_title', '安全检测');
        return $this->fetch();
    }

    public function loginOut(){
        Session::clear();
        Cookie::delete('sxcmpauths');
        Cookie::clear();
        return $this->redirect('wap/index/center');
    }
}
