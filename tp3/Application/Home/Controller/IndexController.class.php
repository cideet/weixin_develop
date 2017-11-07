<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/6 0006
 * Time: 10:01
 */

namespace Home\Controller;

class IndexController extends \Think\Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function test()
    {
        echo('test_tp3');
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
        //https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140454
        //判断该数据包是否是订阅的事件推送，也就是：用户关注或取消关注
        if (strtolower($postObj->MsgType) == 'event') {
            //如果是关注
            if (strtolower($postObj->Event == 'subscribe')) {
                subscribe($postObj);
            }
        } elseif (strtolower($postObj->MsgType) == 'text') {    //接收用户的输入类型
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
                        //$url = 'http://api.avatardata.cn/Weather/Query?key=17ce40f952af4f85aac03c91b46354c3&cityname=' . urlencode($postObj->Content);
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