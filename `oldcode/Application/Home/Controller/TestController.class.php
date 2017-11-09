<?php
namespace Home\Controller;

class TestController extends \Think\Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 微信验证接口
     */
    public function index()
    {
        //print_r(input());     //不要瞎JS去打印，打印不出什么卵
        //exit;
        //1、将timestamp,nonce,token按字典序排序
        $nonce = $_GET["nonce"];
        $timestamp = $_GET["timestamp"];
        $token = 'study_weixin_dev';
        $signature = $_GET["signature"];
        $echostr = $_GET["echostr"];
        //形成数组，然后按字典序排序
        $array = array($timestamp, $nonce, $token);
        sort($array);
        $str = sha1(implode($array));
        if ($str == $signature && $echostr) {
            //第一次接入微信API接口的时候，就是微信公众平台在验证接入的时候（修改配置）用一次
            echo $echostr;
            exit;
        } else {
            $this->responseMsg();
        }
    }

    //接受事件推送并回复
    public function responseMsg()
    {
        //1、获取微信推送过来的POST数据（XML格式）
        $postStr = $GLOBALS['HTTP_RAW_POST_DATA'];
        //$postStr = file_get_contents("php://input");
        //Log::write("断点1".$postObj,"断点");
        //2、处理消息类型，并设置回复类型和内容
        //将XML转化成对象
        $postObj = simplexml_load_string($postStr);
        //判断该数据包是否是订阅的事件推送，也就是：用户关注或取消关注
        if (strtolower($postObj->MsgType) == 'event') {
            //如果是关注
            if (strtolower($postObj->Event == 'subscribe')) {
                $toUser = $postObj->FromUserName;
                $fromUser = $postObj->ToUserName;
                $time = time();
                $MsgType = 'text';
                $content = '欢迎关注我的公众号';
                $template = '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><Content><![CDATA[%s]]></Content></xml>';
                $info = sprintf($template, $toUser, $fromUser, $time, $MsgType, $content);
                echo $info;
            }
        }
    }




}