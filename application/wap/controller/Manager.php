<?php
namespace app\wap\controller;

use think\Controller;

class Manager extends Controller
{
    public function index()
    {
        $nav_item = [
            'index' => '',
            'manager' => 'nav-item-active',
            'user' => ''
        ];
        $this->assign('nav_item', $nav_item);
        return $this->fetch();
    }
}