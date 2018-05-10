<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <!-- <script src="http://cdn.static.runoob.com/libs/jquery/1.10.2/jquery.min.js"></script> -->
    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js" type="text/javascript" charset="utf-8"></script>

  </head>
  <body>
    <div class="payone"></div>
    <script type="text/javascript">
      wx.config(<?php echo $config; ?>);
      wx.ready(function () {
      // wx.openAddress({
      //   success: function (res) {
      //     alert(JSON.stringify(res));
      //     document.form1.address1.value         = res.provinceName;
      //     document.form1.address2.value         = res.cityName;
      //     document.form1.address3.value         = res.countryName;
      //     document.form1.detail.value           = res.detailInfo;
      //     document.form1.national.value         = res.nationalCode;
      //     document.form1.user.value            = res.userName;
      //     document.form1.phone.value            = res.telNumber;
      //     document.form1.postcode.value         = res.postalCode;
      //     document.form1.errmsg.value         = res.errMsg;
      //     document.form1.qq.value             = 1354386063;
      //   }
      // });

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
  </script>
  </body>
</html>
