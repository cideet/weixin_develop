<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2017/4/3
 * Time: 20:44
 */

namespace Home\Controller;

class WeixinController extends \Think\Controller
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
        $token = C('TOKEN');
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
        $postObj = simplexml_load_string($postXML);
        if (strtolower($postObj->MsgType) == 'event') {
            // 关注事件subscribe
            if (strtolower($postObj->Event) == 'subscribe') {
                $createTime = time();
                $content = '公众账号：' . $postObj->ToUserName;
                $content .= '微信用户的openid：' . $postObj->FromUserName;
                $content .= '关注时间：' . date("Y-m-d H:i:s", $createTime);
                $content .= '事件类型：' . $postObj->Event;
                subscribe($postObj, $content, $createTime);
            }
        } elseif ($postObj->MsgType == 'text') {
            if ($postObj->Content == 'tuwen') {
                $arr = array(
                    array(
                        'title' => '这是标题',
                        'description' => '这是很长很长的简介。感谢大神的分享，感谢这4年学程序的道路上遇到的每一个恩师：刘明轩、张恩民、李炎恢、何山、白俊遥，感谢工作中遇到的每一位同事在技术上的引导，也感谢网络中认识的一大拨良师良友。Photoshop在我的工作中已经生疏，代码却在我的生命中打开了另外一扇大门；世事凡俗本不是我擅长，就让技术去成就我的梦想。',
                        'picUrl' => 'http://wx.vdouw.com/testpic.jpg',
                        'url' => 'http://www.vdouw.com'
                    )
                );
                replyOnePicAndText($postObj, $arr);
            } elseif ($postObj->Content == 'duotuwen') {
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
                replyMorePicAndText($postObj, $arr);
            } else {
                // 回复文本消息
                switch (trim($postObj->Content)) {
                    case '张三丰':
                        $content = '张三丰正在努力学习微信开发';
                        break;
                    case 'tel':
                        $content = '18312345678';
                        break;
                    case 'vdouw':
                        $content = '<a href="http://www.vdouw.com/">点击跳转到“微豆网”官网</a>';
                        break;
                    default:
                        $content = '没有找到相关信息';
                }
                replyOnlyText($postObj, $content);
            }
        }
    }

    // 获取access_token
    function getWxAccessToken1()
    {
        $appid = C('APPID');
        $appsecret = C('AppSecret');
        //echo('appid:' . $appid . '<hr>appsecret:' . $appsecret . '<hr>');
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $appid . '&secret=' . $appsecret;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);                //执行HTTP请求
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        //若不为1，curl_exec将直接输入结果而不能保存到变量
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    //有时漏了ssl_verifypeer这条，一直返回false;
        $res = curl_exec($ch);
        curl_close($ch);
        if (curl_errno($ch)) {
            var_dump(curl_error($ch));
        }
        $arr = json_decode($res, true);     //json转数组
        $acceccToken = $arr['access_token'];
        echo('<script>console.log("' . $acceccToken . '")</script>');
        return $acceccToken;
    }

    // 获取微信服务器IP地址
    function getWxServerIp()
    {
        $accessToken = $this->getWxAccessToken1();
        //echo($accessToken);
        $url = 'https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=' . $accessToken;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);                //执行HTTP请求
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        //若不为1，curl_exec将直接输入结果而不能保存到变量
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    //有时漏了ssl_verifypeer这条，一直返回false;
        $res = curl_exec($ch);
        curl_close($ch);
        if (curl_errno($ch)) {
            var_dump(curl_error($ch));
        }
        $arr = json_decode($res, true);     //json转数组
        var_dump($arr);
    }


    // 测试curl的功能
    function http_curl_1()
    {
        $ch = curl_init();
        $url = 'http://www.thinkphp.cn/';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        var_dump($output);
    }


    // 创建微信测试号的自定义菜单
    public function defineItem()
    {
        //目前微信接口的调用方式都是通过curl post/get
        header("content-type:text/html;charset=utf-8");
        // $access_token = getWxAccessToken();     //网上说：一定要填账号本身的token，不要填成测试的那个token
        $access_token = getWxTestAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $access_token;
        $postArr = array(
            "button" => array(
                array("name" => urlencode("菜单一"), "type" => "click", "key" => "item1"),
                array(
                    "name" => urlencode("菜单2"),
                    "sub_button" => array(
                        array("name" => urlencode("歌曲11"), "type" => "click", "key" => "songs"),
                        array("name" => urlencode("电影22"), "type" => "view", "url" => "http://www.baidu.com")
                    )
                ),
                array("name" => urlencode("链接到百度"), "type" => "view", "url" => "http://www.qq.com")
            ),
        );
        echo("<hr>");
        print_r($access_token);
        echo("<hr>");
        $postJson = urldecode(json_encode($postArr));
        print_r($postJson);
        echo("<hr>");
        $res = http_curl($url, "post", "json", $postJson);
        print_r($res);
        echo("<hr>");
    }


}