<?php
namespace app\wap\controller;

class Index extends Base
{
    public function initialize(){
        parent::initialize();
    }
    public function index()
    {
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
