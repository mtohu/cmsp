<?php
namespace app\api\factory;
use app\api\warpper\WxPayWarpper;
use errors\ErrorException;
/**
 * Created by IntelliJ IDEA.
 * User: gary
 * Date: 2018/11/19
 * Time: 2:55 PM
 * 支付工厂类
 */
class PayFactory
{
    private static $pay_mod;
    /**
     * 初始时，传入第三方类型
     * @param $mode
     */
    public function __construct($pay_mod)
    {
        self::$pay_mod = $pay_mod;
    }


    public static function getInstance($input)
    {
        if(isset($input['pay_mod'])){
            self::$pay_mod = $input['pay_mod'];
        }
        switch (self::$pay_mod){
            case 1:
                return new WxPayWarpper($input);
                break;
        }
        return null;
    }
}
