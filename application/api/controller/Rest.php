<?php
namespace app\api\controller;
use app\api\logic\Tokens;
use think\facade\Config;
use think\Db;
class Rest extends Base{
    private $httpMethodsEncodingParametersInURI;
    private $allowedHTTPMethod;
    private $request_;
    private $mapInfo;
    private $method;
    public $_api_mapping=null;
    private $_http_server=array("ACUUID"=>"HTTP_ACUUID","ACPHONE"=>"HTTP_ACPHONE","ACMODEL"=>"HTTP_ACMODEL","ACTIME"=>"HTTP_ACTIME","ACTOKEN"=>"HTTP_ACTOKEN","AUTH"=>"HTTP_AUTH");
    const HTTP_METHOD_GET = 'get';
    const HTTP_METHOD_POST = 'post';
    const HTTP_METHOD_PUT = 'put';
    const HTTP_METHOD_DELETE = 'delete';
    public function initialize(){
        $this->allowedHTTPMethod = array(self::HTTP_METHOD_GET, self::HTTP_METHOD_POST, self::HTTP_METHOD_DELETE, self::HTTP_METHOD_PUT);
        $this->httpMethodsEncodingParametersInURI = array(self::HTTP_METHOD_GET, self::HTTP_METHOD_DELETE);
        $this->_api_mapping = Config::pull("api");
    }
    /**
     *网关
     *
    */
    public function gateway($resourceName){
        $this->initRequest($resourceName);
        $res = $this->verifyRequest($resourceName);
        if ($res === True) {
            return $this->dispatch_task();
        }else{
            return $this->print_result($res);
        }
        return false;
    }
    private function verifyRequest(){
        $errorData=['ErrorCode'=>9999,'ErrorMsg'=>''];
        if (!is_legal_array($this->mapInfo)) {
            $errorData=['ErrorCode'=>404,'ErrorMsg'=>'未找到 API'];
        }
        if (!in_array($this->method, $this->allowedHTTPMethod)) {
            $errorData=['ErrorCode'=>405,'ErrorMsg'=>'不允许的 HTTP 方法'];
        }
        if (safe_array_entry($this->mapInfo, 'need_auth') == 'true') {
            $result = $this->authorize(true);
            if(is_array($result)){
                return $result;
            }
            if (!$result) {
                //failed authorize
                $errorData=['ErrorCode'=>401,'ErrorMsg'=>'未授权'];
            }
        } else {
            //still parse the token if has
            $result = $this->authorize(false);
            if(is_array($result))
                return $result;
        }
        if (9999 != $errorData['ErrorCode']){
            return $errorData;
        }
        return TRUE;
    }
    private function initRequest($rName){
        $this->method = strtolower($this->request->method(true));
        $args = null;
        if (in_array($this->method, $this->httpMethodsEncodingParametersInURI)) {
            $args = $this->request->param();
            if ($this->method == self::HTTP_METHOD_DELETE) {
                parse_str(file_get_contents("php://input"), $post_vars);
                $args = array_merge($args, $post_vars);
            }
        } else {
            $args = $this->request->param();
            if ($this->method == self::HTTP_METHOD_PUT) {
                parse_str(file_get_contents("php://input"), $post_vars);
                $args = array_merge($args, $post_vars);
            }
        }
        foreach($this->_http_server as $k=>$v){
            $args[$k]=isset($_SERVER[$v])?$_SERVER[$v]:"";
        }
        $this->args = $args;
        $this->load_api_map_info($rName);
    }
    private function dispatch_task(){
        $controllerName = ucfirst($this->mapInfo['c']);
        $actionName = $this->mapInfo['a'];
        $obj_task = controller($controllerName);
        return $obj_task->$actionName($this->args);
    }
    private function load_api_map_info($rName){
        $mapKey = $rName. "/" . $this->method;
        $mapInfo = safe_array_entry($this->_api_mapping, $mapKey);
        $this->mapInfo = $mapInfo;
    }

    private function authorize($parseOnly=false){
        $token = trim(safe_array_entry($this->args, 'token'));
        if (!is_legal_string($token)) {
            //no token passed, deny it
            return false;
        }
        //do user auth from token
        return $this->verify_token($token,$parseOnly);
    }
    private function verify_token($token,$parseOnly){
        $api_type = strtolower($this->mapInfo['api_type']);
        $decArray=Tokens::decodeJWT($token);
        if(!$decArray)
            return ['ErrorCode'=>5,'ErrorMsg'=>'token异常,请重新登录'];

        if(!isset($decArray['token_created_at']))
            return ['ErrorCode'=>5,'ErrorMsg'=>'token异常,请重新登录'];

        $exptime=$decArray['token_created_at']+3600 * 24 * 7;
        if($exptime < now_time())
            return ['ErrorCode'=>5,'ErrorMsg'=>'帐号已过期,请重新登录'];

        $str_atoken = Db::name("cmp_resident")->where([['id','=',$decArray['token_resident_id']]])->value("atoken");
        $enStr = !empty($str_atoken)?$str_atoken:"";
        $decReArray = Tokens::decodeJWT($enStr);
        if(!$decReArray)
            return ['ErrorCode'=>5,'ErrorMsg'=>'请重新登录'];

        if(!isset($decReArray['token_created_at']))
            return ['ErrorCode'=>5,'ErrorMsg'=>'请重新登录'];

        $this->set_args($decArray);
        return TRUE;

    }
    private function set_args($values)
    {
        foreach($values as $key => $value) {
            $this->args[$key] = $value;
        }
    }

}
