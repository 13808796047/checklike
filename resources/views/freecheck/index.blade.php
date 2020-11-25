@extends('layouts.app')
@section('title', '查看订单')
@section('styles')
  <style>
   .swal-modal {
      width: 350px;
    }

    .swal-button {
      padding: 7px 19px;
      font-size: 12px;
    }

    .swal-title {
      font-size: 20px;
    }
    .swal-text {
      /* background-color: #FEFAE3;
      padding: 17px;
      border: 1px solid #F0E1A1;
      display: block;
      margin: 22px;
      text-align: center;
      color: #61534e; */
    }
  	.nav-link {
			color: black;
			}
		.nav-pills .nav-link {
			border-radius: 0;
		}
		.nav-pills .nav-link.active,
		.nav-pills .show>.nav-link {
			color: #3e8bdb;
			background-color: #fff;
			font-weight: bold;
			border-bottom: 1px solid #3e8bdb;
		}
    .index_first{
      width: 290px;
      text-align: center;
      float: left;
    }
    .index_first_title{
      color: #333333;
      font-size: 26px;
      margin-bottom: 10px;
    }
    .index_first_content{
      height: auto;
      font-size: 16px;
      line-height: 28px;
      color: #56565e;
    }
    .newul{
      display:flex;
      margin-bottom:0 !important;
      align-items:center;
      justify-content: space-around;
    }
    .newul li a{
      color:#fff;
    }
    .ambtn{
      border-radius: 16px;
      border: 1px solid #fff;
      padding: 5px 13px;
    }
    a:hover{
      text-decoration:none ;
    }
  </style>
@stop
@section('content')
<!-- Modal -->
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
                    <div style="display: flex;font-size: 10px;justify-content: space-between;color: #999;">
                       <p id="forgetpsw">忘记密码</p>
                       <a class="block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" id="quiklyRegister">
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
		             value="发送验证码" style="border:none;height:50px;">

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

<div id="header1">
     <nav id="navigation" class="navbar scrollspy affix" style="position: static;">
				<div class="container">
					<div class="navbar-brand" style="width:395px;margin-right:70px;">
						<a href="javascript:void(0)" onclick="window.location.href='/'"><img src= "{{ asset('asset/images/checklike.png') }}" alt=""></a>
					</div>
					<ul class="newul" style="flex:1;">
						<li><a href="javascript:void(0)" onclick="window.location.href='/'" class="smooth-scroll">网站首页</a></li>
            @guest
            <li><a class="nav-link" href="javascript:;" data-toggle="modal" data-target="#staticBackdrop">论文查重</a></li>
            @else
            <li><a href="/categories/1" class="smooth-scroll">论文查重</a></li>
            @endguest
            <li><a href="/freecheck" class="smooth-scroll">免费查重</a></li>
            @guest
            <li><a class="nav-link" href="javascript:;" data-toggle="modal" data-target="#staticBackdrop">自动降重</a></li>
            @else
            <li><a href="/rewrite" class="smooth-scroll">自动降重</a></li>
            @endguest
            @guest
            <li><a class="nav-link" href="javascript:;" data-toggle="modal" data-target="#staticBackdrop">报告下载</a></li>
            @else
            <li><a href="{{route('orders.index')}}" class="smooth-scroll">报告下载</a></li>
            @endguest
            @guest
						<li class="menu-btn">
            <a class="ambtn" href="javascript:;" data-toggle="modal"
            data-target="#staticBackdrop" >登录/注册</a>
            </li>
            @else
            <li class="ambtn"><a href="/users/{{Auth::user()->id}}">个人中心</a></li>
            <li class="ambtn"><a class="logout" href="javascript:;">退出</a></li>
            @endguest
					</ul>
          </nav>
        </div>
</div>


