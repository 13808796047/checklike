<style>

</style>
  <header id="header">
     <nav id="navigation" class="navbar scrollspy">
				<!-- .container -->
				<div class="container">

					<div class="navbar-brand">
						<a href="javascript:void(0)" onclick="window.location.href='/'"><img src= "{{ asset('asset/images/checklike.png') }}" alt=""></a>
					</div>
					<ul class="nav navbar-nav">
						<li><a href="javascript:void(0)" onclick="window.location.href='/'" class="smooth-scroll">网站首页</a></li>
						<li><a href="/categories/1" class="smooth-scroll">论文查重</a></li>
						<li><a href="/categories/4" class="smooth-scroll">免费查重</a></li>
						<li><a href="/ai_rewrite" class="smooth-scroll">自动降重</a></li>
						<li><a href="{{route('orders.index')}}" class="smooth-scroll">报告下载</a></li>
						<li class="menu-btn"><a href="page.html">登录/注册</a></li>
					</ul>
			</nav>
      </div>
  </header>

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
