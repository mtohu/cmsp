<?php
namespace app\wap\controller;

use think\Controller;

class Index extends Controller
{
    public function initialize(){
        parent::initialize();
    }
    public function index()
    {
        $nav_item = [
            'index' => 'nav-item-active',
            'manager' => '',
            'user' => ''
        ];
        $this->assign('nav_item', $nav_item);
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
        $this->assign('head_title', '消息');
        return $this->fetch();
    }

}