<div class="container" style="margin:18px auto;">
<div class="grid grid-cols-12 gap-4">
	<div class="col-span-9 p-4" style="box-shadow: 0 0 6px rgba(0, 0, 0, 0.3);background: #fff;">
  <div style="padding:30px 50px;" class="freecheckleft">
    <div style="text-align: center;font-size: 23px;font-weight: bold;">真金不怕火炼，CheckLike提供免费查重服务</div>
    <div style="font-size:13px;color:#A9A9A9;text-align:center;margin:5px 0;">活动时间：2020-10-01 至2021-07-31</div>
    <p>CheckLike论文相似度检测系统采用国际领先的海量论文动态语义跨域识别加指纹比对技术，通过运用最新的云检测服务部署使其能够快捷、稳定、准确地检测到文章中存在的抄袭和不当引用现象，实现了对学术不端行为的检测服务。</p >
    <p>通过系统检测可快速准确地检测出论文中不当引用、过度引用甚至是抄袭、伪造、篡改等学术不端行为，可自动生成检测报告，并支持PDF、网页等浏览格式。详细的检测报告通过不同颜色标注相似片段、引用片段、专业用语，形象直观地显示相似内容比对、相似文献汇总、引用片段出处、总相似比、引用率、复写率和自写率等重要指标，为教育机构、科研单位、各级论文评审单位和发表单位提供了论文原创性和新颖性评价的重要依据。经过不断发展和努力，已经在众多行业和部门得到了广泛使用，受到了用户的高度评价。</p>
    <p>为了让更多用户体验到CheckLike的检测效果，我们推出免费查重活动：</p>
    <p><b>活动对象：</b>所有用户</p>
    <p><b>规则说明：</b>活动期间，所有用户均可使用CheckLike专业版免费查重一篇1万字以内的论文（一万字以内免费，超过一万字部分按3元/万字收费）。</p >
    <p><b>活动时间：</b>2020-10-01 至2021-07-31</p>

    @guest

    <a class="btn btn-primary btn-sm sbtn" href="javascript:;" data-toggle="modal" data-target="#staticBackdrop" type="button" style="color:#fff;display:block;margin:50px auto;">立即去提交论文</a>
    @else

    <a href="/categories/1" type="button" style="color:#fff;display:block;margin:50px auto;" class="btn btn-primary btn-sm sbtn">立即去提交论文</a>

    @endguest

</div>


 </div>

       <div class="col-span-3">
      <div>
      <div style="background:#54B538;color: #fff;padding-left: 20px;font-size: 15px;height: 44px;line-height: 44px;">系统客服</div>
      <div style="border-bottom: 1px solid #c1bebd;box-shadow: 0px 0px 5px #c1bebd;padding: 15px;background: #FFFFFF;">
          <img src="https://www.checklike.com/images/qrcode/sz-work.png" style="width:171px;height:171px;display:block;margin:0 auto;">
          <p style="text-align:center;margin-top:7px;font-size:13px;">微信扫一扫，与客服在线沟通</p>
      </div>
      </div>
      <div style="background:#fff;box-shadow: 0 0 6px rgba(0, 0, 0, 0.3);margin-top:13px;" class="p-4">
        <b>1、论文上传之后安全吗？</b>
        <p>本系统有明确的条文规定并遵守严格的论文保密规定，对所有用户提交的送检文档仅做检测分析，绝不保留全文，承诺对用户送检的文档不做任何形式的收录和泄露。</p>
        <b>2、提交以后能不能退款？</b>
        <p>系统一旦提交，开始检测后，即产生消费，无法退款，请谅解！</p>
        <b>3、检测内容范围？</b>
        <p>系统主要检测论文正文，封面、目录、致谢以及个人信息可以删除后再上传。</p>
      </div>
    </div>
  </div>


</div>

<!--/.fluid-container-->

@endsection
@section('scripts')
  <script>
     $(document).ready(function () {
      var timer = null
      $('#staticBackdrop').on('show.bs.modal', function () {
        axios.get("/official_account").then(res=>{
          var img = new Image();
          img.onload = function() {
            $("#qrimg").attr('src',res.data.url);
            $("#qrimg").css("display","block");
            $("#loginIcon").css("display","none");
          }
          img.src = res.data.url;
          var wechatFlag = res.data.wechatFlag;
          timer = setInterval(() => {
            axios.post("login_check",{
              wechat_flag:wechatFlag
            }).then(res=>{
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
      $("#quiklyRegister").click(()=>{
        $("#staticBackdrop").modal("hide")
        $("#registerTcDialog").modal('show')
      })
      $("#noregister").click(()=>{
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
        }).then(res => {
          if (res.status == 200) {
            swal("提示", res.data.message, "success");
            location.reload();
          } else {
            swal("提示", res.data.message);
          }
        }).catch(err => {
          if (err.response.status == 422) {
            $.each(err.response.data.errors, (field, errors) => {
              swal("提示", errors[0]);
            })
          }
          if (err.response.status == 401) {
            $.each(err.response.data, (field, errors) => {
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
        }).then(res => {
          swal('验证码已发送成功!,请注意查收!')
          time(index);
          verification_key = res.data.key;
        }).catch(err => {
          index.removeAttribute("disabled");
          if (err.response.status == 401) {
            $.each(err.response.data.errors, (field, errors) => {
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
      $('#phoneLogin').click(() => {
        axios.post('{{ route('login') }}', {
          phone: $('#mobile').val(),
          verification_code: $('#verification_code').val(),
          verification_key: verification_key,
          type: 'phone'
        }).then(res => {
          swal("提示", '登录成功', "success");
          location.reload();
        }).catch(err => {
          if (err.response.status == 401) {
            swal("提示", '用户不存在！！！');
          }
          if (err.response.status == 422) {
            $.each(err.response.data.errors, (field, errors) => {
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
    });
  </script>
@stop
