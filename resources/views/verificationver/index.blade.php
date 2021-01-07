@extends('layouts.app')
@section('title','报告验真')
@section('styles')
<style>
.vpcs-banner{
  width: 100%;
  height: 331px;
  background: url("/asset/images/bgyz.jpg") no-repeat center;
}
.vpcs-banner-srk {
    position: relative;
    width: 1200px;
    margin: auto;
}
.vpcs-banner-sr-span {
    position: absolute;
    top: 260px;
    height: 50px;
    display: block;
    line-height: 50px;
    left: 320px;
    color: #fff;
}
.vpcs-banner-sr-input {
    position: absolute;
    top: 260px;
    left: 410px;
    background: #fff;
    outline: none;
    line-height: 50px;
    padding: 0 10px;
    width: 360px;
    height: 50px;
    border: 0;
}
.vpcs-banner-sr-button {
    position: absolute;
    outline:none;
    top: 260px;
    left: 810px;
    width: 100px;
    height: 50px;
    line-height: 50px;
    text-align: center;
    background: #ff3b2e;
    color: #fff;
    outline: none;
    font-size: 16px;
    border: 0;
    cursor: pointer;
    transition: background ease .3s;
}
.vpcs-main {
    width: 1200px;
    min-height: 480px;
    margin: auto;
}
.vpcs-bgyz-jg {
    text-align: center;
    width: 100%;
    color: #ff2b3e;
    padding-top: 30px;
}
.vpcs-bgyz-table {
    width: 1198px;
    border: 1px solid #eaeaea;
    margin-top: 30px;
}
.vpcs-bgyz-table tr td {
    height: 44px;
    line-height: 44px;
    border-bottom: 1px solid #eaeaea;
}
.vpcs-bgyz-table-title {
    border-right: 1px solid #eaeaea;
    width: 200px;
    text-align: right;
    padding-right: 10px;
    background: #f7f7f7;
    color: #6f747a;
}
.vpcs-bgyz-table-content {
    padding-left: 10px;
    width:1000px;
}
button:focus {
  border: 0 none;
  outline: none;
}

