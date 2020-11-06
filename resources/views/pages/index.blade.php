@extends('layouts.app')
@section('title', '学信检测')
@section('styles')
  <link rel="stylesheet" href="{{asset('asset/css/bootstrap4.css')}}">
  <link rel="stylesheet" href="{{asset('asset/css/ionicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('asset/css/slick.css')}}">
  <link rel="stylesheet" href="{{asset('asset/css/slick-theme.css')}}">
  <link rel="stylesheet" href="{{asset('asset/css/jquery.fancybox.css')}}">
  <link rel="stylesheet" href="{{asset('asset/css/animate.min.css')}}">
  <link rel="stylesheet" href="{{asset('asset/css/jquery-confirm.css')}}">
  <link href="{{asset('asset/css/styles.css')}}" rel="stylesheet"/>

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
                   aria-controls="pills-profile" aria-selected="false">账号登录</a>
              </li>
            </ul>
            <div class="tab-content" id="pills-tabContent" style="margin:17px 0;">
              <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
              <div style="width:270px;height:270px;margin: 0 auto;">
								<div style="color: #999;font-size: 13px;text-align: center;">
									微信扫一扫 享免费检测
								</div>
								<div style="margin: 5px 0;">
									<img src=""
									 id="qrimg" style="width:200px;height:200px;margin: 0 auto;display: block;">
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
                        用户名:
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
                        type="button" id="accountLogin" style="text-align:center;">
                        登录
                      </button>
                    </div>
                    <div style="display: flex;font-size: 10px;justify-content: space-between;color: #999;">
                       <p id="forgetpsw">忘记密码</p>
                       <a class="block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800"
                        href="{{route('register')}}">
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
  {{--  <div id="top" class="callbacks_container">--}}
  {{--    <ul class="rslides" id="slider4">--}}
  {{--      <li>--}}
  {{--        <div class="caption text-center">--}}
  {{--          <div class="slide-text-info">--}}
  {{--            --}}{{--            <a class="btn1" href="javascript:;" data-toggle="modal" data-target="#staticBackdrop"><span>万方查重</span></a>--}}
  {{--            <h1>本科大学生 <span>毕业论文</span> 学术不端检测</h1>--}}
  {{--            <div class="slide-text">--}}
  {{--              <p>用于检测大学生毕业论文是否存在抄袭剽窃等学术不端行为，全国多个高校在使用，与学校检测结果一致。</p>--}}
  {{--            </div>--}}
  {{--            @guest--}}
  {{--              <a class="btn2" href="javascript:;" data-toggle="modal"--}}
  {{--                 data-target="#staticBackdrop"><span>立即查重</span></a>--}}
  {{--            @else--}}
  {{--              <a class="btn2" href="{{route('categories.show',['classid'=>2])}}" target="_blank"><span>立即查重</span></a>--}}
  {{--            @endguest--}}
  {{--          </div>--}}
  {{--        </div>--}}
  {{--      </li>--}}
  {{--      <li>--}}
  {{--        <div class="caption text-center">--}}
  {{--          <div class="slide-text-info">--}}
  {{--            <a class="btn1" href="#"><span>万方查重</span></a>--}}
  {{--            <h1>硕博研究生 <span> 学位论文 </span> 学术不端检测</h1>--}}
  {{--            <div class="slide-text">--}}
  {{--              <p>为高校研究生院部提供检测服务，仅限检测研究生毕业论文。可检测抄袭与剽窃、伪造、篡改等学术不端行为。</p>--}}
  {{--            </div>--}}
  {{--            <a class="btn2" href="javascript:;" id="login3"><span>立即查重</span></a>--}}
  {{--            @auth--}}
  {{--              <a class="btn2" href="{{route('categories.show',['classid'=>2])}}" id="login3"><span>立即查重</span></a>--}}
  {{--            @endauth--}}
  {{--          </div>--}}
  {{--        </div>--}}
  {{--      </li>--}}
  {{--      <li>--}}
  {{--        <div class="caption text-center">--}}
  {{--          <div class="slide-text-info">--}}
  {{--            <a class="btn1" href="#"><span>万方查重</span></a>--}}
  {{--            <h1>职称评比 <span>期刊发表</span> 学术不端检测</h1>--}}
  {{--            <div class="slide-text">--}}
  {{--              <p>为编辑部提供检测服务，可检测抄袭与剽窃、伪造、篡改、不当署名、一稿多投等学术不端文献。</p>--}}
  {{--            </div>--}}
  {{--            @auth--}}
  {{--              <a class="btn2" href="{{route('categories.show',['classid'=>2])}}" id="login4"><span>立即查重</span></a>--}}
  {{--            @endauth--}}
  {{--            <a class="btn2" href="javascript:;" id="login4"><span>立即查重</span></a>--}}
  {{--          </div>--}}
  {{--        </div>--}}
  {{--      </li>--}}
  {{--    </ul>--}}
  {{--  </div>--}}
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
	            <div class="d-flex justify-content-between py-2">
		            <input class="appearance-none border border-red-500 rounded   py-2 px-2  w-full mr-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
		             id="verification_code" type="text" placeholder="请输入短信验证码" />
		            <input class="bg-blue-500 hover:bg-blue-700 px-2 py-1  text-white font-bold rounded" type="button" id="verificationCode"
		             value="发送验证码">
	            </div>
          </div>
          <div class="flex items-center justify-between my-4">
	          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 w-full px-4 rounded focus:outline-none focus:shadow-outline"
	           type="button" id="phoneLogin">
		          登录
	          </button>
          </div>
          </div>
        </div>
      </div>
  </div>


  <!----- //End-slider---->
  <!----start-services---->

	<!-- #navigation -->
	<!-- #navigation end -->

	<!-- .header-content -->
