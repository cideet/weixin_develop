<?php
namespace app\index\controller;

class Index extends \think\Controller
{
    public function index()
    {
        return $this->fetch();
        //引入模板application/index/view/index/index.html
    }
}
