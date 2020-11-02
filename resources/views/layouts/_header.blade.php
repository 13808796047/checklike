<style>
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top"
     style="box-shadow: 0 0 6px rgba(0, 0, 0, 0.3);padding:0;">
     <div style="background-color: #3182ce;height: 100%;padding: 3px;">
    <a class="navbar-brand " href="{{ url('/') }}" style="height: 50px;margin-top: 10px;margin-left: 10px;">
      <img src="https://p.checklike.com/asset/images/checklike.png" alt="" style="height:100%;">
    </a>
    </div>
  <div class="container">
    <!-- Branding Image -->

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left Side Of Navbar -->
      <ul class="navbar-nav mr-auto" id="headerlw" style="align-items:center;">
        <li class="nav-item px-2 {{ active_class(if_route('domained::pages.index')) }}"><a
            class="nav-link text-blue-300"
            href="{{ url('/') }}">首页</a>
        </li>
        <li class="nav-item dropdown px-2 {{ active_class((if_route('categories.show') && if_route_param('classid', 2))) }}">

        @guest
         <a class="nav-link" href="javascript:;" data-toggle="modal"
               data-target="#staticBackdrop">初稿查重</a>
        @else
        <span class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="display: inline;">
        初稿查重
        </span>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item istoaster" href="/categories/1">CheckLike</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item istoaster" href="/categories/5">PaperPass</a>
            </div>
        @endguest

        </li>
        <li class="nav-item dropdown px-2 {{ active_class((if_route('categories.show') && if_route_param('classid', 2))) }}">

         @guest
          <a class="nav-link" href="javascript:;" data-toggle="modal"
                data-target="#staticBackdrop">定稿查重</a>
         @else
         <span class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="display: inline;">
          定稿查重
        </span>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item istoaster" href="/categories/4">万方检测</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item istoaster" href="/categories/2">维普查重</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item istoaster" href="/categories/3">知网查重</a>
        </div>
         @endguest

       </li>
       <li class="nav-item px-2">
          @guest
            <a class="nav-link" href="javascript:;" data-toggle="modal"
               data-target="#staticBackdrop">自动降重</a>
          @else
            <a href="/ai_rewrite"
                class="block  lg:inline-block lg:mt-0 text-black-500 hover:text-blue-600 mr-4 text-decoration-none" style="margin-left:15px;">
                自动降重
            </a>
          @endguest
       </li>
        <li class="nav-item px-2 {{ active_class((if_route('categories.show') && if_route_param('classid', 2))) }}">
          @guest
            <a class="nav-link" href="javascript:;" data-toggle="modal"
               data-target="#staticBackdrop">查看报告</a>
          @else
            <a class="nav-link" href="{{route('orders.index')}}">查看报告</a>
          @endguest
        </li>
        <li class="nav-item px-2"><a class="nav-link" href="javascript:void(0)"
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
          <li class="nav-item"><a class="nav-link" id='RegisterDialogBtn'" href="javascript:;">注册</a></li>
        @else
          <li class="nav-item"><a class="nav-link logout" href="javascript:;">退出登录</a></li>
          @if(Auth::user()->phone)
          <li class="nav-item"><a class="nav-link" href="javascript:;" id="xiugai">修改密码</a></li>
          @else
          <li class="nav-item"><a class="nav-link" href="javascript:;" id="bindSelfPhone">绑定手机号</a></li>
          @endif
        @endguest
      </ul>
    </div>
  </div>
</nav>

<div class="modal fade" id="staticXiugai" tabindex="-1" role="dialog" aria-labelledby="staticXiugaiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width:330px;">
    <div class="modal-content">
      <div style="padding:20px;">
        <div>
          <label class="block text-gray-700 text-sm font-bold mb-2" for="xgpsd">
            密码:
          </label>
          <input
              class="appearance-none border rounded w-full py-2 px-3 mb-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              name="xgpsd"
              id="xgpsd" type="password" placeholder="请输入密码">
        </div>
        <div>
          <label class="block text-gray-700 text-sm font-bold mb-2" for="xgsurepsd">
            确认密码:
          </label>
          <input
              class="appearance-none border rounded w-full py-2 px-3 mb-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              name="xgsurepsd"
              id="xgsurepsd" type="password" placeholder="请输入确认密码">
        </div>
        <div style="color:red;" id="xgtoast">

        </div>
        <div class="flex items-center justify-evenly my-4">
            <button
              type="button" class="btn btn-secondary"
              id="xiugaicancel">
              取消
            </button>
            <button
              type="button" class="btn btn-primary"
              id="xiugaisure">
              确认
            </button>
          </div>
      </div>
    </div>
  </div>
</div>

<!--绑定 -->

<div class="modal fade" id="bindTitle" tabindex="-1" role="dialog" aria-labelledby="bindTitleLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width:370px;">
    <div class="modal-content">
      <div style="padding:20px;">
        <div>
          <label class="block text-gray-700 text-sm font-bold mb-2" for="xgpsd">
            手机号:
          </label>
          <input
              class="appearance-none border rounded w-full py-2 px-3 mb-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              name="xgpsd"
              id="bindphonenum" type="text" placeholder="请输入手机号">
        </div>
        <div>
          <label class="block text-gray-700 text-sm font-bold mb-2" for="xgpsd">
            验证码:
          </label>
          <div>
            <input
              class="appearance-none border rounded w-full py-2 px-3 mb-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              name="xgpsd"
              id="bindCodeNow" type="text" placeholder="验证码" style="width:63%;">
            <button type="button" class="btn btn-primary" style="margin-left:10px;" id="sendYzCode">发送验证码</button>
          </div>
        </div>
        <div id="bindphoneTip" style="color:red;"></div>
        <div class="flex items-center justify-evenly my-4">
            <button
              type="button" class="btn btn-secondary"
              id="bindno">
              暂不绑定
            </button>
            <button
              type="button" class="btn btn-primary"
              id="bindnow">
              绑定
            </button>
          </div>
          <div style="text-align:center;color:#999;font-size:14px;">绑定手机可合并原账号订单以及接受订单通知</div>
      </div>

    </div>
  </div>
</div>

<!-- 注册 -->
<div class="modal fade" id="registerTcDialog" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="registerTcDialogLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" style="width:390px;">
    <div class="modal-content">
    <div style="padding:5px 17px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <div style="padding:10px 17px;">
            <div>
              <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">
              手机号:
              </label>
              <input
                 class="appearance-none border rounded w-full py-2 px-3 mb-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                 name="phone"
                 id="registerphones" type="text" placeholder="请输入手机号码">
            </div>
            <div>
               <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                 密码:
               </label>
               <input
                 class="appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                 name="password"
                 id="registerpassword" type="password" placeholder="请输入密码" >
            </div>
            <div>
               <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                 确认密码:
               </label>
               <input
                 class="appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                 name="password"
                 id="password_confirmation" type="password" placeholder="请输入密码" value="{{ old('password') }}">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="yzmcode">
                  验证码:
                </label>
                <div>
                  <input
                    class="appearance-none border rounded w-full py-2 px-3 mb-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="yzmcode"
                    id="bindCoderegister" type="text" placeholder="验证码" style="width:63%;">
                  <button type="button" class="btn btn-primary" style="margin-left:10px;" id="sendRegisterYzCode">发送验证码</button>
            </div>
            <div id="registerTip" style="color:red;margin-bottom:10px;"></div>
            <button type="button" class="btn btn-large btn-block" id="submitRegisterBtn" style="background:#26AEF2;color:#fff;">
                提交注册
            </button>
        </div>
         </div>
      </div>
    </div>
  </div>
</div>
