<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', '联文') _学信检测</title>
  <!-- Styles -->
  <!-- <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/> -->


  <link href="{{asset('asset/css/styles.css')}}" rel="stylesheet"/>
  <link rel="stylesheet" href="{{asset('asset/css/jquery-confirm.css')}}">
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  <link href="{{asset('asset/css/toast-min.css')}}" rel="stylesheet" />

  <style>
    .newbody {
      height: 100%;
      margin-bottom: 0;
      user-select: auto;
      padding-right:0 !important;
    }

    .newmain {
      display: flex;
      flex-direction: column;
      height: 100%;
    }
    .alertify-notifier.ajs-top {
      top: 89px;
    }
    .alertify-notifier .ajs-message.ajs-visible {
      padding: 8px;
    }
    .ajs-message.ajs-custom { color: #67c23a;background-color: #f0f9eb;border-color: #e1f3d8;}
  </style>
  @yield('styles')
  <script>
    var _hmt = _hmt || [];
    (function () {
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
          window.location.href = 'https://m.checklike.com/p';
          break;
        }
      }
    }
  </script>
</head>

<body class="newbody">
<div id="app" class="{{ route_class() }}-page newmain">

  @include('layouts._header')


  @include('shared._messages')

  @yield('content')


  @include('layouts._footer')
</div>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
<script type="text/javascript" src="{{asset('asset/js/jquery-confirm.js')}}"></script>
<script type="text/javascript" src="{{asset('asset/js/toast.js')}}" ></script>

@yield('scripts')
<script !src="">
console.log({!!router!!})
  //退出登录
  toastr.options = {
    positionClass: "toast-center-center",
    timeOut:1500 // 超时时间，即窗口显示的时间
  }
  $('.logout').click(() => {
    $.confirm({
        title: '提示',
        content: '您确认要退出登录吗?',
        buttons: {
            ok: {
                text: '确认',
                btnClass:  'btn-danger',
                action: function() {
                  axios.post('{{route('logout')}}').then(res => {
                     swal("提示","退出成功", "success");
                     location.replace('https://p.checklike.com')
                  })
                }
            },
            cancel: {
                text: '取消',
                btnClass: 'btn-info'
            }
        }
    });
  });
  $("#xiugai").click(()=>{
    $("#staticXiugai").modal("show")
  })
  $("#xiugaicancel").click(()=>{
    $("#staticXiugai").modal("hide")
  })
  // $("#bindSelfPhone").click(()=>{
  //   $("#bindTitle").modal("show")
  // })
  // var currentCode="";
  $("#sendYzCode").click(()=>{
    let isYZphone =$("#bindphonenum").val();
    console.log(isYZphone)
    if(!(/^1[3456789]\d{9}$/.test(isYZphone))){
        $("#bindphoneTip").text("请输入正确手机号")
        return false;
    }else{
      $("#bindphoneTip").text("")
      let count = 60;
      const countDown = setInterval(() => {
      if (count === 0) {
       $("#sendYzCode").text('重新发送').removeAttr('disabled');
       clearInterval(countDown);
      } else {
       $("#sendYzCode").attr('disabled', true);
       $("#sendYzCode").text(count +' '+'S');
      }
      count--;
     }, 1000)
      axios.post('https://p.checklike.com/api/v1/verificationCodes', {
          phone: isYZphone,
        }).then(res => {
          if(res.data&&res.data.key){
            currentCode=res.data.key
          }
        })
    }
  })
  // $("#bindnow").click(()=>{
  //   axios.put("https://p.checklike.com/bond_phone",{
  //     verification_key:currentCode,
  //     verification_code:$("#bindCodeNow").val()
  //   }).then(res=>{
  //     swal("绑定成功", {
  //       icon: "success",
  //     }).then(willDelete => {
  //       $("#bindTitle").modal("hide")
  //       location.replace('https://p.checklike.com')
  //     });
  //   }).catch(err=>{
  //     console.log(err,"fsadfjdsafjdsajfj")
  //   })
  // })
  // $("#bindno").click(()=>{
  //   $("#bindTitle").modal("hide")
  // })
  //
  var registerCode="";
  $("#RegisterDialogBtn").click(()=>{
    console.log("xixi，点击了")
    $("#registerTcDialog").modal("show")
    $("#sendRegisterYzCode").click(()=>{
    let iszcphone =$("#registerphones").val();
    console.log(iszcphone)
    if(!(/^1[3456789]\d{9}$/.test(iszcphone))){
        $("#registerTip").text("请输入正确手机号")
        return false;
    }else{
      $("#registerTip").text("")
      let counts = 60;
      const clearDown = setInterval(() => {
      if (counts === 0) {
       $("#sendRegisterYzCode").text('重新发送').removeAttr('disabled');
       clearInterval(clearDown);
      } else {
       $("#sendRegisterYzCode").attr('disabled', true);
       $("#sendRegisterYzCode").text(counts +' '+'S');
      }
      count--;
    }, 1000)
    axios.post('https://p.checklike.com/api/v1/verificationCodes', {
      phone: iszcphone,
    }).then(res => {
        if(res.data&&res.data.key){
          registerCode=res.data.key
        }
      })
    }
  })
})
  $("#registerphones").blur(()=>{
    axios.post('https://p.checklike.com/api/v1/check-phone', {
          phone: $('#registerphones').val(),
        }).then(res => {
          console.log(res,"xii")
          alertify.set('notifier','position', 'top-center');
          alertify.success(res.data.message)
        }).catch(err=>{
          console.log(err.response.data,"fafdd")
          alertify.set('notifier','position', 'top-center');
          alertify.warning(err.response.data.message)

        })
  })
  $('#submitRegisterBtn').click(() => {
            axios.post('{{route('register')}}', {
              'verification_key': registerCode,
              'phone': $('#registerphones').val(),
              'password': $('#registerpassword').val(),
              'password_confirmation': $('#password_confirmation').val(),
              'verification_code': $('#bindCoderegister').val()
            }).then(res => {
              swal("注册成功!");
              location.href = '{{route('home.index')}}'
            }).catch(err => {
              if (err.response.status == 422) {
                // $('#message').show();
                // $.each(err.response.data.errors, (field, errors) => {
                //   $('#message').append('<strong>' + errors + '</strong> </br>');
                // })
                $.each(err.response.data.errors, (field, errors) => {
                  $("#registerTip").text(errors)
                })
              }
              console.log(err,"注册")
            })
  })
</script>
</body>

</html>
