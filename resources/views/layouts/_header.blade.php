{{--<style>--}}

{{--  /*-----start-header----*/--}}
{{--  .logo {--}}
{{--    float: left;--}}
{{--  }--}}

{{--  .logo a {--}}
{{--    color: #FFF;--}}
{{--    font-weight: 700;--}}
{{--    margin-top: 1em;--}}
{{--  }--}}

{{--  .logo a:hover {--}}
{{--    text-decoration: none;--}}
{{--  }--}}

{{--  .logo320 {--}}
{{--    display: none;--}}
{{--  }--}}

{{--  /*----navbar-nav----*/--}}
{{--  .top-nav ul li a {--}}
{{--    color: #000000;--}}
{{--    padding: 0.2em 1.9em;--}}
{{--    font-size: 1em;--}}
{{--    font-weight: 400;--}}
{{--    text-align: center;--}}
{{--    text-transform: uppercase;--}}
{{--    position: relative;--}}
{{--  }--}}

{{--  .top-nav ul li a span {--}}
{{--    height: 20px;--}}
{{--    width: 1px;--}}
{{--    display: inline-block;--}}
{{--    background: #C2C2C2;--}}
{{--    position: absolute;--}}
{{--    top: 29%;--}}
{{--    right: 0;--}}
{{--  }--}}

{{--  .top-nav ul li.active a,--}}
{{--  .top-nav ul li a:hover {--}}
{{--    color: #F4BB36;--}}
{{--  }--}}

{{--  .logo a {--}}
{{--    display: block;--}}
{{--  }--}}

{{--  /* top-nav */--}}
{{--  .top-nav:before,--}}
{{--  .top-nav:after {--}}
{{--    content: " ";--}}
{{--    display: table;--}}
{{--  }--}}

{{--  .top-nav:after {--}}
{{--    clear: both;--}}
{{--  }--}}

{{--  nav {--}}
{{--    position: relative;--}}
{{--    float: right;--}}
{{--  }--}}

{{--  nav ul {--}}
{{--    padding: 0;--}}
{{--    float: right;--}}
{{--    margin: 0.75em 0;--}}
{{--  }--}}

{{--  nav li {--}}
{{--    display: inline;--}}
{{--    float: left;--}}
{{--    position: relative;--}}
{{--  }--}}

{{--  nav a {--}}
{{--    color: #fff;--}}
{{--    display: inline-block;--}}
{{--    text-align: center;--}}
{{--    text-decoration: none;--}}
{{--    line-height: 40px;--}}
{{--  }--}}

{{--  nav a:hover {--}}
{{--    text-decoration: none;--}}
{{--    color: #00A2C1;--}}
{{--  }--}}

{{--  nav a#pull {--}}
{{--    display: none;--}}
{{--  }--}}

{{--  .tlinks {--}}
{{--    text-indent: -9999px;--}}
{{--    height: 0;--}}
{{--    line-height: 0;--}}
{{--    font-size: 0;--}}
{{--    overflow: hidden;--}}
{{--  }--}}

{{--  /*Styles for screen 600px and lower*/--}}
{{--  @media screen and (max-width: 768px) {--}}
{{--    nav {--}}
{{--      height: auto;--}}
{{--      float: none;--}}
{{--    }--}}

{{--    nav ul {--}}
{{--      width: 100%;--}}
{{--      display: block;--}}
{{--      height: auto;--}}
{{--    }--}}

{{--    nav li {--}}
{{--      width: 100%;--}}
{{--      position: relative;--}}
{{--    }--}}

{{--    nav li a {--}}
{{--      border-bottom: 1px solid #eee;--}}
{{--    }--}}

{{--    nav a {--}}
{{--      text-align: left;--}}
{{--      width: 100%;--}}
{{--      text-indent: 25px;--}}
{{--    }--}}
{{--  }--}}

{{--  /*Styles for screen 515px and lower*/--}}
{{--  @media only screen and (max-width: 768px) {--}}
{{--    nav {--}}
{{--      border-bottom: 0;--}}
{{--      float: none;--}}
{{--    }--}}

{{--    nav ul {--}}
{{--      display: none;--}}
{{--      height: auto;--}}
{{--      margin: 0;--}}
{{--      background: #fff;--}}
{{--    }--}}

{{--    nav a#pull {--}}
{{--      display: block;--}}
{{--      position: relative;--}}
{{--      color: #F26D7D;--}}
{{--      text-align: right;--}}
{{--      position: absolute;--}}
{{--      top: 12px;--}}
{{--    }--}}

{{--    nav a#pull:after {--}}
{{--      content: "";--}}
{{--      background: url('nav-icon.png') no-repeat;--}}
{{--      width: 30px;--}}
{{--      height: 30px;--}}
{{--      display: inline-block;--}}
{{--      position: absolute;--}}
{{--      right: 15px;--}}
{{--      top: 10px;--}}
{{--    }--}}

{{--    nav a#pull img {--}}
{{--      margin-right: 2%;--}}
{{--    }--}}

{{--    .top-nav ul li a {--}}
{{--      color: #2C3E50;--}}
{{--      padding: 0em 0;--}}
{{--    }--}}
{{--  }--}}
{{--</style>--}}
{{--<nav class="flex items-center justify-between flex-wrap bg-white-100 shadow-2xl">--}}
{{--  <div class="flex items-center flex-shrink-0 text-white mr-6 bg-blue-600 p-2">--}}
{{--    <a href="/"><img src="https://css.lianwen.com/logo/2019/weipudx.png" alt=""></a>--}}
{{--  </div>--}}
{{--  <div class="w-full flex-grow lg:flex lg:items-center lg:w-auto">--}}
{{--    <div class="text-sm lg:flex-grow">--}}
{{--      @foreach($categories as $category)--}}
{{--        <a href="{{route('categories.show',['classid'=>$category->classid])}}"--}}
{{--           class="block  lg:inline-block lg:mt-0 text-black-500 hover:text-blue-600 mr-4 text-decoration-none">--}}
{{--          {{$category->classname}}--}}
{{--        </a>--}}
{{--      @endforeach--}}
{{--      <a href="{{route('orders.index')}}"--}}
{{--         class="block  lg:inline-block lg:mt-0 text-black-500 hover:text-blue-600 mr-4 text-decoration-none">--}}
{{--        查看报告--}}
{{--      </a>--}}
{{--    </div>--}}
{{--    @auth--}}
{{--      <div class="flex justify-content-around w-25 align-items-center">--}}
{{--        <span>{{auth()->user()->phone??auth()->user()->nickname}}</span>--}}
{{--        <img--}}
{{--          src="{{Auth::user()->avatar??'https://css.lianwen.com/images/head.jpg'}}"--}}
{{--          class=" w-10 h-10"/>--}}

{{--        <a href="javascript:;"--}}
{{--           class="logout inline-block text-sm px-4 py-1 bg-teal-500 border rounded text-white border-white hover:border-transparent hover:text-black-500 hover:bg-red--}}
{{--          lg:mt-0">登出</a>--}}
{{--      </div>--}}
{{--    @endauth--}}
{{--  </div>--}}
{{--</nav>--}}
{{--<nav class="flex items-center justify-between flex-wrap bg-white-100" style="display: flex;flex-wrap: nowrap;">--}}
{{--  <div class="flex items-center" style="background-color:#0084DB;width: 20%;">--}}
{{--    <a href=" ">--}}
{{--      <img src="https://css.lianwen.com/logo/2019/weipudx.png" alt=""--}}
{{--           style="width: 100%;padding: 15px;height: 100%;"></a>--}}
{{--  </div>--}}
{{--  <div style="display:flex;flex: 1;align-items: center;box-sizing: border-box;flex-wrap: nowrap;">--}}
{{--    @foreach($categories as $category)--}}
{{--      <a href="{{route('categories.show',['classid'=>$category->classid])}}"--}}
{{--         class="block lg:inline-block lg:mt-0 text-black-500 hover:text-blue-600 mr-4 text-decoration-none"--}}
{{--         style="margin: 0 25px;">{{$category->classname}}</a>--}}
{{--    @endforeach--}}
{{--    <a href="{{route('orders.index')}}"--}}
{{--       class="block  lg:inline-block lg:mt-0 text-black-500 hover:text-blue-600 mr-4 text-decoration-none"--}}
{{--       style="margin: 0 25px;">--}}
{{--      查看报告--}}
{{--    </a>--}}
{{--  </div>--}}
{{--  @auth--}}
{{--    <div class="w-25 align-items-center" style="display: flex;flex-wrap: nowrap;">--}}
{{--      <span>{{auth()->user()->phone??auth()->user()->nickname}}</span>--}}
{{--      <img src="{{Auth::user()->avatar??'https://css.lianwen.com/images/head.jpg'}}" class=" w-10 h-10"/>--}}

{{--      <a href="javascript:;" class="logout inline-block text-sm px-4 py-1 bg-teal-500 border rounded text-white border-white hover:border-transparent hover:text-black-500 hover:bg-red--}}
{{--        lg:mt-0">登出</a>--}}
{{--    </div>--}}
{{--  @endauth--}}
{{--</nav>--}}
{{--<div id="home" class="header" style="box-shadow: 0 0 6px rgba(0, 0, 0, 0.3);">--}}
{{--  <div class="container">--}}
{{--    <div class="logo">--}}
{{--      <a href="/"><img src="http://wanfang.lianwen.com/asset/images/logo/wanfang.png" title="logo"/></a>--}}
{{--    </div>--}}
{{--    <!----start-top-nav---->--}}
{{--    <nav class="top-nav float-left ml-16">--}}
{{--      <ul class="top-nav">--}}
{{--        <li class="active"><a href="/" class="scroll">首页<span> </span></a></li>--}}

{{--        <li class="page-scroll"><a href="{{route('categories.show',['classid'=>2])}}" id="login1"--}}
{{--                                   class="scroll">万方查重<span> </span></a></li>--}}

{{--        <li class="page-scroll"><a href="{{route('orders.index')}}" id="down" class="scroll">查看报告<span> </span></a></li>--}}
{{--        <li class="contatct-active" class="page-scroll"><a href="javascript:void(0)"--}}
{{--                                                           onclick="window.open('http://p.qiao.baidu.com/cps/chat?siteId=12623578&userId=26512539&cp=lianwen&cr=lianwen&cw=PC',height='680',width='900')"--}}
{{--                                                           class="scroll">在线咨询</a></li>--}}
{{--      </ul>--}}
{{--    </nav>--}}
{{--    @auth--}}

{{--      <div class="align-items-center float-right flex text-sm mt-3">--}}
{{--        --}}{{--            <span>{{auth()->user()->phone??auth()->user()->nickname}}</span>--}}
{{--        --}}{{--            <img src="{{Auth::user()->avatar??'https://css.lianwen.com/images/head.jpg'}}" class=" w-10 h-10"/>--}}

{{--        <a href="javascript:;" class="logout inline-block text-sm px-4 py-1 bg-blue-500 text-white">登出</a>--}}
{{--      </div>--}}
{{--    @else--}}
{{--      <div class="flex justify-content-around pt-3">--}}
{{--        <a href="javascript:;" class="login inline-block text-sm px-4 py-1 bg-blue-500 text-white " data-toggle="modal"--}}
{{--           data-target="#staticBackdrop">登录</a>--}}
{{--        <a href="{{ route('register')}}" class="login inline-block text-sm px-4 py-1 bg-blue-500 text-white ">注册</a>--}}
{{--      </div>--}}
{{--    @endauth--}}
{{--    <div class="clearfix"></div>--}}
{{--  </div>--}}
{{--</div>--}}
<!----- //End-header---->
<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top"
     style="box-shadow: 0 0 6px rgba(0, 0, 0, 0.3);">
  <div class="container">
    <!-- Branding Image -->
    <a class="navbar-brand " href="{{ url('/') }}">
      <img src="https://wanfang.lianwen.com/asset/images/vpcs-logo.png" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left Side Of Navbar -->
      <ul class="navbar-nav mr-auto" id="headerlw">
        <li class="nav-item px-4 {{ active_class(if_route('domained::pages.index')) }}"><a
            class="nav-link text-blue-300"
            href="{{ url('/') }}">首页</a>
        </li>
        <li class="nav-item px-4 {{ active_class((if_route('categories.show') && if_route_param('classid', 2))) }}">
          @guest
            <a class="nav-link" href="javascript:;" data-toggle="modal"
               data-target="#staticBackdrop">维普查重</a>
          @else
            <a
              class="nav-link"
              href="{{route('categories.show',['classid'=>2])}}"
            >维普查重</a>
          @endguest
        </li>
        <li class="nav-item px-4 {{ active_class((if_route('categories.show') && if_route_param('classid', 2))) }}">
          @guest
            <a class="nav-link" href="javascript:;" data-toggle="modal"
               data-target="#staticBackdrop">查看报告</a>
          @else
            <a class="nav-link" href="{{route('orders.index')}}">查看报告</a>
          @endguest
        </li>
        <li class="nav-item px-4"><a class="nav-link" href="javascript:void(0)"
                                     onclick="window.open('http://p.qiao.baidu.com/cps/chat?siteId=12623578&userId=26512539&cp=lianwen&cr=lianwen&cw=PC',height='680',width='900')">在线咨询</a>
        </li>
        {{--        <li class="active"><a href="/" class="scroll">首页<span> </span></a></li>--}}

        {{--        <li class="page-scroll"><a href="{{route('categories.show',['classid'=>2])}}" id="login1"--}}
        {{--                                   class="scroll">万方查重<span> </span></a></li>--}}

        {{--        <li class="page-scroll"><a href="{{route('orders.index')}}" id="down" class="scroll">查看报告<span> </span></a></li>--}}
        {{--        <li class="contatct-active" class="page-scroll"><a href="javascript:void(0)"--}}
        {{--                                                           onclick="window.open('http://p.qiao.baidu.com/cps/chat?siteId=12623578&userId=26512539&cp=lianwen&cr=lianwen&cw=PC',height='680',width='900')"--}}
        {{--                                                           class="scroll">在线咨询</a></li>--}}

      </ul>

      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav navbar-right">
      @guest
        <!-- Authentication Links -->
          <li class="nav-item"><a class="nav-link" href="javascript:;" data-toggle="modal"
                                  data-target="#staticBackdrop">登录</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">注册</a></li>
        @else
          <li class="nav-item"><a class="nav-link logout" href="javascript:;">退出登录</a></li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
