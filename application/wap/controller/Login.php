<?php
namespace app\wap\controller;
use think\facade\Session;
class Login extends Base{
    public function initialize(){
        parent::initialize();
    }

    public function cmpLogin(){
    }
    public function loginOut(){
        Session::clear();
        Cookie::delete('sxcmpauths');
        Cookie::clear();
        return $this->redirect('wap/index/center');
    }
}
