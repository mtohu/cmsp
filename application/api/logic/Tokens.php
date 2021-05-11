<?php
namespace app\api\logic;
require_once "../vendor/firebase/php-jwt/src/JWT.php";
require_once "../vendor/firebase/php-jwt/src/ExpiredException.php";
require_once "../vendor/firebase/php-jwt/src/BeforeValidException.php";
require_once "../vendor/firebase/php-jwt/src/SignatureInvalidException.php";
use \Firebase\JWT\JWT;
use think\facade\Config;
class Tokens extends Base{
    //protected $opensslService;
    protected static $key="sxcmp";
    protected static $alg="HS256";
    /*public function __construct(){
        //$this->opensslService = new OpensslService();
    }*/
    public static function createResidentToken($data){
        if(!is_array($data)) return false;
        $map=array();
        $expiresAt = $data["created_at"] + $data['expires_in'];
        $map["token_resident_id"]=trim($data["resident_id"]);//自己编号或上级编号
        $map["token_created_at"]=$data["created_at"];
        $map["token_expires_at"]=$expiresAt;
        $map["token_ip"] = ip2long($data["ip"]);
        $payload = [
            'iss' => 'http://www.sxcmp.net', //签发者 可选
            'aud' => 'http://www.sxcmp.net', //接收该JWT的一方，可选
            'iat' => $data["created_at"], //签发时间
            'nbf' => $data["created_at"] , //(Not Before)：某个时间点后才能访问，比如设置time+30，表示当前时间30秒后才能使用
            'exp' => $expiresAt, //过期时间,这里设置2个小时
            'data' => $map,
        ];
        $token=JWT::encode($payload, self::$key,self::$alg);
        //$token=$this->opensslService->aes_encrypt(json_encode($map));
        return $token;
    }

    public static function decodeJWT($token){
        try {
            JWT::$leeway = 60;//当前时间减去60，把时间留点余地
            $decoded = JWT::decode($token,  self::$key, [self::$alg]); //HS256方式，这里要和签发的时候对应
            $arr = (array)$decoded;
        } catch(\Firebase\JWT\SignatureInvalidException $e) {  //签名不正确
            return false;
        }catch(\Firebase\JWT\BeforeValidException $e) {  // 签名在某个时间点之后才能用
            return false;
        }catch(\Firebase\JWT\ExpiredException $e) {  // token过期
            return false;
        }catch(\Exception $e) {  //其他错误
            return false;
        }
        $data = $arr['data'];
        if(is_object($arr['data'])){
            $data = (array)$arr['data'];
        }
        return $data;
    }
}
