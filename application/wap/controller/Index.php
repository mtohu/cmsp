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
        return $this->fetch();
    }
}
