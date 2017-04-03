<?php
/**
 * Created by PhpStorm.
 * User: sf
 * Date: 2017/4/3
 * Time: 21:09
 */

function responseMsg($postObj)
{
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
}