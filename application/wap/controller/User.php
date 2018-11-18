<?php
namespace app\wap\controller;

use think\Controller;

class User extends Controller
{
    /**
     * 用户首页
     */
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

    /**
     * 我的订单
     */
    public function orderList()
    {
        $this->assign('head_title', '我的订单');
        return $this->fetch();
    }

    /**
     * 我的家庭成员/租客
     */
    public function myFamily()
    {
        $this->assign('head_title', '家庭成员/租客');
        return $this->fetch();
    }

    /**
     * 评价
     */
    public function assess()
    {
        $this->assign('head_title', '评价我们');
        return $this->fetch();
    }

    /**
     * 关于我们
     */
    public function aboutUs()
    {
        $this->assign('head_title', '关于我们');
        return $this->fetch();
    }

    /**
     * 设置页面
     */
    public function userSet()
    {
        $this->assign('head_title', '设置');
        return $this->fetch();
    }

    /**
     * 设置房间编号
     */
    public function setRoomNo()
    {
        $this->assign('head_title', '房间编号');
        return $this->fetch();
    }

    /**
     * 修改注册手机号码
     */
    public function setPhone()
    {
        $this->assign('head_title', '注册手机号码');
        return $this->fetch();
    }

    /**
     * 基础信息设置
     */
    public function setBasicInfo()
    {
        $this->assign('head_title', '基础信息');
        return $this->fetch();
    }

}