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
          window.localStorage.openid = message.data
          window.location.href = '{{$reffer}}'
        } else {
          window.location.href = '/register?reffer={{$reffer}}'
        }
      }()
    </script>
  </body>
</html>
