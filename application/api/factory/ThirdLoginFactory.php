<?php
namespace app\api\factory;
use app\api\warpper\WeixinLoginWarpper;
use think\facade\Config;
use errors\ErrorException;
/**
 * Created by IntelliJ IDEA.
 * User: gary
 * Date: 2018/11/16
 * Time: 11:00 PM
 * 第三方登录工厂类
 */
class ThirdLoginFactory
{
    private static $sns_type;
    /**
     * 初始时，传入第三方类型
     * @param $mode
     */
    public function __construct($snstype)
    {
        self::$sns_type = $snstype;
    }


    public static function getInstance($input)
    {
        if(isset($input['sns_type'])){
            self::$sns_type = $input['sns_type'];
        }
        switch (self::$sns_type){
            case 1:
                $options = Config::get("wechat.")[Config::get("wechat.default_options_name")];
                return new WeixinLoginWarpper(['option'=>$options]);
                break;
        }
        return null;
    }
}
