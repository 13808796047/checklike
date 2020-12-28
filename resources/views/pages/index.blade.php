@extends('domained::layouts.app')
@section('title', '维普查重')
@section('styles')
  <link href="{{asset('asset/css/weipu-theme.css')}}" rel="stylesheet"/>
  <style>
    .swal-modal {
      width:350px;
    }
    .swal-button {
      padding: 7px 19px;
      font-size: 12px;
    }
    .swal-title {
      font-size: 20px;
    }
    .swal-text {
      background-color: #FEFAE3;
      padding: 17px;
      border: 1px solid #F0E1A1;
      display: block;
      margin: 22px;
      text-align: center;
      color: #61534e;
    }
  </style>
@stop
@section('content')

  <!-- Modal -->
  @guest
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header border-none">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <ul class="nav nav-pills d-flex justify-content-center" id="pills-tab" role="tablist">
              <li class="nav-item mr-4">
                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                   aria-controls="pills-home" aria-selected="true">账号登录</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                   aria-controls="pills-profile" aria-selected="false">手机登录</a>
              </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
              <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="w-full">
                  <form class="bg-white rounded px-4 pt-6">
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
                        type="button" id="accountLogin">
                        登录
                      </button>
                    </div>

                  </form>

                </div>
              </div>
              <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="w-full">
                  <form class="bg-white rounded px-4 pt-6">
                    <div>
                      <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        手机号码:
                      </label>
                      <input
                        class="appearance-none border rounded w-full py-2 px-2 mb-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="mobile" type="text" placeholder="请输入手机号码">
                      <p class="text-red-500 text-xs italic "></p>
                    </div>
                    <div>
                      <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        验证码:
                      </label>
                      <div class="d-flex justify-content-between py-2">
                        <input
                          class="appearance-none border border-red-500 rounded   py-2 px-2  w-full mr-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                          id="verification_code" type="text" placeholder="请输入短信验证码"/>
                        <input
                          class="bg-blue-500 hover:bg-blue-700 px-2 py-1  text-white font-bold rounded"
                          type="button" id="verificationCode" value="发送验证码">

                      </div>

                    </div>
                    <div class="flex items-center justify-between my-4">
                      <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 w-full px-4 rounded focus:outline-none focus:shadow-outline"
                        type="button" id="phoneLogin">
                        登录
                      </button>
                    </div>

                  </form>

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

          </div>
          <div class="modal-footer" style="justify-content: space-between;">
            <div style="display: flex;align-items: center;">
               <p class="text-sm">社交账号登录</p>
               <a href="{{route('oauth',['type'=>'wechat'])}}" id="toWechat" class="block mr-4" style="padding-left:23px">
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

              <a class="block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800"
                 href="{{route('register')}}">
                还没有账号?去注册
              </a>
            </p>
          </div>
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
  <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
    <ul class="carousel-indicators">
      <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
      <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
    </ul>
    <div class="carousel-inner">
      <div class="carousel-item active" style="height: 500px">
        <img src="{{ asset('asset/images/slide.jpg') }}" class="d-block w-100">
        <div class="carousel-caption d-none d-md-block" style="bottom: 30%">
          <h1 class="text-6xl">大学生 <span style="color: #F4BB36;">毕业论文</span> 查重</h1>
          <p class="p-4">适合本科、专科、自考大学生毕业论文查重，全国多个高校在使用，与学校检测结果一致。</p>
          @guest
            <a class="bg-orange-500 px-4 py-2 text-decoration-none" href="javascript:;"
               data-toggle="modal"
               data-target="#staticBackdrop"><span>立即查重</span></a>
          @else
            <a class="bg-orange-500 px-4 py-2 text-decoration-none"
               href="{{route('categories.show',['classid'=>2])}}" target="_blank"><span>立即查重</span></a>
          @endguest
        </div>
      </div>
      <div class="carousel-item" style="height: 500px">
      <img src="{{ asset('asset/images/slide.jpg') }}" class="d-block w-100">
        <div class="carousel-caption d-none d-md-block" style="bottom: 30%">
          <h1 class="text-6xl">研究生<span style="color: #F4BB36;"> 学位论文 </span> 查重</h1>
          <p class="p-4">含有博士/硕士学位论文全文数据库，更适合硕士和博士生论文查重，全国多个高校在使用。</p>
          @guest
            <a class="bg-orange-500 px-4 py-2 text-decoration-none" href="javascript:;"
               data-toggle="modal"
               data-target="#staticBackdrop"><span>立即查重</span></a>
          @else
            <a class="bg-orange-500 px-4 py-2 text-decoration-none"
               href="{{route('categories.show',['classid'=>2])}}" target="_blank"><span>立即查重</span></a>
          @endguest
        </div>
      </div>
      <div class="carousel-item" style="height: 500px;">
      <img src="{{ asset('asset/images/slide.jpg') }}" class="d-block w-100">
        <div class="carousel-caption d-none d-md-block" style="bottom: 30%">
          <h1 class="text-6xl">职称评比 <span style="color: #F4BB36;"> 期刊论文 </span>查重</h1>
          <p class="p-4">适合职称评比、已发表论文查重，可选发表时间避免出现与自己发表的论文重复的尴尬。</p>
          @guest
            <a class="bg-orange-500 px-4 py-2 text-decoration-none" href="javascript:;"
               data-toggle="modal"
               data-target="#staticBackdrop"><span>立即查重</span></a>
          @else
            <a class="bg-orange-500 px-4 py-2 text-decoration-none"
               href="{{route('categories.show',['classid'=>2])}}" target="_blank"><span>立即查重</span></a>
          @endguest
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  <div class="clearfix"></div>
  <!----- //End-slider---->
  <!----start-services---->
  <div id="ser" class="services">
    <div class="container">
      <div class="services-head text-center">
        <h3>维普论文检测系统全新升级</h3>
        <p>采用国际领先的海量论文动态语义跨域识别加指纹比对技术，通过运用最新的云检测服务部署使其能够快捷、稳定、准确地检测到文章中存在的抄袭和不当引用现象，为教育机构、科研单位、各级论文评审单位和发表单位提供了论文原创性和新颖性评价的重要依据。</p>
      </div>
      <!-----start-services-grids---->
      <div class="services-grids row">
        <div class="col-md-4 services-grid">
          <div class="row">
            <div class="col-md-3 services-grid-left">
              <a class="top-icon1" href="#"><span> </span></a>
            </div>
            <div class="col-md-9 services-grid-right">
              <h4><a href="#">丰富的比对资源</a></h4>
              <p>采用海量的论文比对数据，包含科技期刊、报纸、专利、会议、学位论文等多个论文数据库资源。</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 services-grid">
          <div class="row">
            <div class="col-md-3 services-grid-left">
              <a class="top-icon2" href="#"><span> </span></a>
            </div>
            <div class="col-md-9 services-grid-right">
              <h4><a href="#">智能的检测技术</a></h4>
              <p>采用国际领先的海量论文动态语义跨域识别加指纹比对技术，做到快捷、安全、准确、全面。</p>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="col-md-4 services-grid">
          <div class="row">
            <div class="col-md-3 services-grid-left">
              <a class="top-icon3" href="#"><span> </span></a>
            </div>
            <div class="col-md-9 services-grid-right">
              <h4><a href="#">支持手机查看结果</a></h4>
              <p>率先接入微信公众号，检测完成实时通知查重结果，随时随地方便查看，无需一直守在电脑前。</p>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
      <div class="services-grids row">
        <div class="col-md-4 services-grid">
          <div class="row">
            <div class="col-md-3 services-grid-left">
              <a class="top-icon4" href="#"><span> </span></a>
            </div>
            <div class="col-md-9 services-grid-right">
              <h4><a href="#">详细的检测报告</a></h4>
              <p>提供原文对照报告、片段对照报告、格式分析报告、比对报告、PDF报告等5个报告适合不同应用场景。</p>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="col-md-4 services-grid">
          <div class="row">
            <div class="col-md-3 services-grid-left">
              <a class="top-icon5" href="#"><span> </span></a>
            </div>
            <div class="col-md-9 services-grid-right">
              <h4><a href="#">正版数据库支持</a></h4>
              <p>本站为维普官方授权代理，所有检测报告均支持在线验证，检测结果与官方一致。</p>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="col-md-4 services-grid">
          <div class="row">
            <div class="col-md-3 services-grid-left">
              <a class="top-icon6" href="#"><span> </span></a>
            </div>
            <div class="col-md-9 services-grid-right">
              <h4><a href="#">卓越的用户体验</a></h4>
              <p>经过不断发展和努力，已经在众多行业和部门得到了广泛使用，受到了用户的高度评价。</p>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
  <!----//End-services---->
  <!-----//End-services-grids---->
  <!---- start-about----->
  <div id="about" class="about">
    <div class="container">
      <div class="about-head">
        <h4>多版本查重报告</h4>
        <p>
        维普查重提供片段对照报告、比对报告、原文对照报告、简介报告、格式分析报告等5个版本报告，其中格式分析报告可以针对封面、目录、摘要、关键词、正文、声明/致谢、参考文献、附录等进行分析，校验是格式否符合规范，同时为论文自动推荐先关参考文献。</p>
      </div>
      <!----- start-about-grids----->
      <div class="about-grids row">
        <div class="col-md-7 about-grid-left">
          <span> </span>
        </div>
        <div class="col-md-5 about-grid-right">
          <h5>片段对照报告</h5>
          <p>片段对照报告通过表格的方式将送检论文引用及相似文献来源直观地展现出来，通过片段对照报告我们可以清楚的看出所有与送检论文相似的来源。</p>
          <h6>比对报告</h6>
          <p>比对报告原名“全文比对报告”是按照送检论文原来的格式将有相似源的内容以飘红的方式展现出来，方便用户查看哪些内容是有相似源的。</p>
          @guest
            <a class="about-btn" href="javascript:;" data-toggle="modal" data-target="#staticBackdrop">立即查重</a>
          @else
            <a class="about-btn" href="{{route('categories.show',['classid'=>2])}}">立即查重</a>
          @endguest
        </div>
        <div class="clearfix"></div>
      </div>
      <!----- //End-about-grids----->
    </div>
  </div>
  <!----start-team----->
  <div id="team" class="mb-24">
    <div class="container">
      <div class=" text-center p-6">
        <h1 class="text-orange-500 text-xl mb-4">系统说明</h1>
        <p class="p-2">维普查重提供维普大学生版、维普研究生版、维普职称认定版、维普编辑部版四个版本，分别适合不同的场景使用。<font class="text-blue-500">（维普查重支持中文、英文、日文论文检测）</font>
        </p>
      </div>
      <div class="grid grid-cols-4 gap-4">
        <div class="border border-gray-300 text-center p-2">
          <img src="{{ asset('asset/images/pmlc.jpg') }}" class="w-full"/>
          <h5 class="py-2"><a>维普大学生版</a></h5>
          <span class="text-red-500">3.00元/千字</span>
          <p class="my-2 text-xs">适合本科、专科、自考大学生毕业论文查重，全国多个高校在使用，与学校检测结果一致。</p>
          @guest
            <a class="bg-blue-500 text-white  py-2 block" href="javascript:;" id="login6" data-toggle="modal"
               data-target="#staticBackdrop">立即使用</a>
          @else
            <a class="bg-blue-500 text-white  py-2 block" id="login6"
               href="{{route('categories.show',['classid'=>2])}}">立即查重</a>
          @endguest
        </div>
        <div class="border border-gray-300 text-center p-2">
          <img src="{{ asset('asset/images/wpyjs.jpg') }}" class="w-full"/>
          <h5 class="py-2"><a>维普研究生版</a></h5>
          <span class="text-red-500">3.00元/千字</span>
          <p class="my-2 text-xs">含有博士/硕士学位论文全文数据库，更适合硕士和博士生论文查重，全国多个高校在使用。</p>
          @guest
            <a class="bg-blue-500 text-white  py-2 block" href="javascript:;" id="login6" data-toggle="modal"
               data-target="#staticBackdrop">立即使用</a>
          @else
            <a class="bg-blue-500 text-white  py-2 block" id="login6"
               href="{{route('categories.show',['classid'=>2])}}">立即查重</a>
          @endguest
        </div>
        <div class="border border-gray-300 text-center p-2">
          <img src=" {{ asset('asset/images/wpbjb.jpg') }}" title="name" class="w-full"/>
          <h5 class="py-2"><a>维普编辑部版</a></h5>
          <span class="text-red-500">3.00元/千字</span>
          <p class="my-2 text-xs">适合期刊投稿、写作发表类论文查重，检测结果与期刊杂志编辑部的检测结果一致。</p>
          @guest
            <a class="bg-blue-500 text-white  py-2 block" href="javascript:;" id="login6" data-toggle="modal"
               data-target="#staticBackdrop">立即使用</a>
          @else
            <a class="bg-blue-500 text-white  py-2 block" id="login6"
               href="{{route('categories.show',['classid'=>2])}}">立即查重</a>
          @endguest
        </div>

        <div class="border border-gray-300 text-center p-2">
          <img src="{{ asset('asset/images/zhicheng.png') }}" title="name" class="w-full"/>
          <h5 class="py-2"><a>维普职称版</a></h5>
          <span class="text-red-500">30.00元/篇</span>
          <p class="my-2 text-xs">适合职称评比、已发表论文查重，可选发表时间避免出现与自己发表的论文重复的尴尬。</p>
          @guest
            <a class="bg-blue-500 text-white  py-2 block" href="javascript:;" id="login6" data-toggle="modal"
               data-target="#staticBackdrop">立即使用</a>
          @else
            <a class="bg-blue-500 text-white  py-2 block" id="login6"
               href="{{route('categories.show',['classid'=>2])}}">立即查重</a>
          @endguest
        </div>

        <div class="clearfix"></div>
      </div>
    </div>
  </div>
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
  <script type="text/javascript" src="{{ asset('asset/js/move-top.js') }}"></script>
  <script type="text/javascript" src=" {{ asset('asset/js/easing.js') }}"></script>
  {{--  <script src="{{ asset('asset/js/responsiveslides.min.js') }}"></script>--}}
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
          phone: $("input[name='phone']").val(),
          password: $("input[name='password']").val(),
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
          swal("提示",'登录成功', "success");
          console.log("xixi")
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
