<?php
namespace app\wap\controller;

use think\Controller;

class User extends Controller
{
    public function index()
    {
        $nav_item = [
            'index' => '',
            'manager' => '',
            'user' => 'nav-item-active'
        ];
        $this->assign('nav_item', $nav_item);
        return $this->fetch();
    }
}