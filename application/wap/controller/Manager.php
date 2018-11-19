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
        $head = [
            'left_nav' => [
                'icon' => 'icon-fanhui',
                'url' => url('Manager/index')
            ],
            'title' => '报修列表',
            'right_btn' => [
                'is_show' => true,
                'btn_name' => '报修',
                'url' => url('Manager/submitRepair')
            ]
        ];
        $this->assign('head', $head);
        //请求数据
        $request_api = new RequestApi();
        $res = $request_api->request_ajax();
        return $this->fetch();
    }

    /**
     * 提交报修
     */
    public function submitRepair()
    {
        $head = [
            'left_nav' => [
                'icon' => 'icon-fanhui',
                'url' => url('Manager/repairList')
            ],
            'title' => '提交报修',
            'right_btn' => [
                'is_show' => false,
                'btn_name' => '',
                'url' => ''
            ]
        ];
        $this->assign('head', $head);
        return $this->fetch();
    }

}