<?php
namespace app\api\logic;
use services\WeChatService;
use think\Db;
use app\api\logic\Tokens;
use app\api\factory\ThirdLoginFactory;
use think\Request;
use think\Exception;
use think\facade\Cookie;
use think\facade\Session;
use errors\ErrorException;
class Login extends Base
{
    //三方登陆
    public function thirdByResidentLogin($input)
    {
        $code = isset($input['code']) ? $input['code'] : "";
        $sns_type = isset($input['sns_type']) ? intval($input['sns_type']): 0;
        $ip = request()->ip();
        $thirdLogin = ThirdLoginFactory::getInstance(['sns_type'=>$sns_type,'option'=>[]]);
        try {
            $tokenArr=$thirdLogin->doLogin(["code" => $code]);
            $userInfo=$thirdLogin->getUserInfo(["access_token"=>$tokenArr["access_token"],"openid"=>$tokenArr["openid"]]);
        }catch(ErrorException $e){
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = $e->getMessage();
            return $this->error_data;
        }
        if (!isset($userInfo["openid"])) {
            $this->error_data['ErrorCode'] = 1;
            $this->error_data['ErrorMsg'] = "登录失败";
            return $this->error_data;
        }
        $nicknames =isset($userInfo["nickname"])?$userInfo["nickname"]:"";
        $tmpNickname = json_encode($nicknames);
        $tmpNickname2 = preg_replace("#(\\\ud[0-9a-f]{3})#i","",$tmpNickname);
        $userInfo["nickname"] = json_decode($tmpNickname2);
        //write_log("=======wxuser----=".json_encode($userInfo));
        $openid = $userInfo['openid'];
        $resident_sns = Db::name('cmp_resident_sns')->where([['sns_id', '=', $openid], ['sns_type', '=', $sns_type]])->find();
        try{
            Db::startTrans();
            $expiresAt = now_time() + 7200;
            $token_data =array('expires_in'=>7200,'ip'=>$ip,'created_at'=>now_time(),'expiresAt'=>$expiresAt);
            $return_data=array();
            //如果存在三方信息账号，则刷新access_token
            if (isset($resident_sns['id'])) {
                $access_token = $tokenArr['access_token'];
                $res = Db::name('c')->where([['sns_id', '=', $openid], ['sns_type', '=', $sns_type]])
                       ->update(['access_token' => $access_token,'refresh_token'=>$tokenArr['refresh_token'],
                           'expires_in'=>$tokenArr['expires_in'],'update_time'=>now_time()]);
                $resident=Db::name('cmp_resident')->where('id',$resident_sns['resident_id'])->find();
                if(!isset($resident['id'])){
                    $this->error_data['ErrorMsg'] = "登录失败";
                    return $this->error_data;
                }
                $uppdate=Db::name('cmp_resident')->where('id',$resident_sns['resident_id'])
                         ->data(['login_time'=>now_time(),'last_time'=>$resident['login_time'],'login_num'=>intval($resident['login_num'])+1,
                                          'login_ip'=>$ip,'last_ip'=>$resident['login_ip'],'update_date'=>date('Y-m-d H:i:s',now_time())])->update();
                $token_data['resident_id']=$return_data['resident_id']=$resident['id'];
                $return_data['account_name']=$resident['account'];
                $return_data['resident_name']=$resident['name'];
            } else {
                $userdata = ['name'=>'','face_img'=>$userInfo['headimgurl'],'create_date'=>date('Y-m-d H:i:s',now_time()),
                           'login_time'=>now_time(),'login_ip'=>$ip,'login_num'=>1];
                $auser_insert=Db::name('cmp_resident')->insertGetId($userdata);
                if(!$auser_insert){
                    Db::rollback();
                    $this->error_data['ErrorMsg'] = "创建帐号失败";
                    return $this->error_data;
                }
                $sns_insert = Db::name('cmp_resident_sns')->insertGetId(['sns_type'=>$sns_type,'sns_id'=>$openid,'admin_uid'=>$auser_insert,
                             'access_token'=>$tokenArr['access_token'], 'refresh_token'=>$tokenArr['refresh_token'],
                             'expires_in'=>$tokenArr['expires_in'],'unionid'=>isset($userInfo['unionid'])?$userInfo['unionid']:'',
                             'add_time'=>now_time()]);
                if(!$sns_insert){
                    Db::rollback();
                    $this->error_data['ErrorMsg'] = "创建帐号关联失败";
                    return $this->error_data;
                }
                $token_data['resident_id']=$return_data['resident_id']=$auser_insert;
                $return_data['account_name']='';
                $return_data['resident_name']=$userdata['name'];
            }
            $token = Tokens::createResidentToken($token_data);
            $update = Db::name('cmp_resident')->where('id',$token_data['resident_id'])
                      ->data(['atoken'=>$token,'update_date'=>date('Y-m-d H:i:s',now_time())])->update();
            if(!$update || empty($token)){
                Db::rollback();
                $this->error_data['ErrorMsg'] = "登录失败,服务器繁忙";
                return $this->error_data;
            }
            $return_data['token']=$token;
            Db::commit();
        }catch(Exception $e){
            write_log("=======wxuser---errror----=".$e->getMessage());
            Db::rollback();
            $this->error_data['ErrorMsg'] = "服务器繁忙";
            return $this->error_data;
        }
        $this->error_data['ErrorCode'] = 0;
        $this->error_data['Data'] =$return_data;
        return $this->error_data;
    }

