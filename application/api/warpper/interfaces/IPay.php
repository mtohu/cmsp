<?php
namespace app\api\warpper\interfaces;
/**
 * Created by IntelliJ IDEA.
 * User: gary
 * Date: 2018/11/19
 * Time: 1:59 PM
 */
interface IPay{
    public function do_pay($input);
    public function do_notify($input);
}
