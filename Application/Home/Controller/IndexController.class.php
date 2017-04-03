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
        //
        if (strtolower($postObj->MsgType) == 'event') {
            // 判断该数据包是否是订阅的事件推送 如果是关注事件subscribe
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
                $template = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><Content><![CDATA[%s]]></Content></xml>";
                $info = sprintf($template, $toUser, $fromUser, $time, $MsgType, $content);
                echo $info;
            }
        } elseif ($postObj->MsgType == 'text') {
            if ($postObj->Content == 'tuwen') {
                // 回复图文消息
                // <xml>
                // <ToUserName><![CDATA[toUser]]></ToUserName>
                // <FromUserName><![CDATA[fromUser]]></FromUserName>
                // <CreateTime>12345678</CreateTime>
                // <MsgType><![CDATA[news]]></MsgType>
                // <ArticleCount>2</ArticleCount>
                // <Articles>
                // <item>
                // <Title><![CDATA[title1]]></Title>
                // <Description><![CDATA[description1]]></Description>
                // <PicUrl><![CDATA[picurl]]></PicUrl>
                // <Url><![CDATA[url]]></Url>
                // </item>
                // <item>
                // <Title><![CDATA[title]]></Title>
                // <Description><![CDATA[description]]></Description>
                // <PicUrl><![CDATA[picurl]]></PicUrl>
                // <Url><![CDATA[url]]></Url>
                // </item>
                // </Articles>
                // </xml>
                $toUser = $postObj->FromUserName;
                $fromUser = $postObj->ToUserName;
                $createTime = time();
                $MsgType = 'news';
                $arr = array(
                    array(
                        'title' => '这是标题',
                        'description' => '这是很长很长的简介。感谢大神的分享，感谢这4年学程序的道路上遇到的每一个恩师：刘明轩、张恩民、李炎恢、何山、白俊遥，感谢工作中遇到的每一位同事在技术上的引导，也感谢网络中认识的一大拨良师良友。Photoshop在我的工作中已经生疏，代码却在我的生命中打开了另外一扇大门；世事凡俗本不是我擅长，就让技术去成就我的梦想。',
                        'picUrl' => 'http://wx.vdouw.com/testpic.jpg',
                        'url' => 'http://www.vdouw.com'
                    )
                );
                $template = '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><ArticleCount>' . count($arr) . '</ArticleCount><Articles>';
                foreach ($arr as $key => $value) {
                    $template .= '<item><Title><![CDATA[' . $value["title"] . ']]></Title><Description><![CDATA[' . $value["description"] . ']]></Description><PicUrl><![CDATA[' . $value["picUrl"] . ']]></PicUrl><Url><![CDATA[' . $value["url"] . ']]></Url></item>';
                }
                $template .= '</Articles></xml>';
                $info = sprintf($template, $toUser, $fromUser, $time, $MsgType, $content);
                echo $info;
            } elseif ($postObj->Content == 'duotuwen') {
                $toUser = $postObj->FromUserName;
                $fromUser = $postObj->ToUserName;
                $createTime = time();
                $MsgType = 'news';
                $arr = array(
                    array(
                        'title' => '这是标题111',
                        'description' => '这是很长很长的简介1',
                        'picUrl' => 'http://wx.vdouw.com/testpic2.jpg',
                        'url' => 'http://www.vdouw.com'
                    ),
                    array(
                        'title' => '这是标题222',
                        'description' => '这是很长很长的简介2',
                        'picUrl' => 'http://wx.vdouw.com/testpic.jpg',
                        'url' => 'http://www.vdouw.com'
                    ),
                    array(
                        'title' => '这是标题333这是标题333这是标题333这是标题333这是标题333这是标题333这是标题333这是标题333这是标题333这是标题333这是标题333这是标题333这是标题333这是标题333这是标题333这是标题333',
                        'description' => '这是很长很长的简介3这是很长很长的简介3这是很长很长的简介3这是很长很长的简介3这是很长很长的简介3这是很长很长的简介3这是很长很长的简介3这是很长很长的简介3这是很长很长的简介3这是很长很长的简介3这是很长很长的简介3',
                        'picUrl' => 'http://wx.vdouw.com/testpic2.jpg',
                        'url' => 'http://www.vdouw.com'
                    )
                );
                $template = '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><ArticleCount>' . count($arr) . '</ArticleCount><Articles>';
                foreach ($arr as $key => $value) {
                    $template .= '<item><Title><![CDATA[' . $value["title"] . ']]></Title><Description><![CDATA[' . $value["description"] . ']]></Description><PicUrl><![CDATA[' . $value["picUrl"] . ']]></PicUrl><Url><![CDATA[' . $value["url"] . ']]></Url></item>';
                }
                $template .= '</Articles></xml>';
                $info = sprintf($template, $toUser, $fromUser, $time, $MsgType, $content);
                echo $info;
            } else {
                // 回复文本消息
                // <xml>
                // <ToUserName><![CDATA[toUser]]></ToUserName>
                // <FromUserName><![CDATA[fromUser]]></FromUserName>
                // <CreateTime>12345678</CreateTime>
                // <MsgType><![CDATA[text]]></MsgType>
                // <Content><![CDATA[你好]]></Content>
                // </xml>
                $template = '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><Content><![CDATA[%s]]></Content></xml>';
                $toUser = $postObj->FromUserName;
                $fromUser = $postObj->ToUserName;
                $time = time();
                $MsgType = 'text';
                switch (trim($postObj->Content)) {
                    case '张三丰':
                        $content = '张三丰正在努力的学习微信开发';
                        break;
                    case 'tel':
                        $content = '18312345678';
                        break;
                    case 'vdouw':
                        $content = '<a href="http://www.vdouw.com/">点击跳转到“微豆网”官网</a>';
                        break;
                    default:
                        $content = '默认回复的文字';
                }
                $info = sprintf($template, $toUser, $fromUser, $time, $MsgType, $content);
                echo $info;
            }
        }
    }

    function http_curl_1(){
        $ch = curl_init();
        $url = 'http://www.thinkphp.cn/';
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $output = curl_exec($ch);
        curl_close($ch);
        var_dump($output);
    }



}