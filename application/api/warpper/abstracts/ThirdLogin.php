<?php
namespace app\api\warpper\abstracts;
abstract class ThirdLogin{
     /****登录****/
     public abstract function doLogin($input);
     /****获取用户信息****/
     public abstract function getUserInfo($input);
}

