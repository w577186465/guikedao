<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    </head>
    <body>
      <script type="text/javascript">
        !function () {
          var message = @json($message);
          if (message.status === 'success') {
            window.localStorage.openid = message.openid
            window.location.href = '{{$reffer}}'
          } else if (message.status === 'error') {
            alert(message.message)
            window.location.href = '/register'
          } else {
            alert('注册失败，请重试。')
            window.location.href = '/register'
          }
        }()
      </script>
    </body>
</html>