    //用户账号登陆
    public function residentLogin($input)
    {
        $user_name = isset($input['user_name']) ? trim($input['user_name']) : "";
        $password = isset($input['password']) ? trim($input['password']) : "";
        $login_mod  = isset($input['login_mod']) ? intval($input['login_mod']) : 0;  //1=手机号加验证码登录 2=帐号加密码登录
        $verify_code = isset($input['verify_code']) ? $input['verify_code'] :"";
        $password_code = get_resident_pwd($password);
        //判定登陆方式
        if($login_mod == 1) {
            $login_info = Db::name('cmp_resident')->where('phone', '=', $user_name)->find();
            if (!isset($login_info['id'])) {
                $this->error_data['ErrorMsg'] ="该手机号尚未注册,请重新扫码登录";
                return $this->error_data;
            }
            //验证码
            $verify_code_arr = Db::name('cmp_verify')->where([['phone','=', $user_name],['type','=',1]])->order('add_time','desc')->find();
            if(!isset($verify_code_arr['id'])){
                $this->error_data['ErrorMsg'] = "验证码错误";
                return $this->error_data;
            }
            if(isset($verify_code_arr['verify']) && ($verify_code_arr['period'] < now_time() || $verify_code_arr['is_use'] ==1)){
                $this->error_data['ErrorMsg'] = "验证码过期或验证码已被使用";
                return $this->error_data;
            }
            if(isset($verify_code_arr['verify']) && $verify_code != $verify_code_arr['verify']){
                $this->error_data['ErrorMsg'] = "验证码不正确";
                return $this->error_data;
            }
            $res=Db::name('cmp_verify')->where([['id','=',$verify_code_arr['id']]])->update(['is_use'=>1]);
            if(!$res){
                $this->error_data['ErrorMsg'] = "更新验证码状态错误";
                return $this->error_data;
            }
        }else{
            if (preg_match("/^1[3456789]\d{9}$/", $user_name)) {
                //phone,username
                $login_info = Db::name('cmp_resident')->where([['phone', '=', $user_name]])->find();
                if (!isset($login_info['id'])) {
                    $login_info = Db::name('cmp_resident')->where([['account', '=', $user_name]])->find();
                    if (!isset($login_info['id'])) {
                        $this->error_data['ErrorMsg'] = "用户名不存在，不是手机号也不是用户名";
                        return $this->error_data;
                    }
                    $login_info = Db::name('cmp_resident')->where([['account', '=', $user_name], ['password', '=', $password_code]])->find();
                    if (!isset($login_info['id'])) {
                        $this->error_data['ErrorMsg'] = "密码错误";
                        return $this->error_data;
                    }
                }
                $login_info = Db::name('cmp_resident')->where([['phone', '=', $user_name], ['password', '=', $password_code]])->find();
                if (!isset($login_info['id'])) {
                    $login_info = Db::name('cmp_resident')->where([['account', '=', $user_name], ['password', '=', $password_code]])->find();
                    if (!isset($login_info['id'])) {
                        $this->error_data['ErrorMsg'] = "密码错误";
                        return $this->error_data;
                    }
                }
            } else {
                $login_info = Db::name('cmp_resident')->where([['account', '=', $user_name]])->find();
                if (!isset($login_info['id'])) {
                    $this->error_data['ErrorMsg'] = "用户名不存在";
                    return $this->error_data;
                }
                $login_info = Db::name('cmp_resident')->where([['account', '=', $user_name], ['password', '=', $password_code]])->find();
                if (!isset($login_info['id'])) {
                    $this->error_data['ErrorCode'] = 1;
                    $this->error_data['ErrorMsg'] = "密码错误";
                    return $this->error_data;
                }
            }
        }
        if($login_info['is_black'] == 1){
            $this->error_data['ErrorMsg'] = "帐号被加入黑名单,请联系客服人员";
            return $this->error_data;
        }
        $expiresAt = now_time() + 3600 * 24 * 7;
        $token_data = [
            'expires_in' => 3600 * 24 * 7,
            'ip' => request()->ip(),
            'resident_id' => $login_info['id'],
            'created_at' => now_time(),
            'expiresAt' => $expiresAt
        ];
        $token = Tokens::createResidentToken($token_data);
        $returnData = array("resident_id" => $login_info['id'], "account_name" => $login_info['account'], "resident_name" => $login_info['name'],"token" => $token);
        $res = Db::name('cmp_resident')->where('id', $login_info['id'])->update(['login_time'=>now_time(),'last_time'=>$login_info['login_time'],
                     'login_num'=>intval($login_info['login_num'])+1,
                      'login_ip'=>request()->ip(),'last_ip'=>$login_info['login_ip'],'atoken'=>$token]);
        if (!$res) {
            $this->error_data['ErrorMsg'] = "更新失败";
            return $this->error_data;
        }
        $this->error_data['ErrorCode'] = 0;
        $this->error_data['Data'] = $returnData;
        return $this->error_data;
    }
    /*****注册用户******/
    public function registerResient($input){
        $phone         = isset($input['phone'])?trim($input['phone']):"";
        $user_name     = isset($input['user_name'])?trim($input['user_name']):"";
        $password      = isset($input['password'])?trim($input['password']):"";
        $verify_code   = isset($input['verify_code'])?$input['verify_code']:"";
        $password_code = get_resident_pwd($password);
        $ip = request()->ip();
        try{
            Db::startTrans();
            $rpuser = Db::name('cmp_resident')->where('phone', '=', $phone)->find();
            if(isset($rpuser['id'])){
                throw new ErrorException("手机号已经存在");
            }
            $rpuser = Db::name('cmp_resident')->where('account', '=', $user_name)->find();
            if(isset($rpuser['id'])){
                throw new ErrorException("用户名已经存在");
            }
            //验证码
            $verify_code_arr = Db::name('cmp_verify')->where([['phone','=', $phone],['type','=',1]])->order('id','desc')->find();
            if(!isset($verify_code_arr['id'])){
                throw new ErrorException("验证码错误");
            }
            if(isset($verify_code_arr['verify']) && ($verify_code_arr['period'] < now_time() || $verify_code_arr['is_use'] ==1)){
                throw new ErrorException("验证码过期或验证码已被使用");
            }
            if(isset($verify_code_arr['verify']) && $verify_code != $verify_code_arr['verify']){
                throw new ErrorException("验证码不正确");
            }
            $res=Db::name('cmp_verify')->where([['id','=',$verify_code_arr['id']]])->update(['is_use'=>1]);
            if(!$res){
                throw new ErrorException("更新验证码状态错误");
            }
            $inserData=array("phone"=>$phone,"account"=>$user_name,"password"=>$password_code,"login_time"=>now_time(),
                      "login_ip"=>$ip,'login_num'=>1,"create_date"=>date('Y-m-d H:i:s',now_time()));
            //echo "1111";exit;
            $rid = Db::name("cmp_resident")->insertGetId($inserData);
            if(!$rid){
                throw new ErrorException("注册失败");
            }
            $expiresAt = now_time() + 3600 * 24 * 7;
            $token_data = [
                'expires_in' => 3600 * 24 * 7,
                'ip' => $ip,
                'resident_id' => $rid,
                'created_at' => now_time(),
                'expiresAt' => $expiresAt
            ];
            $token = Tokens::createResidentToken($token_data);
            $returnData = array("resident_id" => $rid, "account_name" => $user_name, "resident_name" => "","token" => $token);
            $res = Db::name('cmp_resident')->where('id', $rid)
                   ->update(['update_date'=>date('Y-m-d H:i:s',now_time()),'atoken'=>$token]);
            if(!$res){
                throw new ErrorException("生成会话失败");
            }
            Db::commit();
        }catch (ErrorException $e){
            Db::rollback();
            $this->error_data['ErrorMsg'] = $e->getMessage();
            return $this->error_data;
        }
        $this->error_data['ErrorCode'] = 0;
        $this->error_data['Data'] = $returnData;
        return $this->error_data;
    }
    /*****检测用户名是否存在*****/
    public function checkAccountIsexit($input){
        $type = isset($input['type'])?intval($input['type']):0;//type 1=检查手机号2=检查用户名
        $user_name = trim($input["user_name"]);
        if($type == 1){
            $id = Db::name("cmp_resident")->where([["phone","=",$user_name]])->value("id");
        }else{
            $id = Db::name("cmp_resident")->where([["account","=",$user_name]])->value("id");
        }
        $id = intval($id);
        if($id){
            $this->error_data['ErrorCode'] = 1;
        }else{
            $this->error_data['ErrorCode'] = 0;
        }
        return $this->error_data;
    }
    public function findPwd($input){
        $user_name         = isset($input['user_name'])?trim($input['user_name']):"";
        $find_type     = isset($input['find_type'])?intval($input['find_type']):1;
        $password      = isset($input['password'])?trim($input['password']):"";
        $verify_code   = isset($input['verify_code'])?$input['verify_code']:"";
        $password_code = get_resident_pwd($password);
        $ip = request()->ip();
        try{
            Db::startTrans();
            $rpuser = Db::name('cmp_resident')->where('phone', '=', $user_name)->find();
            if(!isset($rpuser['id'])){
                throw new ErrorException("手机号不存在");
            }
            //验证码
            $verify_code_arr = Db::name('cmp_verify')->where([['phone','=', $user_name],['type','=',2]])->order('id','desc')->find();
            if(!isset($verify_code_arr['id'])){
                throw new ErrorException("验证码错误");
            }
            if(isset($verify_code_arr['verify']) && ($verify_code_arr['period'] < now_time() || $verify_code_arr['is_use'] ==1)){
                //throw new ErrorException("验证码过期或验证码已被使用");
            }
            if(isset($verify_code_arr['verify']) && $verify_code != $verify_code_arr['verify']){
                throw new ErrorException("验证码不正确");
            }
            $res=Db::name('cmp_verify')->where([['id','=',$verify_code_arr['id']]])->update(['is_use'=>1]);
            if(!$res){
                throw new ErrorException("更新验证码状态错误");
            }
            $expiresAt = now_time() + 3600 * 24 * 7;
            $token_data = [
                'expires_in' => 3600 * 24 * 7,
                'ip' => $ip,
                'resident_id' => $rpuser['id'],
                'created_at' => now_time(),
                'expiresAt' => $expiresAt
            ];
            $token = Tokens::createResidentToken($token_data);
            $returnData = array("resident_id" => $rpuser['id'], "account_name" => $rpuser['account'], "resident_name" => $rpuser['name'],"token" => $token);
            $res = Db::name('cmp_resident')->where('id', $rpuser['id'])
                ->update(['update_date'=>date('Y-m-d H:i:s',now_time()),'password'=>$password_code,'atoken'=>$token]);
            if(!$res){
                throw new ErrorException("生成会话失败");
            }
            Db::commit();
        }catch (ErrorException $e){
            Db::rollback();
            $this->error_data['ErrorMsg'] = $e->getMessage();
            return $this->error_data;
        }
        $this->error_data['ErrorCode'] = 0;
        $this->error_data['Data'] = $returnData;
        return $this->error_data;

    }
    /**
     *  退出
     */
    public function residentLogout($input){
        $resident_id = isset($input['resident_id']) ? $input['resident_id']:0;
        $data['atoken']='';$data['update_date']=date('Y-m-d H:i:s',now_time());
        $res = Db::name('cmp_resident')->where('id','=',$resident_id)->update($data);
        if (!$res){
            $this->error_data['ErrorMsg'] = "退出失败";
            return $this->error_data;
        }
        $this->error_data['ErrorCode'] = 0;
        $this->error_data['ErrorMsg'] = "退出成功";
        return $this->error_data;
    }
}

