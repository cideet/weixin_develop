<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2017/4/3
 * Time: 21:09
 */

// 关注时的自动回复
function subscribe($postObj, $content, $createTime)
{
    $toUser = $postObj->FromUserName;
    $fromUser = $postObj->ToUserName;
    $MsgType = 'text';
    $template = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><Content><![CDATA[%s]]></Content></xml>";
    $info = sprintf($template, $toUser, $fromUser, $createTime, $MsgType, $content);
    echo $info;
}

// 自动回复（多图文）
function replyMorePicAndText($postObj, $arr)
{
    $toUser = $postObj->FromUserName;
    $fromUser = $postObj->ToUserName;
    $createTime = time();
    $MsgType = 'news';
    $template = '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><ArticleCount>' . count($arr) . '</ArticleCount><Articles>';
    foreach ($arr as $key => $value) {
        $template .= '<item><Title><![CDATA[' . $value["title"] . ']]></Title><Description><![CDATA[' . $value["description"] . ']]></Description><PicUrl><![CDATA[' . $value["picUrl"] . ']]></PicUrl><Url><![CDATA[' . $value["url"] . ']]></Url></item>';
    }
    $template .= '</Articles></xml>';
    $info = sprintf($template, $toUser, $fromUser, $createTime, $MsgType, $content);
    echo $info;
}

// 自动回复（单图文）
function replyOnePicAndText($postObj, $arr)
{
    $toUser = $postObj->FromUserName;
    $fromUser = $postObj->ToUserName;
    $createTime = time();
    $MsgType = 'news';
    $template = '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><ArticleCount>' . count($arr) . '</ArticleCount><Articles>';
    foreach ($arr as $key => $value) {
        $template .= '<item><Title><![CDATA[' . $value["title"] . ']]></Title><Description><![CDATA[' . $value["description"] . ']]></Description><PicUrl><![CDATA[' . $value["picUrl"] . ']]></PicUrl><Url><![CDATA[' . $value["url"] . ']]></Url></item>';
    }
    $template .= '</Articles></xml>';
    $info = sprintf($template, $toUser, $fromUser, $createTime, $MsgType, $content);
    echo $info;
}

// 自动回复（纯文本）
function replyOnlyText($postObj, $content)
{
    $template = '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><Content><![CDATA[%s]]></Content></xml>';
    $toUser = $postObj->FromUserName;
    $fromUser = $postObj->ToUserName;
    $createTime = time();
    $MsgType = 'text';
    $info = sprintf($template, $toUser, $fromUser, $createTime, $MsgType, $content);
    echo $info;
}

function http_curl($url, $type = "get", $res = "json", $arr = "")
{
    $ch = curl_init();
    //执行HTTP请求
    curl_setopt($ch, CURLOPT_URL, $url);
    //若不为1，curl_exec将直接输入结果而不能保存到变量
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //有时漏了ssl_verifypeer这条，一直返回false;
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    if ($type == "post") {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
    }
    $output = curl_exec($ch);
    curl_close($ch);
    if ($res == "json") {
        if (curl_errno($ch)) {
            return curl_error($ch);
        } else {
            return json_decode($output, true);       //转换成数组
        }
    }
}

// 获取微信的access_token
function getWxAccessToken()
{
    if ($_SESSION["access_token"] && $_SESSION["expire_time"] > time()) {
        return $_SESSION["access_token"];
    } else {
        $appid = C('APPID');
        $appsecret = C('AppSecret');
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
        $res = http_curl($url, "get", "json");
        //var_dump($res);exit;
        $access_token = $res["access_token"];
        $_SESSION["access_token"] = $access_token;
        $_SESSION["expire_time"] = time() + 7200;
        return $access_token;
    }
}

// 获取微信公众测试号的access_token
function getWxTestAccessToken()
{
    if ($_SESSION["access_token_test"] && $_SESSION["expire_time"] > time()) {
        return $_SESSION["access_token_test"];
    } else {
        $appid = C('testAPPID');
        $appsecret = C('testAppSecret');
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
        $res = http_curl($url, "get", "json");
        //var_dump($res);exit;
        $access_token = $res["access_token"];
        $_SESSION["access_token_test"] = $access_token;
        $_SESSION["access_token_test"] = time() + 7200;
        return $access_token;
    }
}


