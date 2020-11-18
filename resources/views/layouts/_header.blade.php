<style>
</style>

<div id="header1">
     <nav id="navigation" class="navbar scrollspy">
				<div class="container">
					<div class="navbar-brand" style="width:316px;">
						<a href="javascript:void(0)" onclick="window.location.href='/'"><img src= "{{ asset('asset/images/checklike.png') }}" alt=""></a>
					</div>
					<ul class="nav navbar-nav" style="flex:1">
						<li><a href="javascript:void(0)" onclick="window.location.href='/'" class="smooth-scroll">网站首页</a></li>
            @guest
            <li><a class="nav-link" href="javascript:;" data-toggle="modal" data-target="#staticBackdrop">论文查重</a></li>
            @else
            <li><a href="/categories/1" class="smooth-scroll">论文查重</a></li>
            @endguest
            @guest
            <li><a class="nav-link" href="javascript:;" data-toggle="modal" data-target="#staticBackdrop">免费查重</a></li>
            @else
            <li><a href="/categories/4" class="smooth-scroll">免费查重</a></li>
            @endguest
            @guest
            <li><a class="nav-link" href="javascript:;" data-toggle="modal" data-target="#staticBackdrop">自动降重</a></li>
            @else
            <li><a href="/ai_rewrite" class="smooth-scroll">自动降重</a></li>
            @endguest
            @guest
            <li><a class="nav-link" href="javascript:;" data-toggle="modal" data-target="#staticBackdrop">报告下载</a></li>
            @else
            <li><a href="{{route('orders.index')}}" class="smooth-scroll">报告下载</a></li>
            @endguest
            @guest
						<li class="menu-btn" style="padding-right:0"><a class="nav-link" href="javascript:;" data-toggle="modal"
            data-target="#staticBackdrop" >登录</a></li>
            <!-- <li class="menu-btn" style="padding-left:0;"><a class="nav-link" href="javascript:;"
            id="RegisterDialogBtn">注册</a></li> -->
            @else
            <li class="menu-btn" style="padding-right:0"><a class="logout" href="javascript:;">退出</a></li>
            <li class="menu-btn" style="padding-left:0;margin-left:2px;"><a href="/users/{{Auth::user()->id}}">个人中心</a></li>
            @endguest
					</ul>
          </nav>
        </div>
</div>



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
            <div class="input-group">
              <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">
              手机号:
              </label>
              <input
                 class="appearance-none border rounded w-full py-2 px-3 mb-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                 name="phone"
                 id="registerphones" type="text" placeholder="请输入手机号码">
            </div>
            <div class="input-group">
               <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                 密码:
               </label>
               <input
                 class="appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                 name="password"
                 id="registerpassword" type="password" placeholder="请输入密码" >
            </div>
            <div class="input-group">
               <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                 确认密码:
               </label>
               <input
                 class="appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                 name="password"
                 id="password_confirmation" type="password" placeholder="请输入密码" value="{{ old('password') }}">
            </div>
            <div class="input-group">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="yzmcode">
                  验证码:
                </label>
                <div>
                  <input
                    class="appearance-none border rounded w-full py-2 px-3 mb-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="yzmcode"
                    id="bindCoderegister" type="text" placeholder="验证码" style="width:63%;">
                  <button type="button" class="btn btn-primary btn-sm" style="margin-left:10px;" id="sendRegisterYzCode">发送验证码</button>
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


<div class="modal fade" id="delcfmModel">
    <div class="modal-dialog">
        <div class="modal-content message_align">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <h4 class="modal-title">确认信息</h4>
            </div>
            <div class="modal-body">
                <p id="delcfmMsg">您确认要删除吗？</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="submitUrl"/>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <a onclick="urlSubmit()" class="btn btn-success" data-dismiss="modal">确定</a>
            </div>
        </div>
    </div>
</div>