<header id="header" style="position:relative;">
	<div class="header-content">
		<div class="container">
			<div class="row header-row">

				<div class="col-sm-7 col-md-8 col-lg-7">
					<div class="header-txt">
						<h1>移动版全新上线<br>完美支持手机/微信/小程序</h1>
						<p>CheckLike 论文查重系统移动版全新升级，支持手机提交论文(含文件上传)、检测完成后微信提醒、在线查看检测结果、原文比对等功能，方便随时随地查重论文，提升毕业论文写作效率。</p>
					</div>
					<div class="header-btn">
						<a href="#" class="btn-custom">微信扫码体验</a>
						<a href="#download" class="btn-custom btn-border btn-icon smooth-scroll"><i class="ion ion-social-twitter"></i>免费查重</a>
					</div>
				</div>

				<div class="col-sm-5 col-md-4 col-lg-offset-1 header-img">
					<div class="carousel-slider header-slider animation" data-animation="animation-fade-in-down">
						<div><img src= "{{asset('asset/images/content/sliders/1.jpg')}}" alt="Image 1"></div>
						<div><img src= "{{asset('asset/images/content/sliders/2.jpg')}}" alt="Image 2"></div>
						<div><img src= "{{asset('asset/images/content/sliders/3.jpg')}}" alt="Image 3"></div>
						<div><img src= "{{asset('asset/images/content/sliders/4.jpg')}}" alt="Image 4"></div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<div class="header-bg" style="background-image:url('asset/images/content/bg/1.jpg');">
		<div class="header-bg-overlay"></div>
	</div>
