<!DOCTYPE html>
<html>
  <head>
    <title>asdfsdfdsfdsff</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <script src="http://cdn.static.runoob.com/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>

  </head>
  <body>
    <button id="check">检查</button>
    <button id="share">分享</button>
    <script type="text/javascript">
      wx.config(<?php echo $config; ?>);
      wx.ready(function () {
        $('#check').click(function () {
          wx.checkJsApi({
            jsApiList: [
              'getNetworkType',
              'previewImage'
            ],
            success: function (res) {
              alert(JSON.stringify(res));
            }
          });
        });
        $('#share').click(function () {
          wx.onMenuShareAppMessage({
            title: '互联网之子',
            desc: '在长大的过程中，我才慢慢发现，我身边的所有事，别人跟我说的所有事，那些所谓本来如此，注定如此的事，它们其实没有非得如此，事情是可以改变的。更重要的是，有些事既然错了，那就该做出改变。',
            link: 'http://quan.localhost/server/quan/share',
            imgUrl: 'http://zunyu.weixin.dlwanglong.com/static/img/share-tip.5c402c3.jpg',
            trigger: function (res) {
              // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
              alert('用户点击发送给朋友');
            },
            success: function (res) {
              alert('已分享');
            },
            cancel: function (res) {
              alert('已取消');
            },
            fail: function (res) {
              alert(JSON.stringify(res));
            }
          });
          alert('已注册获取“发送给朋友”状态事件');
        })
      })

  </script>
  </body>
</html>
