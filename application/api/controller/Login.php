<?php
namespace app\api\controller;
use think\Controller;
class Login extends  Base
{
    //用户三方登陆
    public function thirdByResidentLogin($input)
    {
        $data = array();
        $data['code'] = isset($input['code'])?$input['code']:"";
        $data['sns_type'] = isset($input['sns_type'])?$input['sns_type']:0;
        $data['sub_domain'] = isset($input['sub_domain']) ? trim($input['sub_domain']): '';
        if (empty($data['sns_type'])) {
            $this->error_data['ErrorMsg'] = '参数错误';
            return $this->print_result($this->error_data);
        }
        $login = Controller('Login', 'logic');
        $res = $login->thirdByResidentLogin($data);
        return $this->print_result($res);
    }

    //帐号登录或绑定第三方帐号
    public function residentLogin($input)
    {
        $data = array();
        $data['user_name']     = isset($input['user_name'])?trim($input['user_name']):"";
        $data['password']      = isset($input['password'])?trim($input['password']):"";
        $data['login_mod']     = isset($input['login_mod'])?$input['login_mod']:0;//2=帐号加密码登录1=手机号加验证码登录
        $data['verify_code']   = isset($input['verify_code'])?$input['verify_code']:"";
        if (empty($data['user_name'])) {
            $this->error_data['ErrorMsg'] = '用户名或手机号不能为空';
            return $this->print_result($this->error_data);
        }
        if($data['login_mod'] == 2 && empty($data['password'])){
            $this->error_data['ErrorMsg'] = "密码不能为空";
            return $this->print_result($this->error_data);
        }
        $login = Controller('Login', 'logic');
        $res = $login->residentLogin($data);
        return $this->print_result($res);
    }
    /******注册用户********/
    public function registerResient($input){
        $data = array();
        $data['phone']         = isset($input['phone'])?trim($input['phone']):"";
        $data['user_name']     = isset($input['user_name'])?trim($input['user_name']):"";
        $data['password']      = isset($input['password'])?trim($input['password']):"";
        $data['cure_password']      = isset($input['cure_password'])?trim($input['cure_password']):"";
        $data['verify_code']   = isset($input['verify_code'])?$input['verify_code']:"";
        if (empty($data['user_name']) || empty($data['phone'])) {
            $this->error_data['ErrorMsg'] = '用户名或手机号不能为空';
            return $this->print_result($this->error_data);
        }
        if(empty($data['password']) || empty($data['cure_password']) ){
            $this->error_data['ErrorMsg'] = "密码不能为空";
            return $this->print_result($this->error_data);
        }
        if($data['password'] != $data['cure_password']){
            $this->error_data['ErrorMsg'] = "两个密码不一直";
            return $this->print_result($this->error_data);
        }
        $login = Controller('Login', 'logic');
        $res = $login->registerResient($data);
        return $this->print_result($res);
    }
    /******检查帐号用户名是否存在*******/
    public function checkAccountIsexit($input){
        $type = isset($input['type'])?intval($input['type']):0;//type 1=检查手机号2=检查用户名
        if(empty($input["user_name"]) || !$type){
            $this->error_data['ErrorMsg'] = "检查信息和检查类型不能为空";
            return $this->print_result($this->error_data);
        }
        $login = Controller('Login', 'logic');
        $res = $login->checkAccountIsexit($input);
        return $this->print_result($res);
    }

    /*******找回密码*******/
    public function findPwd($input){
        $data = array();
        $data['find_type']     = isset($input['find_type'])?intval($input['find_type']):1;//1=手机号找回
        $data['user_name']         = isset($input['user_name'])?trim($input['user_name']):"";
        $data['password']      = isset($input['password'])?trim($input['password']):"";
        $data['cure_password']      = isset($input['cure_password'])?trim($input['cure_password']):"";
        $data['verify_code']   = isset($input['verify_code'])?$input['verify_code']:"";
        if (empty($data['user_name'])) {
            $this->error_data['ErrorMsg'] = '手机号不能为空';
            return $this->print_result($this->error_data);
        }
        if(empty($data['password']) || empty($data['cure_password'])){
            $this->error_data['ErrorMsg'] = "密码不能为空";
            return $this->print_result($this->error_data);
        }
        if($data['password'] != $data['cure_password']){
            $this->error_data['ErrorMsg'] = "两个密码不一直";
            return $this->print_result($this->error_data);
        }
        $login = Controller('Login', 'logic');
        $res = $login->findPwd($data);
        return $this->print_result($res);
    }

    /**
     * @param $input
     * @return mixed  退出
     */
    public function residentLogout($input){
        $data = array();
        $data['resident_id'] = isset($input['token_resident_id']) ? $input['token_resident_id'] : 0;
        if (empty($data['resident_id'])) {
            $this->error_data['ErrorMsg'] = '参数错误';
            return $this->print_result($this->error_data);
        }
        $login = Controller('Login', 'logic');
        $res = $login->residentLogout($data);
        return $this->print_result($res);
    }
}
