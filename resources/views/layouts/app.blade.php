<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', '联文') _维普论文检测系统</title>

  <!-- Styles -->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  <style>
    .newbody{
      height:100%;
      margin-bottom:0;
      user-select: auto;
    }
    .newmain{
      display:flex;
      flex-direction:column;
      height:100%;
    }
  </style>
  @yield('styles')
  <script>
    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?8c167fa6441cd7b5d0a1cb99cccf9fe8";
      var s = document.getElementsByTagName("script")[0];
      s.parentNode.insertBefore(hm, s);
    })();
    //H5移动版自适应跳转js
    var mobileAgent = new Array("iphone", "ipod", "ipad", "android", "mini", "mobile", "mobi", "mqqbrowser", "blackberry",
      "webos", "incognito", "webmate", "bada", "nokia", "symbian", "wp7", "wp8", "lg", "ucweb", "skyfire");
    var browser = navigator.userAgent.toLowerCase();
    var _tag = "{$_GET['tag']}";
    if (_tag != 'web') {
      for (var i = 0; i < mobileAgent.length; i++) {
        if (browser.indexOf(mobileAgent[i]) != -1) {
          window.location.href = 'https://wap.lianwen.com/weipu';
          break;
        }
      }
    }
  </script>
</head>

<body class="newbody" >
<div id="app" class="{{ route_class() }}-page newmain">

  @include('domained::layouts._header')


  @include('domained::shared._messages')

  @yield('content')


  @include('domained::layouts._footer')
</div>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
@yield('scripts')
<script !src="">
  //退出登录
  $('.logout').click(() => {
    swal({
      title: "您确认要退出登录吗?",
      icon: "warning",
      buttons: ['取消','确定'],
      dangerMode: true,
    })
      .then((willDelete) => {
        if (willDelete) {
          console.log('xixi')
          axios.post('{{route('logout')}}').then(res => {
            swal("注销成功!", {
              icon: "success",
            }).then(willDelete => {
              // console.log(willDelete,42)
              // location.reload();
              location.replace('https://weipu.lianwen.com')
            });
          })
        }
      });
  });
</script>
</body>

</html>
