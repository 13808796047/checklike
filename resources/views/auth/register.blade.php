@extends('domained::layouts.app')
@section('styles')

  <link href="{{asset('asset/css/bootstrap.css')}}" rel="stylesheet"/>
  <link href="{{asset('asset/css/theme.css')}}" rel="stylesheet"/>
  <link href="{{asset('asset/css/alertify.css')}}" rel="stylesheet"/>
  <link href="{{asset('asset/css/index.css')}}" rel="stylesheet"/>
  <style>
    .curfont {
      font-size: 16px;
    }
  </style>
@stop

@section('content')

  <div class="main clearfix" style="background:#fff">
    <div style="padding:25px 500px;">
      <div>
        <div class="alert alert-danger" role="alert" id="message" style="display: none">
        </div>
        <form action="{{route('register')}}" method="post" accept-charset="utf-8">
        @csrf
        <!--	<div style="padding:10px 0">
                          <a style="" href="#" class="btn btn-large btn-block btn-primary"><i class="icon-facebook-sign"></i> 使用QQ关联注册</a>
                      </div>
                       <br>
                      <legend style="font-size: 16px; color:#555;" class=""><i class="icon-envelope"></i> 您也可以使用邮箱注册</legend> -->
          <div class="control-group" style="margin-bottom: 13px;">
            <label for="phone">手机号码:</label>
            <div class="controls"><input type="text" name="phone" value="{{old('phone')}}" id="phone"
                                         placeholder="请输入手机号码"
                                         style="border: 1px solid #ccc;font-size: 17px;height: 39px;padding-left: 10px;"
                                         class="btn-block">
              @error('phone')
              <span class="invalid-feedback" role="alert" style="display: block">
                                        <strong>{{ $message }}</strong>
                                    </span>
              @enderror
              <span class="invalid-feedback" role="alert" style="display: block">
                                        <strong></strong>
                                    </span>
            </div>

          </div>
          <div class="control-group" style="margin-bottom: 13px;">
            <label for="password">密码:</label>
            <div class="controls"><input type="password" name="password" value="{{old('password')}}"
                                         id="password"
                                         class="btn-block" placeholder="请输入密码"
                                         style="border: 1px solid #ccc;font-size: 17px;height: 39px;padding-left: 10px;">
              @error('password')
              <span class="invalid-feedback" role="alert" style="display: block">
                                        <strong>{{ $message }}</strong>
                                    </span>
              @enderror
            </div>
          </div>
          <div class="control-group" style="margin-bottom: 13px;">
            <label for="password-confirm">重复密码:</label>
            <div class="controls"><input type="password" name="password_confirmation" value=""
                                         id="password-confirm"
                                         class="btn-block" placeholder="请输入确认密码"
                                         style="border: 1px solid #ccc;font-size: 17px;height:39px;padding-left:10px;">
            </div>
          </div>

          {{--                  <div class="control-group " style="display: none">--}}
          {{--                    <label for="email">邮箱:</label>--}}
          {{--                    <div class="controls"><input type="text" name="email" value="" id="email" class="btn-block">--}}
          {{--                    </div>--}}
          {{--                  </div>--}}

          {{--                  <div class="control-group ">--}}
          {{--                    <label for="phone">手机:</label>--}}
          {{--                    <div class="controls"><input type="text" name="phone" value="" id="phone" class="btn-block">--}}
          {{--                    </div>--}}
          {{--                  </div>--}}
          {{--                  <div id="sjh" style="color:red;display: none">手机号已存在</div>--}}
          <div class="control-group" style="margin-bottom: 13px;">
            <label for="phone">验证码:</label>
            <div class="controls"><input type="text" name="code" value="" id="code"
                                         placeholder="请输入验证码"
                                         style="border:1px solid #ccc;font-size:17px;height:39px;padding-left:10px;">
              <input type="button" value="获取验证码"
                     style="margin-bottom: 10px;font-size: 14px;line-height: 20px;height:30px;background:#7CCD7C;color:#fff;padding:0 20px;"
                     id="yzm"
              >
            </div>
          </div>


          <button type="button" class="btn btn-large btn-block" id="submitBtn" style="background:#26AEF2;color:#fff;">
            提交注册
          </button>
        </form>
      </div>
    </div>
    @endsection
    @section('scripts')
      <script !src="">
        $(() => {
          var wait = 60;
          var verification_key = '';

          function time(o) {
            if (wait == 0) {
              o.removeAttribute("disabled");
              o.value = "点击获取验证码";
              wait = 60;
            } else {
              o.setAttribute("disabled", true);
              o.value = "重新发送(" + wait + ")";
              wait--;
              setTimeout(function () {
                  time(o)
                },
                1000)
            }
          }

          function getcode(index) {
            index.setAttribute("disabled", true);
            var phone = $("input[name='phone']").val();
            var reg = /^1[345678]\d{9}$/;
            if (!reg.test(phone)) {
              index.removeAttribute("disabled");
              $("input[name='phone']").focus();
              $('#message').show();
              $('#message').html('<strong>请输入正确的手机号码</strong>');
              return;
            }
            axios.post('/api/v1/verificationCodes', {
              phone: phone,
            }).then(res => {
              swal('验证码已发送成功!,请注意查收!')
              time(index);
              verification_key = res.data.key;
            }).catch(err => {
              index.removeAttribute("disabled");
              if (err.response.status == 422) {
                $('#message').show();
                $.each(err.response.data.errors, (field, errors) => {
                  $('#message').html('<strong>' + errors[0] + '</strong>');
                })
              }
            })
          }

          $('#yzm').click(function () {
            getcode(this)
          })

          //
          $('#submitBtn').click(() => {
            axios.post('{{route('register')}}', {
              'verification_key': verification_key,
              'phone': $('#phone').val(),
              'password': $('#password').val(),
              'password_confirmation': $('#password-confirm').val(),
              'verification_code': $('#code').val()
            }).then(res => {
              swal("注册成功!");
              location.href = '{{route('pages.index')}}'
            }).catch(err => {
              if (err.response.status == 422) {
                $('#message').show();
                $.each(err.response.data.errors, (field, errors) => {
                  $('#message').append('<strong>' + errors + '</strong> </br>');
                })
              }
            })
          })
        })
      </script>
@stop
