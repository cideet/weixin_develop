<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/6 0006
 * Time: 09:59
 */

/**
 * 订阅
 * @param $postObj
 */
function subscribe($postObj){
    $toUser = $postObj->FromUserName;
    $fromUser = $postObj->ToUserName;
    $time = time();
    $MsgType = 'text';
    $content = '欢迎你，' . $toUser . '关注我的公众号' . $fromUser;
    $template = '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><Content><![CDATA[%s]]></Content></xml>';
    $info = sprintf($template, $toUser, $fromUser, $time, $MsgType, $content);
    echo $info;
}

/**
 * 自动回复（纯文本）
 * @param $postObj
 * @param $content
 */
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

/**
 * 自动回复（图文）
 * @param $postObj
 * @param $arr
 */
function replyPicAndText($postObj, $arr)
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
    $info = sprintf($template, $toUser, $fromUser, $createTime, $MsgType);
    echo $info;
}