</header>

  <!----//End-services---->
  <div id="features" class="section-wrap padding-top60">

	<!-- .container -->
	<div class="container">
		<!-- .row -->
		<div class="row padding-bottom20">

			<div class="col-sm-4"> <!-- 1 -->
				<div class="affa-feature-icon">
					<i class="ion ion-ios-world-outline"></i>
					<h4>海量的学术资源</h4>
					<p>采用海量的论文比对数据，包含科技期刊、报纸、专利、会议、学位论文等多个论文数据库资源。</p>
				</div>
			</div>

			<div class="col-sm-4"> <!-- 2 -->
				<div class="affa-feature-icon">
					<i class="ion ion-ios-locked-outline"></i>
					<h4>安全的传输协议</h4>
					<p>全站遵循HTTPS协议，传输解析技术安全可靠，保护您的文献不被泄露，检测过程放心安心。</p>
				</div>
			</div>

			<div class="col-sm-4"> <!-- 3 -->
				<div class="affa-feature-icon">
					<i class="ion ion-ios-pulse"></i>
					<h4>专业的检测算法</h4>
					<p>采用国际领先的海量论文动态语义跨域识别加指纹比对技术，做到快捷、安全、准确、全面。</p>
				</div>
			</div>

		</div>
		<!-- .row end -->

	</div>
	<!-- .container end -->

	<!-- .container-wrap -->
	<div class="container-wrap container-padding8060">

		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-5 col-txt text-center-sm text-center-xs margin-bottom40-sm margin-bottom40-xs">
					<div class="post-heading-left">
						<h2>多端同步适配</h2>
					</div>
					<p>全新架构打通常终端设备，数据互通。电脑、手机、平板均可提交论文查重，下载查重报告，方不同使用场景。</p>
					<p>提供多种版本检测报告帮助您轻松阅读检测结果、准确获取论文查重信息，检测结果客观、准确、详细！</p>
				</div>
			</div>
		</div>

		<div class="col-pull-right">
			<figure class="img-layers3 img-pull-left">
				<div class="img-layer-lg">
					<img src="{{asset('asset/images/content/landing/feature-1.png')}}" alt="Image Large" class="animation" data-animation="animation-fade-in-right">
				</div>
				<div class="img-layer-md">
					<img src="{{asset('asset/images/content/landing/feature-2.png')}}" alt="Image Mediun" class="animation" data-animation="animation-fade-in-left" data-delay="300">
				</div>
				<div class="img-layer-sm">
					<img src="{{asset('asset/images/content/landing/feature-3.png')}}" alt="Image Small" class="animation" data-animation="animation-fade-in-down" data-delay="600">
				</div>
			</figure>
		</div>

	</div>
	<!-- .container-wrap end -->

	<!-- .container-padding -->
	<div class="container-padding60 bg-color">

		<!-- .container -->
		<div class="container">

			<!-- .row -->
			<div class="row">

				<div class="col-sm-8 col-md-5 col-sm-offset-2 col-md-offset-0 margin-bottom20">
					<figure class="img-layers img-layer-right-front">
						<div class="img-layer-left">
							<img src="{{asset('asset/images/content/landing/feature-4.png')}}" alt="Image Left" class="animation" data-animation="animation-fade-in-left">
						</div>
						<div class="img-layer-right">
							<img src="{{asset('asset/images/content/landing/feature-5.png')}}" alt="Image Right" class="animation" data-animation="animation-fade-in-right" data-delay="400">
						</div>
					</figure>
				</div>

				<div class="col-sm-10 col-md-7 col-lg-6 col-sm-offset-1 col-md-offset-0 col-lg-offset-1">
					<div class="text-wrap40 text-center-sm text-center-xs">
						<div class="post-heading-left">
							<h2>丰富的论文写作解决方案</h2>
						</div>
						<div class="affa-feature-icon-left margin-bottom30"> <!-- 1 -->
							<i class="ion ion-android-done"></i>
							<h4>一键自动降重</h4>
							<p>强大自然语言语义分析系统，在不改变原意的情况下通过AI智能技术重新编写原句，瞬间降低论文重复率。</p>
						</div>
						<div class="affa-feature-icon-left"> <!-- 3 -->
							<i class="ion ion-android-done"></i>
							<h4>智能语法纠错</h4>
							<p>可以帮助用户检查一些单词错误、语法错误、时态错误等，并提供更准确的使用方法。</p>
						</div>
						<div class="affa-feature-icon-left margin-bottom30"> <!-- 2 -->
							<i class="ion ion-android-done"></i>
							<h4>PDF转Word</h4>
							<p>快速把PDF文件转换成Word文件，一键操作，快速、方便，能最大限度的保留源文档的布局和格式。</p>
						</div>

						<div class="affa-feature-icon-left"> <!-- 3 -->
							<i class="ion ion-android-done"></i>
							<h4>海量文献资料下载</h4>
							<p>海量专业学术文献免费下载，覆盖各个行业期刊论文,学位论文,会议论文,标准,专利等各类学术资源。</p>
						</div>
					</div>
				</div>

			</div>
			<!-- .row end -->

		</div>
		<!-- .container end -->

	</div>
	<!-- .container-padding end -->

