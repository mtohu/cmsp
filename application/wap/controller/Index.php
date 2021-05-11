<?php
namespace app\wap\controller;

use app\wap\logic\Banner;
use think\Controller;

use think\Db;

class Index extends Base
{
    public function initialize(){
        parent::initialize();
    }
    public function index()
    {
        //底部导航
        $nav_item = [
            'index' => 'nav-item-active',
            'manager' => '',
            'user' => ''
        ];
        $this->assign('nav_item', $nav_item);
        //banner
        $this->assign('banners', Banner::getBanners());

        return $this->fetch();
    }

    /**
     * 小区位置
     */
    public function estatePos()
    {
        return $this->fetch();
    }

    /**
     * 消息列表
     */
    public function msgList()
    {
        $head = [
            'left_nav' => [
                'icon' => 'icon-fanhui',
                'url' => url('Index/index')
            ],
            'title' => '消息',
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
