<?php
namespace app\wap\controller;

class Manager extends Base
{
    public function index()
    {
        return $this->fetch();
    }
}