</div>
<!-- #features end -->
<!-- #works -->
<div id="works" class="container-padding8020">

	<!-- .container -->
	<div class="container">

		<div class="post-heading-center no-border margin-bottom40">
			<h2>用户评价</h2>
		</div>

		<!-- .row -->
		<div class="row">

			<div class="col-sm-3 affa-testimonial"> <!-- 1 -->
				<div class="testimonial-name">
						<img src="{{asset('asset/images/content/avatars/1.jpg')}}" alt="Avatar">
					<div class="testimonial-txt">
						<b>浅夏丿初晴</b> <small>(大学生)</small>
						<p>“班级群里老师推荐的，价格不高，首次还免费，而且查重报告还比较详细，我们学校是用维普查重，检测结果跟这个差不多，一次性通过!”</p>
					</div>
				</div>
			</div>

			<div class="col-sm-3 affa-testimonial"> <!-- 2 -->
				<div class="testimonial-name">
						<img src="{{asset('asset/images/content/avatars/2.jpg')}}" alt="Avatar">
					<div class="testimonial-txt">
						<b>醉相思</b> <small>(研究生)</small>
						<p>“导师推荐的，知网查重太贵了，只能用其他系统代替。初稿先用CheckLike检测，修改后用维普和万方查重检测，把查出来的全部改掉，顺利通过了学校知网查重。”</p>
					</div>
				</div>
			</div>
			<div class="col-sm-3 affa-testimonial"> <!-- 3 -->
				<div class="testimonial-name">
						<img src="{{asset('asset/images/content/avatars/3.jpg')}}" alt="Avatar">
					<div class="testimonial-txt">
						<b>岁月如歌</b> <small>(大学教师)</small>
						<p>“经常用它给学生的作业进行的查重，可以批量上传，检测结果一目了然，而且比较准确，不像之前用的某些系统内容都没重复也飘红。”</p>
					</div>
				</div>
			</div>
			<div class="col-sm-3 affa-testimonial"> <!-- 4 -->
				<div class="testimonial-name">
						<img src="{{asset('asset/images/content/avatars/4.jpg')}}" alt="Avatar">
					<div class="testimonial-txt">
						<b>大号萝莉</b> <small>(主管护师)</small>
						<p>“学信检测小程序很方便，可以在手机上提交论文查重而且检测完成后能查看详细的比对报告，充分利用了碎片时间，工作和写论文两不误。”</p>
					</div>
				</div>
			</div>

		</div>
		<!-- .row end -->

	</div>
	<!-- .container end -->

</div>
<!-- #works end -->

<div class="container">
	<div class="sep-border"></div> <!-- separator -->
</div>


<!-- #clients -->
<div id="clients" class="container-padding60">

	<!-- .container -->
	<div class="container">

		<div class="post-heading-center">
			<h2>合作机构</h2>
		</div>

		<!-- .row -->
		<div class="row row-clients">

			<div class="col-sm-3"> <!-- 1 -->
				<div class="affa-client-logo">
					<img src="{{asset('asset/images/content/clients/1.png')}}" alt="Logo">
				</div>
			</div>

			<div class="col-sm-3"> <!-- 2 -->
				<div class="affa-client-logo">
					<img src="{{asset('asset/images/content/clients/2.png')}}" alt="Logo">
				</div>
			</div>

			<div class="col-sm-3"> <!-- 3 -->
				<div class="affa-client-logo">
					<img src="{{asset('asset/images/content/clients/3.png')}}" alt="Logo">
				</div>
			</div>

			<div class="col-sm-3"> <!-- 4 -->
				<div class="affa-client-logo">
					<img src="{{asset('asset/images/content/clients/4.png')}}" alt="Logo">
				</div>
			</div>

		</div>
		<!-- .row end -->

	</div>
	<!-- .container end -->

</div>
<!-- #clients end -->

<div class="container">
	<div class="sep-border"></div> <!-- separator -->
