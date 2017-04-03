<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2017/4/3
 * Time: 21:09
 */

function responseMsg($postObj, $arr)
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
    $info = sprintf($template, $toUser, $fromUser, $time, $MsgType, $content);
    echo $info;
}