<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2017/4/2
 * Time: 3:11
 */

//1、将timestamp,nonce,token按字典序排序
$timestamp = $_GET["timestamp"];
$nonce = $_GET["nonce"];
$token = "vdouw_study_weixin_develop";
$signature = $_GET["signature"];
$echostr = $_GET["echostr"];

//形成数组，然后按字典序排序
$array = array();
$array = array($timestamp, $nonce, $token);
sort($array);

$str = sha1(implode($array));
if ($str == $signature && $echostr) {
    //第一次接入微信API接口的时候
    echo $echostr;
    exit;
}

?>