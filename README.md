# weixin_develop
视频学习地址：http://www.imooc.com/u/197650/courses?sort=publish

订阅号<br>
服务号<br>
企业号<br>

微信公众号管理地址 => http://mp.weixin.qq.com<br>
用户名 => 488703045@qq.com<br>

编辑模式和开发者模式<br>
编辑模式下的自动回复功能<br>
开发 => 基本配置 => 服务器配置(未启用)<br>
进入公众号，输入“vdouw|imooc”，自动回复“zhangsanfeng|hello weixin”<br>
编辑模式不常用，开发者模式才是我们学习的重点<br>

微信只接受80端口<br>

接入微信公众账号API 验证配置<br>
代码详见：http://weixin.vdouw.com/index.php/home/index/index<br>
接入概述<br>
接入微信公众平台开发，开发者需要按照如下步骤完成：<br>
1、填写服务器配置<br>
2、验证服务器地址的有效性<br>
3、依据接口文档实现业务逻辑<br>
文档详见：https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421135319<br>

TP5接口 http://wx_tp5.vdouw.com/index.php/home/index/index<br>
TP3接口 http://wx_tp3.vdouw.com/index.php/home/index/index<br>
经过改变微信的服务器配置，发现TP5的代码验证不了，虽然是一样的代码<br>

接收事件推送<br>
在微信用户和公众号产生交互的过程中，用户的某些操作会使得微信服务器通过事件推送的形式通知到开发者在开发者中心处设置的服务器地址，从而开发者可以获取到该信息。<br>
详细查看：https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140454<br>
比如：关注/取消关注事件<br>

被动回复用户消息<br>
当用户发送消息给公众号时，会产生一个POST请求，开发者可以在响应包（Get）中返回特定XML结构，来对该消息进行响应。<br>
详细查看：https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140543<br>
比如：用户输入“imooc”，自动回复“imooc is good”<br>








URL(服务器地址)
Token(令牌) study_weixin_dev
EncodingAESKey(消息加解密密钥) HA0VzlwMs4SnN4sRfGBLeSMJxVkYkPJNR3QbQPsbK3F
消息加解密方式 兼容模式

微信公众平台测试帐号









