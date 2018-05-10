<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <script src="http://cdn.static.runoob.com/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js" type="text/javascript" charset="utf-8"></script>

  </head>
  <body>
    <div class="payone"></div>
    <script type="text/javascript">
      $(document).ready(function(){
        share();
      });

      function share () {
        wx.config(<?php echo $config; ?>);
        wx.ready(function () {
          wx.onMenuShareAppMessage({
            title: 'asdfsasdfsdf', // 分享标题
            desc: 'asdfdsfsdfdsfadsf', // 分享描述
            link: 'http://baidu.com', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: 'https://ss0.baidu.com/73x1bjeh1BF3odCf/it/u=843068134,1598687555&fm=85', // 分享图标
            type: 'link', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
            alert('success')
            },
            cancel: function () {
            // 用户取消分享后执行的回调函数
            }
          });
        });
      }

  </script>
  </body>
</html>
