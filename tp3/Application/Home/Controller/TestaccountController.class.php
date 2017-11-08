<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/6 0006
 * Time: 10:01
 */

namespace Home\Controller;

class TestaccountController extends \Think\Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 生成临时二维码
     */
    public function getTimeQrCode()
    {
        $access_token = getWxTestAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access_token;
        $postArr = array(
            'expire_seconds' => 604800, //24*60*60*7
            'action_name' => 'QR_SCENE',
            'action_info' => array(
                'scene' => array(
                    'scene_id' => 2000
                )
            )
        );
        $postJson = json_encode($postArr);
        $res = http_curl($url, 'post', 'json', $postJson);
        $ticket = $res['ticket'];
        $url2 = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($ticket);
        echo('<img src="' . $url2 . '"/>');
    }

    /**
     * 生成永久二维码
     */
    public function getForeverQrCode()
    {
        $access_token = getWxTestAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access_token;
        $postArr = array(
            'action_name' => 'QR_LIMIT_SCENE',
            'action_info' => array(
                'scene' => array(
                    'scene_id' => 3000
                )
            )
        );
        $postJson = json_encode($postArr);
        $res = http_curl($url, 'post', 'json', $postJson);
        $ticket = $res['ticket'];
        $url2 = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($ticket);
        echo('<img src="' . $url2 . '"/>');
    }

    /**
     * 分享API
     */
    public function share()
    {
        //1、获取jsapi_ticket票据
        $jsapi_ticket = getJsApiTicket();
        $nonceStr = getRandCode(16);
        $timestamp = time();
        $url = 'http://wx_tp3.vdouw.com/index.php/home/testaccount/share';
        //2、获取signature
        $signature = 'jsapi_ticket=' . $jsapi_ticket . '&noncestr=' . $nonceStr . '&timestamp=' . $timestamp . '&url=' . $url;
        $signature = sha1($signature);  //加密
        $this->assign('appid', C('AppIDTest'));
        $this->assign('timestamp', $timestamp);
        $this->assign('nonceStr', $nonceStr);
        $this->assign('signature', $signature);
        $this->display('Index/share');
    }

    /**
     * 获取用户信息
     */
    public function getUserInfo()
    {
        $appid = C('AppIDTest');
        $redirect_uri = urlencode('http://wx_tp3.vdouw.com/index.php/home/testaccount/getUserInfoNext');
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $appid . '&redirect_uri=' . $redirect_uri . '&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect';
        header('location:' . $url);
    }

    /**
     * 获取用户信息（配合使用）
     */
    public function getUserInfoNext()
    {
        $code = $_GET['code'];
        $appid = C('AppIDTest');
        $AppSecretTest = C('AppSecretTest');
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appid . '&secret=' . $AppSecretTest . '&code=' . $code . '&grant_type=authorization_code';
        //3、拉取用户的openid
        $res = http_curl($url, 'get');
        $access_token = $res['access_token'];
        $openid = $res['openid'];
        $url2 = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $access_token . '&openid=' . $openid . '&lang=zh_CN';
        $res2 = http_curl($url2);
        var_dump($res2);
    }

    /**
     * 获取用户基本信息
     */
    public function getUserBaseInfo()
    {
        //1、获取到code
        $appid = C('AppIDTest');
        $redirect_uri = urlencode('http://wx_tp3.vdouw.com/index.php/home/testaccount/getUserOpenId');
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $appid . '&redirect_uri=' . $redirect_uri . '&response_type=code&scope=snsapi_base&state=123#wechat_redirect';
        header('location:' . $url);
    }

    /**
     * 获取用户openid
     */
    public function getUserOpenId()
    {
        //2、获取到网页授权的access_token
        $code = $_GET['code'];
        $appid = C('AppIDTest');
        $AppSecretTest = C('AppSecretTest');
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appid . '&secret=' . $AppSecretTest . '&code=' . $code . '&grant_type=authorization_code';
        //3、拉取用户的openid
        $res = http_curl($url, 'get');
        var_dump($res);
    }

    /**
     * 群发接口
     */
    public function sendMsgAll()
    {
        $accessToken = getWxTestAccessToken();
        print_r($accessToken);
        echo('<hr>');
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token=' . $accessToken;  //预览接口
        //$url = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=' . $accessToken;  //服务号认证后可用
        //发送“单文本”
        $array = array(
            'touser' => 'orrEvxP8LaJIYwU3QJjvwci5M6qw',
            'text' => array('content' => 'imooc is very happy'),
            'msgtype' => 'text'
        );
        //发送“单图文”，还有点问题，学了后面再说
        //$array = array(
        //    "touser" => "orrEvxP8LaJIYwU3QJjvwci5M6qw",
        //    "mpnews" => array("media_id" => "QQ9nj-7ctrqA8t3WKU3dQN24IuFV_516MfZRZNnQ0c-BFVkk66jUkPXF49QE9L1l"),
        //    "msgtype" => "mpnews"
        //);
        print_r($array);
        echo('<hr>');
        $postJson = json_encode($array);
        print_r($postJson);
        echo('<hr>');
        $res = http_curl($url, 'post', 'json', $postJson);
        var_dump($res);
    }

    /**
     * 模板消息
     */
    public function sendTemplateMsg()
    {
        $access_token = getWxTestAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $access_token;
        $array = array(
            'touser' => 'orrEvxP8LaJIYwU3QJjvwci5M6qw',
            'template_id' => 'PTB1tjfLGQhQuiXJVow-F8EkTGmnXChczkyIErNRXK0',
            'url' => 'http://www.imooc.com',
            'data' => array(
                'name' => array('value' => 'hello', 'color' => '#172737'),
                'money' => array('value' => '100元', 'color' => '#172737'),
                'date' => array('value' => date('Y-m-d H:i:s'), 'color' => '#172737')
            )
        );
        $postJson = json_encode($array);
        $res = http_curl($url, 'post', 'json', $postJson);
        var_dump($res);
    }

    /**
     * 自定义菜单
     */
    public function custommenu()
    {
        //目前微信接口的调用方式都是通过curl post/get
        header("content-type:text/html;charset=utf-8");
        $access_token = getWxTestAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $access_token;
        $postArr = array(
            "button" => array(
                array("name" => urlencode("分享页面"), "type" => "view", "url" => "http://wx_tp3.vdouw.com/index.php/home/testaccount/share"),
                array(
                    "name" => urlencode("菜单2"),
                    "sub_button" => array(
                        array("name" => urlencode("这是按钮"), "type" => "click", "key" => "item2"),
                        array("name" => urlencode("链接到百度"), "type" => "view", "url" => "http://www.baidu.com")
                    )
                ),
                array("name" => urlencode("重置菜单"), "type" => "view", "url" => "http://wx_tp3.vdouw.com/index.php/home/testaccount/custommenu")
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

    /**
     * 微信验证接口
     */
    public function index()
    {
        //1、将timestamp,nonce,token按字典序排序
        $nonce = $_GET["nonce"];
        $timestamp = $_GET["timestamp"];
        $token = C('token');
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

    /**
     * 接受事件推送并回复
     */
    public function responseMsg()
    {
        $postStr = $GLOBALS['HTTP_RAW_POST_DATA'];
        $postObj = simplexml_load_string($postStr);
        if (strtolower($postObj->MsgType) == 'event') {
            //订阅
            if (strtolower($postObj->Event == 'subscribe')) {
                subscribe($postObj);
            }
            //扫描二维码
            if (strtolower($postObj->Event) == 'scan') {
                if (strtolower($postObj->EventKey == 2000)) {
                    $content = '如果是订阅后扫描临时二维码';
                    replyOnlyText($postObj, $content);
                } elseif (strtolower($postObj->EventKey == 3000)) {
                    $content = '如果是订阅后扫描永久二维码';
                    replyOnlyText($postObj, $content);
                }
            }
            //自定义菜单中的click事件
            if (strtolower($postObj->Event) == 'click') {
                if (strtolower($postObj->EventKey) == 'item1') {  //事件KEY值，由开发者在创建菜单时设定
                    $content = '自定义菜单中的event=>click1';
                    replyOnlyText($postObj, $content);
                } elseif (strtolower($postObj->EventKey) == 'item2') {
                    $content = '自定义菜单中的event=>click2';
                    replyOnlyText($postObj, $content);
                }
            }
        } elseif (strtolower($postObj->MsgType) == 'text') {
            if (strtolower(trim($postObj->Content)) == 'tuwen') {
                $arr = array(
                    array(
                        'title' => 'imooc',
                        'description' => 'imooc is very cool!!!',
                        'picUrl' => 'http://wx_tp3.vdouw.com/public/images/img.jpg',
                        'url' => 'http://www.imooc.com'
                    )
                );
                replyPicAndText($postObj, $arr);
            } elseif (strtolower(trim($postObj->Content)) == 'duotuwen') {
                $arr = array(
                    array(
                        'title' => 'imooc',
                        'description' => 'imooc is very cool!!!',
                        'picUrl' => 'http://wx_tp3.vdouw.com/public/images/img.jpg',
                        'url' => 'http://www.imooc.com'
                    ),
                    array(
                        'title' => '微豆网',
                        'description' => '微豆网 is very cool!!!',
                        'picUrl' => 'http://wx_tp3.vdouw.com/public/images/img.jpg',
                        'url' => 'http://blog.vdouw.com'
                    ),
                    array(
                        'title' => '微豆网111',
                        'description' => '微豆网 is very cool!!!',
                        'picUrl' => 'http://wx_tp3.vdouw.com/public/images/img.jpg',
                        'url' => 'http://blog.vdouw.com'
                    )
                );
                replyPicAndText($postObj, $arr);
            } else {
                switch (strtolower(trim($postObj->Content))) {      //接收用户的输入内容
                    case 1:
                        $content = '您输入了1';
                        break;
                    case 2:
                        $content = '您输入了2';
                        break;
                    case 'imooc':
                        $content = 'imooc is very good!!!';
                        break;
                    case 'vdouw':
                        $content = '<a href="http://blog.vdouw.com">微豆网博客</a>';
                        break;
                    case '天气':
                        $url = 'http://api.avatardata.cn/Weather/Query?key=17ce40f952af4f85aac03c91b46354c3&cityname=北京';
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        $ret = curl_exec($ch);
                        curl_close($ch);
                        if (curl_errno($ch)) var_dump(curl_error($ch));
                        $arr = json_decode($ret, true);  //JSON转数组
                        $content = "测试接口可用1000次";
                        $content .= "\n获取北京的天气：";
                        $content .= "\n当前时间：" . $arr['result']['realtime']['date'];
                        $content .= "\n最高温度：" . $arr['result']['realtime']['weather']['temperature'];
                        $content .= "℃\n最低温度：" . $arr['result']['realtime']['weather']['humidity'];
                        $content .= "℃\n天气：" . $arr['result']['realtime']['weather']['info'];
                        break;
                    default:
                        $content = '这是默认回复的信息';
                }
                replyOnlyText($postObj, $content);
            }
        }
    }


    /**
     * 测试采集
     * 学习过程中调试用，放在最下面即可，别删
     */
    public function http_curl_test1()
    {
        //1、初始化CURL
        $ch = curl_init();
        $url = 'http://www.imooc.com';
        //2、设置CURL参数
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //有时漏了ssl_verifypeer这条，一直返回false;
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //3、采集
        $output = curl_exec($ch);
        //4、关闭
        curl_close($ch);
        var_dump($output);
    }

    /**
     * 获取Access_token
     * 学习过程中调试用，放在最下面即可，别删
     */
    public function getWxAccessToken_test1()
    {
        $AppID = C('AppID');
        $AppSecret = C('AppSecret');
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $AppID . '&secret=' . $AppSecret;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $ret = curl_exec($ch);
        curl_close($ch);
        if (curl_errno($ch)) var_dump(curl_error($ch));
        $arr = json_decode($ret, true);  //JSON转数组
        echo(json_encode($arr));
        setcookie('access_token_test1', $arr['access_token']);
    }

    /**
     * 获取微信服务器IP地址
     * 学习过程中调试用，放在最下面即可，别删
     */
    public function getWxServerIp_test1()
    {
        if (!cookie('access_token_test1')) {
            $this->getWxAccessToken_test1();
        }
        echo(cookie('access_token_test1') . '<hr>');
        $url = 'https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=' . cookie('access_token_test1');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $ret = curl_exec($ch);
        curl_close($ch);
        if (curl_errno($ch)) var_dump(curl_error($ch));
        $arr = json_decode($ret, true);  //JSON转数组
        var_dump($arr);
    }

}

?>