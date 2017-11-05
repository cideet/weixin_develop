<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2017/11/5
 * Time: 6:31
 */

namespace app\home\controller;

class Index extends \think\Controller
{
    /**
     * 微信验证接口
     */
    public function accessauth()
    {
        //1、将timestamp,nonce,token按字典序排序
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = 'study_weixin_dev';
        $signature = $_GET["signature"];
        $echostr = $_GET["echostr"];
        //形成数组，然后按字典序排序
        $array = array($timestamp, $nonce, $token);
        sort($array);
        $str = sha1(implode($array));
        if ($str == $signature && $echostr) {
            //第一次接入微信API接口的时候
            echo $echostr;
            exit;
        } else {
            $this->responseMsg();
        }
    }
}