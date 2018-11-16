<?php
namespace app\api\controller;
use think\Controller;
use think\facade\Cookie;
use think\facade\Session;
use think\facade\Url;
class Base extends Controller{
    public $error_data=['ErrorCode'=>1,'ErrorMsg'=>'','ErrorSql'=>'','Data'=>[]];
    public $AdminAccount=[];
    public function initialize(){
         $this->error_data['ServerTime']=time();
    }
    public function print_result($error_data){
        if(!is_array($error_data)){
            $error_data['ErrorCode']=1;
            $error_data['ErrorMsg']='输出信息不符合规范';
        }
        return json($error_data)->code(200)->header(['Content-Type' => 'application/json']);
    }

    /**
     * 检查必填项参数是否为空
     */
    public function checkInputDataIsEmpty($input, $indexArr)
    {
        foreach($indexArr as $v){
            if(!isset($input[$v]) || (empty($input[$v]) && ($input[$v] != 0 || $input[$v] != false))){
                return $v;
            }
        }
        return '';
    }

}
