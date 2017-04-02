<?php
namespace Home\Controller;

class IndexController extends \Think\Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    // 微信验证接口
    public function index()
    {
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
        } else {
            $this->responseMsg();
        }
    }

    // 接收事件推送并回复
    public function responseMsg()
    {
        // 获取到微信推送过来的POST数据（XML格式）
        $postXML = $GLOBALS['HTTP_RAW_POST_DATA'];
        // 处理消息类型，并设置回复类型和内容
        // 关注/取消关注事件
        // 推送XML数据包示例（微信接收的数据包）
        // <xml>
        // <ToUserName><![CDATA[toUser]]></ToUserName>
        // <FromUserName><![CDATA[FromUser]]></FromUserName>
        // <CreateTime>123456789</CreateTime>
        // <MsgType><![CDATA[event]]></MsgType>
        // <Event><![CDATA[subscribe]]></Event>
        // </xml>
        $postObj = simplexml_load_string($postXML);
        // $postObj->ToUserName = '';
        // $postObj->FromUserName = '';
        // $postObj->CreateTime = '';
        // $postObj->MsgType = '';
        // $postObj->Event = '';
        // 判断该数据包是否是订阅的事件推送
        if (strtolower($postObj->MsgType) == 'event') {
            // 如果是关注事件subscribe
            if (strtolower($postObj->Event) == 'subscribe') {
                // 回复用户消息
                $toUser = $postObj->FromUserName;
                $fromUser = $postObj->toUserName;
                $time = time();
                $MsgType = 'text';
                //$content = '欢迎关注我们的微信公众号';
                $content = '公众账号：' . $postObj->ToUserName;
                $content .= '微信用户的openid：' . $postObj->FromUserName;
                $content .= '关注时间：' . date("Y-m-d H:i:s", $time);
                $content .= '事件类型：' . $postObj->Event;
                // 回复文本消息（微信要发送出去的数据包）
                // <xml>
                // <ToUserName><![CDATA[toUser]]></ToUserName>
                // <FromUserName><![CDATA[fromUser]]></FromUserName>
                // <CreateTime>12345678</CreateTime>
                // <MsgType><![CDATA[text]]></MsgType>
                // <Content><![CDATA[你好]]></Content>
                // </xml>
                $template = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            </xml>";
                $info = sprintf($template, $toUser, $fromUser, $time, $MsgType, $content);
                echo $info;
            }

        }

    }


}