</style>
@stop
@section('content')
@guest
    <div class="modal fade" id="staticBackdrop"  tabindex="-1" role="dialog"
         aria-labelledby="staticBackdropLabel" >
      <div class="modal-dialog modal-dialog-centered" role="document" style="width:330px;height:390px;">
        <div class="modal-content" style="width:330px;height:390px;">
            <ul class="nav nav-pills d-flex justify-content-center" id="pills-tab" role="tablist" style="margin:3px 0;">
              <li class="nav-item mr-4">
                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                   aria-controls="pills-home" aria-selected="true">微信登录</a>
              </li>
              <li class="nav-item mr-4">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                   aria-controls="pills-profile" aria-selected="false">手机号登录</a>
              </li>
            </ul>
            <div class="tab-content" id="pills-tabContent" style="margin:17px 0;">
              <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
              <div style="width:270px;height:270px;margin: 0 auto;">
								<div style="color: #999;font-size: 13px;text-align: center;">
									微信扫一扫 享免费检测
								</div>
								<div style="margin: 5px 0;">
                <div id="loginIcon">
                <div class="d-flex justify-content-center" style="width:200px;height:200px;position:relative;margin:0 auto;" >
                    <div class="spinner-border" role="status" style="position:absolute;top:95px;">
                                <span class="sr-only">Loading...</span>
                </div>
                </div>
                </div>

									<img src=""
									 id="qrimg" style="width:200px;height:200px;margin: 0 auto;display: none;">
								</div>
								<div style="color: #999;font-size: 13px;text-align: center;">
									无需注册，关注后自动登录
								</div>
							</div>
              </div>
              <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                  <div style="padding:0 17px;">
                    <div>
                      <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">
                        手机号:
                      </label>
                      <input
                        class="appearance-none border rounded w-full py-2 px-3 mb-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        name="phone"
                        id="phone" type="text" placeholder="请输入手机号码" value="{{ old('phone') }}">
                    </div>
                    <div>
                      <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        密码:
                      </label>
                      <input
                        class="appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                        name="password"
                        id="password" type="password" placeholder="请输入密码" value="{{ old('password') }}">
                    </div>
                    <div class="flex items-center justify-between my-4">
                      <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 w-full px-4 rounded focus:outline-none focus:shadow-outline"
                        type="button" id="accountLogin" style="text-align:center;border:none;">
                        登录
                      </button>
                    </div>
                    <div style="display: flex;justify-content: space-between;color: #999;">
                       <p id="forgetpsw" style="font-size:15px;font-weight:bold;">忘记密码</p>
                       <a class="block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" id="quiklyRegister" style="font-size:15px;font-weight:bold;">
                          立即注册
                        </a>
                    </div>
                  </div>
              </div>
            </div>

            {{--          @else--}}
            {{--            <div class="flex flex-col align-middle">--}}
            {{--              <div class=" text-center  px-4 py-2 m-2">欢迎您</div>--}}
            {{--              <div class=" text-center  px-4 py-2 m-2"><img--}}
            {{--                  src='{{Auth::user()->avatar??'https://css.lianwen.com/images/head.jpg'}}' class='w-50 h-50 m-auto'>--}}
            {{--              </div>--}}
            {{--              <div--}}
            {{--                class=" text-center  px-4 py-2 m-2">{{auth()->user()->phone??auth()->user()->nickname}}</div>--}}
            {{--              <div class=" text-center  px-4 py-2 m-2">--}}
            {{--                <a href="javascript:;"--}}
            {{--                   class="rounded-sm logout text-decoration-none w-100 inline-block py-1 bg-teal-500 hover:bg-teal-600 md:text-lg xl:text-base text-white font-semibold  shadow-md">退出登录</a>--}}
            {{--              </div>--}}
            {{--            </div>--}}
          <!-- <div class="modal-footer" style="justify-content: space-between;">
            <div style="display: flex;align-items: center;">
              <p class="text-sm">社交账号登录</p>
              <a href="{{route('oauth',['type'=>'wechat'])}}" id="toWechat" class="block mr-4"
                 style="padding-left:23px">
                <svg t="1585367706568" class="icon" viewBox="0 0 1024 1024" version="1.1"
                     xmlns="http://www.w3.org/2000/svg" p-id="1112" width="24" height="24">
                  <path
                    d="M347.729118 353.0242c-16.487119 0-29.776737 13.389539-29.776737 29.776737S331.241998 412.677596 347.729118 412.677596s29.776737-13.389539 29.776737-29.776737-13.289617-29.876659-29.776737-29.876659zM577.749415 511.800156c-13.689305 0-24.880562 11.091335-24.880563 24.880562 0 13.689305 11.091335 24.880562 24.880563 24.880562 13.689305 0 24.880562-11.191257 24.880562-24.880562s-11.191257-24.880562-24.880562-24.880562zM500.909446 412.677596c16.487119 0 29.776737-13.389539 29.776737-29.776737s-13.389539-29.776737-29.776737-29.776737c-16.487119 0-29.776737 13.389539-29.776737 29.776737s13.289617 29.776737 29.776737 29.776737zM698.455113 511.600312c-13.689305 0-24.880562 11.091335-24.880562 24.880562 0 13.689305 11.091335 24.880562 24.880562 24.880562 13.689305 0 24.880562-11.091335 24.880562-24.880562-0.099922-13.689305-11.191257-24.880562-24.880562-24.880562z"
                    fill="#00C800" p-id="1113"></path>
                  <path
                    d="M511.601093 0.799375C229.12178 0.799375 0.000781 229.820453 0.000781 512.399688s229.021077 511.600312 511.600312 511.600312 511.600312-229.021077 511.600312-511.600312S794.180328 0.799375 511.601093 0.799375z m-90.229508 634.504294c-27.37861 0-49.361436-5.595628-76.839969-10.991413l-76.640125 38.469945 21.882904-65.948477c-54.957065-38.370023-87.73146-87.831382-87.73146-148.084309 0-104.318501 98.722873-186.554254 219.32865-186.554255 107.815769 0 202.34192 65.648712 221.327088 153.979703-6.994536-0.799375-13.989071-1.298985-21.083529-1.298985-104.118657 0-186.454333 77.739266-186.454332 173.564403 0 15.98751 2.498048 31.275566 6.794692 45.964091-6.794692 0.599532-13.689305 0.899297-20.583919 0.899297z m323.547228 76.839969l16.48712 54.757221-60.153006-32.874317c-21.882904 5.495706-43.965652 10.991413-65.848555 10.991413-104.318501 0-186.554254-71.344262-186.554255-159.175644 0-87.631538 82.135831-159.175644 186.554255-159.175644 98.523029 0 186.254489 71.444184 186.254488 159.175644 0.099922 49.461358-32.774395 93.227166-76.740047 126.301327z"
                    fill="#00C800" p-id="1114"></path>
                </svg>
              </a>
            </div>
            <p class="text-gray-500 text-xs px-8 d-flex">
              <div></div>
              <a class="block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800"
                 href="{{route('register')}}">
                还没有账号?去注册
              </a>
            </p>
          </div> -->
        </div>
      </div>
    </div>
  @endguest
  <!----//End-slider-script---->
  <!-- Slideshow 4 -->

  <div class="modal fade" id="forgetModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width:330px;height:330px;">
      <div class="modal-content" style="width:330px;height:360px;">
        <div style="padding:10px 16px;margin-top:40px;">
          <div >
	          <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
	          	手机号码:
          </label>
	          <input class="appearance-none border rounded w-full py-2 px-2 mb-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
	           id="mobile" type="text" placeholder="请输入手机号码">
	          <p class="text-red-500 text-xs italic "></p>
          </div>
          <div>
	            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
		            验证码:
	            </label>
	            <div class="d-flex justify-content-between py-2" style="align-items:center;">
		            <input class="appearance-none border border-red-500 rounded   py-2 px-2  w-full mr-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
		             id="verification_code" type="text" placeholder="请输入短信验证码" />
		            <input class="bg-blue-500 hover:bg-blue-700 px-2 py-1  text-white font-bold rounded" type="button" id="verificationCode"
		             value="发送验证码" style="border:none;height:50px;background: #26AEF2;">

	            </div>
          </div>
          <div class="flex items-center justify-between my-4">
	          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 w-full px-4 rounded focus:outline-none focus:shadow-outline"
	           type="button" id="phoneLogin" style="border:none;text-align:center;">
		          登录
	          </button>
          </div>
          </div>
        </div>
      </div>
  </div>

<!-- 内容 -->
<!-- Modal -->
<div>
    <div class="vpcs-banner">
    <div class="vpcs-banner-srk">
            <span class="vpcs-banner-sr-span">报告编号：</span>
            <input class="vpcs-banner-sr-input" type="text" id="ver_number" placeholder="请输入报告编号">
            <button class="vpcs-banner-sr-button" id="ver_button">
                开始验证</button>
        </div>
    </div>
    <div style="background:#fff;">
    <div class="vpcs-main">
        <div class="vpcs-bgyz-jg" id="ver_msg" style="display:none;">
           <span>√ 验证通过！您查询的报告已通过【真伪验证】！</span></div>

        <!--<div class="vpcs-bgyz-jg"><i class="fa fa-close"></i> 验证失败！这是假论文！</div>-->
        <br>
        <br>
        <span id="mesage" style="margin-left: 34%; display: none;"></span>
        <table class="vpcs-bgyz-table" id="ver_table" style="display:none">
            <tbody>
                <tr>
                    <td class="vpcs-bgyz-table-title">
                        验证产品：
                    </td>
                    <td class="vpcs-bgyz-table-content" id="name">维普论文检测系统</td>
                </tr>
                <tr>
                    <td class="vpcs-bgyz-table-title">
                        版本类型：
                    </td>
                    <td class="vpcs-bgyz-table-content" id="ver_type"></td>
                </tr>
                <tr>
                    <td class="vpcs-bgyz-table-title">
                        报告编号：
                    </td>
                    <td class="vpcs-bgyz-table-content" id="ver_reportNumber"></td>
                </tr>
                <tr>
                    <td class="vpcs-bgyz-table-title">
                        论文题目：
                    </td>
                    <td class="vpcs-bgyz-table-content" id="ver_title"></td>
                </tr>
                <tr>
                    <td class="vpcs-bgyz-table-title">
                        检测时间：
                    </td>
                    <td class="vpcs-bgyz-table-content" id="ver_checkTime"></td>
                </tr>
                <tr>
                    <td class="vpcs-bgyz-table-title">
                        总相似比：
                    </td>
                    <td class="vpcs-bgyz-table-content" id="ver_similar"></td>
                </tr>
            </tbody>
        </table>
    </div>
    </div>

</div>

@stop
<!--/.fluid-container-->
@section('scripts')
  <script>
      $(function () {

      if(!!window.ActiveXObject || "ActiveXObject" in window){
        $("#Ieno").css("display","none")
      }else{
        $("#Ieno").css("display","block")
　　  }
      var timer = null
      $('#staticBackdrop').on('show.bs.modal', function () {
        axios.get("/official_account").then(function(res){
          var img = new Image();
          img.onload = function() {
            $("#qrimg").attr('src',res.data.url);
            $("#qrimg").css("display","block");
            $("#loginIcon").css("display","none");
          }
          img.src = res.data.url;
          var wechatFlag = res.data.wechatFlag;
          timer = setInterval(function(){
            axios.post("login_check",{
              wechat_flag:wechatFlag
            }).then(function(res){
              if(res.status==200){
                clearInterval(timer);
                swal("提示", "登录成功", "success");
                location.reload();
              }
            })
          }, 1000);
        })
      })
      //注册
      $("#quiklyRegister").click(function(){
        $("#staticBackdrop").modal("hide")
        $("#registerTcDialog").modal('show')
      })
      $("#noregister").click(function(){
        $("#registerTcDialog").modal('hide')
        $("#staticBackdrop").modal("show")
        $("#pills-home-tab").attr("aria-selected",true)
        $("#pills-home-tab").addClass('active')
        $("#pills-profile-tab").attr("aria-selected",false)
        $("#pills-profile-tab").removeClass('active')
        $("#pills-profile").removeClass('active show')
        $("#pills-home").addClass("active show")

      })
      //模态框关闭
      $('#staticBackdrop').on('hidden.bs.modal', function () {
          clearInterval(timer);
      })
      // Tab切换
      $('.banner-li').click(function () {
        $(this)
          .addClass('li-current')
          .siblings()
          .removeClass('li-current')
        let liIndex = $(this).index()
        $('.listbox')
          .eq(liIndex)
          .css('display', 'block')
          .siblings('.listbox')
          .css('display', 'none')
      })
      $(document).keydown(function (e) {
        if (e.keyCode == 13) {
          $("#btnSubmit").click()
        }
      })
      //账号登录
      $('#accountLogin').click(function () {
        axios.post('{{route('login') }}', {
          phone: $("#phone").val(),
          password: $("#password").val(),
          type: 'account'
        }).then(function(res){
          if (res.status == 200) {
            swal("提示", res.data.message, "success");
            location.reload();
          } else {
            swal("提示", res.data.message);
          }
        }).catch(function(err){
          if (err.response.status == 422) {
            $.each(err.response.data.errors, function(field, errors){
              swal("提示", errors[0]);
            })
          }
          if (err.response.status == 401) {
            $.each(err.response.data, function(field, errors){
              swal("提示", errors);
            })
          }
        })
      })
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
        index.setAttribute('disabled', true);
        var phone = $("#mobile").val();
        var reg = /^1[34578]\d{9}$/;
        if (!reg.test(phone)) {
          index.removeAttribute("disabled");
          $("input[name='phone']").focus();
          swal('提示信息', "请输入正确的手机号码!!!");
          return;
        }
        axios.post('/api/v1/verificationCodes', {
          phone: phone,
        }).then(function(res){
          swal('验证码已发送成功!,请注意查收!')
          time(index);
          verification_key = res.data.key;
        }).catch(function(err){
          index.removeAttribute("disabled");
          if (err.response.status == 401) {
            $.each(err.response.data.errors, function(field, errors){
              swal("提示", errors[0]);
            })
          }
        })
      }
      //忘记密码
      $("#forgetpsw").click(function(){
        $("#staticBackdrop").modal('hide')
        $("#forgetModal").modal("show");
      })
      $('#verificationCode').click(function () {
        getcode(this)
      })
      $('#phoneLogin').click(function() {
        axios.post('{{ route('login') }}', {
          phone: $('#mobile').val(),
          verification_code: $('#verification_code').val(),
          verification_key: verification_key,
          type: 'phone'
        }).then(function(res){
          swal("提示", '登录成功', "success");
          location.reload();
        }).catch(function(err) {
          if (err.response.status == 401) {
            swal("提示", '用户不存在！！！');
          }
          if (err.response.status == 422) {
            $.each(err.response.data.errors, function(field, errors){
              swal("提示", errors[0]);
            })
          }
        });
      });
      // Tab切换
      $(".banner-li").click(function () {
        $(this)
          .addClass("li-current")
          .siblings()
          .removeClass("li-current");
        let liIndex = $(this).index();
        $(".listbox")
          .eq(liIndex)
          .css("display", "block")
          .siblings(".listbox")
          .css("display", "none");
      });
      })



        $("#ver_button").click(function(){
          var vernum = $("#ver_number").val()
          if(!vernum){
            $.alert('请输入报告编号');
            return;
          }
          axios.post("/api/v1/verification-report",{number:vernum}).then(function(res){
              if(!res.data.msg){
                $("#ver_type").text(res.data.type)
                $("#ver_reportNumber").text(res.data.paperobject.guid)
                $("#ver_title").text(res.data.paperobject.title)
                $("#ver_checkTime").text(res.data.checktime)
                $("#ver_similar").text(res.data.paperobject.Percentage+"%")
                $("#ver_msg").css('display','block')
                $("#ver_table").css('display','block')
              }else{
                $("#ver_msg").css('display','none')
                $("#ver_table").css('display','none')
                $.alert('报告不存在')
              }
          })
        })

  </script>
@stop
