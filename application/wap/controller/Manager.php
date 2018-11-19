<?php
namespace app\wap\controller;

use think\Controller;
use app\wap\logic\Banner;

class Manager extends Base
{
    public function index()
    {
        $nav_item = [
            'index' => '',
            'manager' => 'nav-item-active',
            'user' => ''
        ];
        //banner
        $this->assign('banners', Banner::getBanners());
        $this->assign('nav_item', $nav_item);
        return $this->fetch();
    }

    /**
     * 报修列表
     */
    public function repairList()
    {
        $this->assign('head_title', '报修列表');
        return $this->fetch();
    }

    /**
     * 提交报修
     */
    public function submitRepair()
    {
        $this->assign('head_title', '报修报事');
        return $this->fetch();
    }

}