</div>

  <!-----//End-services-grids---->
  <!---- start-about----->
  <!----start-team----->
  <!----//End-team----->
  <!--登陆模态框-->
  {{--  <div class="login-box" style="display: none" id="loginbox">--}}
  {{--    <div class="header">--}}
  {{--      <ul id="loginTitle">--}}
  {{--        <li class="banner-li li-current" id="wx">微信登陆</li>--}}
  {{--        <li class="banner-li" id="zh">账号登陆</li>--}}
  {{--        <span class="closebox" id="closebox">X</span>--}}
  {{--      </ul>--}}

  {{--    </div>--}}
  {{--    <div class="box-main">--}}
  {{--      <div class="content listbox" id="wxlogin">--}}
  {{--        <div class="tit">--}}
  {{--          <p>用微信扫码 安全查重</p>--}}
  {{--        </div>--}}
  {{--        <div class="codeimg">--}}
  {{--          <img id="login_mpweixin_img" src="" alt="更新二维码"/>--}}
  {{--        </div>--}}

  {{--        <div class="box-word">无需注册，一键登录</div>--}}
  {{--      </div>--}}
  {{--      <div class="ch-input-wrap listbox remove" id="zhlogin" style="display: none">--}}
  {{--        <form action="/redirect.php?url=/user/login" method="post" class="form">--}}
  {{--          <div class="form-item">--}}
  {{--                <span id="logerror" class="wrong c-red" style="display:none;"--}}
  {{--                >* <em></em--}}
  {{--                  ></span>--}}
  {{--            <div class="hd">用户名：</div>--}}
  {{--            <div class="input-div">--}}
  {{--              <input--}}
  {{--                class="input"--}}
  {{--                name="name"--}}
  {{--                id="name"--}}
  {{--                type="text"--}}
  {{--                placeholder="请输入用户名"--}}
  {{--                autocomplete="off"--}}
  {{--              />--}}
  {{--            </div>--}}
  {{--          </div>--}}
  {{--          <div class="form-item">--}}
  {{--            <div class="hd">密 码：</div>--}}
  {{--            <div class="input-div">--}}
  {{--              <input--}}
  {{--                class="input"--}}
  {{--                name="password"--}}
  {{--                id="password"--}}
  {{--                type="password"--}}
  {{--                placeholder="密码"--}}
  {{--                autocomplete="new-password"--}}
  {{--              />--}}
  {{--            </div>--}}
  {{--          </div>--}}

  {{--          <div class="form-item">--}}
  {{--            <div class="agreement">--}}

  {{--              <input id="chkLoginType" type="checkbox" name="chkLoginType"/>--}}
  {{--              记住密码--}}
  {{--            </div>--}}
  {{--          </div>--}}
  {{--          <div class="form-item">--}}
  {{--            <input--}}
  {{--              id="btnSubmit"--}}
  {{--              type="button"--}}
  {{--              class="btn-login"--}}
  {{--              value="登 录"--}}
  {{--              onclick="getLogin()"--}}
  {{--            />--}}
  {{--          </div>--}}

  {{--          <div class="form-item">--}}
  {{--            还没有账号？<a href="javascript:void(0)" onclick="window.location.href='/register'">立即注册</a>--}}
  {{--          </div>--}}
  {{--        </form>--}}
  {{--      </div>--}}
  {{--    </div>--}}
  {{--  </div>--}}
  {{--  <!-- main轮播登陆块 -->--}}
  {{--  <div class="login-banner">--}}
  {{--    <div class="login-banner-box">--}}
  {{--      <div style="left:18%; top:88px;position: absolute;">--}}
  {{--        <img src="{{asset('asset/images/bg2i.png')}}" width="100%"/>--}}
  {{--      </div>--}}



  {{--  <!-- 文字内容 -->--}}
  {{--  <div class="main">--}}
  {{--    <div class="main-wrap">--}}
  {{--      <div class="item fl first">--}}
  {{--        <h4 class="ind1_txt">专业</h4>--}}
  {{--        <div class="text">--}}
  {{--          不仅提供查重服务，更是提供专业的全套论文解决方案，为你解除论文烦恼。--}}
  {{--        </div>--}}
  {{--      </div>--}}
  {{--      <div class="item fl">--}}
  {{--        <h4 class="ind1_txt">省心</h4>--}}
  {{--        <div class="text">--}}
  {{--          各种论文问题均可一键解决，省心，省力，极其方便的解决论文痛点--}}
  {{--        </div>--}}
  {{--      </div>--}}
  {{--      <div class="item fl">--}}
  {{--        <h4 class="ind1_txt">安全</h4>--}}
  {{--        <div class="text">--}}
  {{--          全站https协议传输，基于阿里云OSS文档上传，报告支持密码加密，安全无痕迹--}}
  {{--        </div>--}}
  {{--      </div>--}}
  {{--    </div>--}}
  {{--  </div>--}}
