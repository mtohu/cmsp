<?php
/**
 * Created by PhpStorm.
 * Power By Mikkle
 * Email：776329498@qq.com
 * Date: 2017/8/30
 * Time: 9:21
 */

namespace vendor\tp_wxpay;



/**
 * 通用通知接口
 */
class Notify_pub extends Wxpay_server_pub
{
    function __construct($config=array()) {
         parent::__construct($config);
    }

}
