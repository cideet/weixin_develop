# weixin_develop
视频学习地址：http://www.imooc.com/u/197650/courses?sort=publish

订阅号 <br>
服务号 <br>
企业号 <br>

微信公众号管理地址 => http://mp.weixin.qq.com <br>
用户名 => 488703045@qq.com <br>

全局返回码说明 https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1433747234  <br>

编辑模式和开发者模式 <br>
编辑模式下的自动回复功能 <br>
开发 => 基本配置 => 服务器配置(未启用) <br>
进入公众号，输入“vdouw|imooc”，自动回复“zhangsanfeng|hello weixin” <br>
编辑模式不常用，开发者模式才是我们学习的重点 <br>

微信只接受80端口 <br>

接入微信公众账号API 验证配置 <br>
代码详见：http://weixin.vdouw.com/index.php/home/index/index <br>
接入概述 <br>
接入微信公众平台开发，开发者需要按照如下步骤完成： <br>
1、填写服务器配置 <br>
2、验证服务器地址的有效性 <br>
3、依据接口文档实现业务逻辑 <br>
文档详见：https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421135319 <br>

TP5接口 http://wx_tp5.vdouw.com/index.php/home/index/index <br>
TP3接口 http://wx_tp3.vdouw.com/index.php/home/index/index <br>
测试号接口（TP3） http://wx_tp3.vdouw.com/index.php/home/testaccount/index  <br>
经过改变微信的服务器配置，发现TP5的代码验证不了，虽然是一样的代码 <br>

接收事件推送 <br>
在微信用户和公众号产生交互的过程中，用户的某些操作会使得微信服务器通过事件推送的形式通知到开发者在开发者中心处设置的服务器地址，从而开发者可以获取到该信息。 <br>
详细查看：https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140454 <br>
比如：关注/取消关注事件 <br>

被动回复用户消息 <br>
当用户发送消息给公众号时，会产生一个POST请求，开发者可以在响应包（Get）中返回特定XML结构，来对该消息进行响应。 <br>
详细查看：https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140543 <br>
比如：用户输入“imooc”，自动回复“imooc is good” <br>

AppID: wx4e034056598d48d6 <br>
AppSecret: 0d18631d78954d10f00eaec3a8a56c0f <br>

php的curl函数组可以帮助我们把机器伪装成人的行为来抓取网站 <br>
http_curl测试1:  <br>
http://wx_tp3.vdouw.com/index.php/home/index/http_curl_test1 <br>

获取access_token <br>
详细查看 https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140183 <br>
测试地址 http://wx_tp3.vdouw.com/index.php/home/index/getWxAccessToken_test1 <br>

获取微信服务器IP地址 <br>
如果公众号基于安全等考虑，需要获知微信服务器的IP地址列表，以便进行相关限制，可以通过该接口获得微信服务器IP地址列表或者IP网段信息。 <br>
详细查看 https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140187 <br>
测试查看 http://wx_tp3.vdouw.com/index.php/home/index/getWxServerIp_test1 <br>

第三方查询接口在微信中的使用 <br>
根据城市名查询当地天气，测试方法：输入“天气”即可。 <br>
扩展到获取用户输入：urlencode($postObj->Content) <br>

公众号接口权限说明 <br>
详细查看 https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1433401084 <br>

自定义菜单 <br>
详细查看 https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421141013 <br>
一级菜单最多3个，二级菜单最多5个 <br>
设置URL http://wx_tp3.vdouw.com/index.php/home/testaccount/custommenu <br>
个性化菜单接口 https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1455782296  <br>
自定义菜单中的click事件，
EventKey：事件KEY值，由开发者在创建菜单时设定 <br>

群发接口 <br>
预览接口 https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1481187827_i0l21 <br>
测试地址 http://wx_tp3.vdouw.com/index.php/home/testaccount/sendMsgAll <br>
根据OpenID列表群发【订阅号不可用，服务号认证后可用】  <br>

模板消息 <br>
查看详细 https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1433751277 <br>
不同的行业，有不同的模板 <br>
正式的公众号，模板需要单独去申请 <br>
可以申请到15个模板 <br>
一个账号当日发送模板消息次数不能超过10次 <br>
测试地址 http://wx_tp3.vdouw.com/index.php/home/Testaccount/sendTemplateMsg <br>

微信网页授权 <br>
查看详细 https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140842 <br>
网页授权获取用户基本信息=>修改=>授权回调页面域名 填入：wx_tp3.vdouw.com <br>
草料二维码中输入 http://wx_tp3.vdouw.com/index.php/home/Testaccount/getUserBaseInfo <br>
微信扫描，即可得到用户的基本信息  <br>
草料二维码中输入 http://wx_tp3.vdouw.com/index.php/home/Testaccount/getUserInfo <br>
微信扫描，即可得到用户信息  <br>
比如我们在做一个活动，每个用户只能抽奖3次。 <br>
用户进入getUserBaseInfo页面，经跳转到getUserOpenId页面。 <br>
在$ret中可以获取到用户的openid，再从数据库中获取该用户参加抽奖的次数，后续的操作你应该懂了吧。 <br>

微信SDK <br>
微信JS-SDK说明文档 https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421141115 <br>
微信公众平台向网页开发者提供的基于微信内的网页开发工具包，比如分享给朋友，分享到朋友圈 <br>
1、绑定域名 点击“JS接口安全域名”的编辑按钮 <br>
2、引入JS文件 http://res.wx.qq.com/open/js/jweixin-1.2.0.js <br>
3、通过config接口注入权限难配置 <br>
4、通过ready接口处理成功验证 <br>
5、通过error接口处理失败验证 <br>
jsapi_ticket是公众号用于调用微信JS接口的临时票据 <br>
分享给朋友测试地址 http://wx_tp3.vdouw.com/index.php/home/testaccount/share <br>
分享到朋友圈测试地址 http://wx_tp3.vdouw.com/index.php/home/testaccount/share <br>
拍照或从手机相册中选图接口 http://wx_tp3.vdouw.com/index.php/home/testaccount/share <br>




















<br> <br> <br> <br> <br> <br>
URL(服务器地址)
Token(令牌) study_weixin_dev
EncodingAESKey(消息加解密密钥) HA0VzlwMs4SnN4sRfGBLeSMJxVkYkPJNR3QbQPsbK3F
消息加解密方式 兼容模式

微信公众平台测试帐号