@stop
@section('scripts')
  <!-- <script type="text/javascript" src="{{ asset('asset/js/move-top.js') }}"></script>
  <script type="text/javascript" src=" {{ asset('asset/js/easing.js') }}"></script> -->
  {{--  <script src="{{ asset('asset/js/responsiveslides.min.js') }}"></script>--}}
  <!-- JavaScripts -->
<script type="text/javascript" src="{{asset('asset/newjs/jquery-1.11.3.min.js')}}"></script>
<script type="text/javascript" src="{{asset('asset/newjs/jquery-migrate-1.2.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('asset/js/jquery-confirm.js')}}" ></script>
<script type="text/javascript" src="{{asset('asset/newjs/script.js')}}"></script>
<script type="text/javascript" src="{{asset('asset/newjs/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('asset/newjs/jquery.easing.min.js')}}"></script>
<!-- <script type="text/javascript" src="js/smoothscroll.js"></script>
<script type="text/javascript" src="js/response.min.js"></script> -->
<script type="text/javascript" src="{{asset('asset/newjs/jquery.placeholder.min.js')}}"></script>
<script type="text/javascript" src="{{asset('asset/newjs/jquery.fitvids.js')}}"></script>
<script type="text/javascript" src="{{asset('asset/newjs/jquery.imgpreload.min.js')}}"></script>
<script type="text/javascript" src="{{asset('asset/newjs/waypoints.min.js')}}"></script>
<script type="text/javascript" src="{{asset('asset/newjs/slick.min.js')}}"></script>
<script type="text/javascript" src="{{asset('asset/newjs/jquery.fancybox.pack.js')}}"></script>
<!-- <script type="text/javascript" src="js/jquery.fancybox-media.js"></script> -->
<script type="text/javascript" src="{{asset('asset/newjs/jquery.counterup.min.js')}}"></script>
<!-- <script type="text/javascript" src="js/parallax.min.js"></script> -->
  <script>
    $(function () {
      {{--      @auth--}}
      {{--      swal({--}}
      {{--        // content 参数可以是一个 DOM 元素，这里我们用 jQuery 动态生成一个 img 标签，并通过 [0] 的方式获取到 DOM 元素--}}
      {{--        text: '关注公众号,获取更多资讯!',--}}
      {{--        content: $("<img class='inline-block' src=\"{{ asset('asset/images/691584772794_.pic.jpg') }}\" />")[0],--}}
      {{--        // buttons 参数可以设置按钮显示的文案--}}
      {{--      })--}}
      {{--      @endauth--}}
      // $("#slider4").responsiveSlides({
      //   auto: true,
      //   pager: true,
      //   nav: true,
      //   speed: 500,
      //   namespace: "callbacks",
      //   before: function () {
      //     $('.events').append("<li>before event fired.</li>");
      //   },
      //   after: function () {
      //     $('.events').append("<li>after event fired.</li>");
      //   }
      // });
      // $().UItoTop({easingType: 'easeOutQuart'});
       //模态框打开
      var isBindPhone = {!!Auth::user()!!}
      console.log(isBindPhone,"那哈哈")
      if(isBindPhone && isBindPhone.phone){
        console.log( $("#xiugai"),isBindPhone.phone,"11")
        // $("#xiugai").css("display","block")
      }else{
        // $("#xiugai").css("display","none")
      }
      var timer = null
      $('#staticBackdrop').on('show.bs.modal', function () {
        axios.get("/official_account").then(res=>{
          var img = new Image();
          img.onload = function() {
            $("#qrimg").attr('src',res.data.url);
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
        console.log("xixo")
        $("#staticBackdrop").modal("hide");
        // console.log("xixi")
        // $("#forgetModal").modal("show");
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
