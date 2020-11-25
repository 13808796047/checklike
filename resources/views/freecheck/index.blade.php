@extends('layouts.app')
@section('title', '查看订单')
@section('styles')
  <link href="{{asset('asset/css/check.css')}}" rel="stylesheet"/>
  <style>
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
            @guest
            <li><a class="nav-link" href="javascript:;" data-toggle="modal" data-target="#staticBackdrop">免费查重</a></li>
            @else
            <li><a href="/categories/4" class="smooth-scroll">免费查重</a></li>
            @endguest
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
      <b>1、检测结果是否准确？</b>
        <p id="rightcontainer"></p>
        <b>2、检测需要多少时间？</b>
        <p>正常情况，检测需要<span id="banbentimer">10分钟</span>左右，高峰期可能会延迟。如果长时间未出结果请联系客服解决。</p>
        <b>3、论文上传之后安全吗？</b>
        <p>本系统有明确的条文规定并遵守严格的论文保密规定，对所有用户提交的送检文档仅做检测分析，绝不保留全文，承诺对用户送检的文档不做任何形式的收录和泄露。</p>
        <b>4、提交以后能不能退款？</b>
        <p>系统一旦提交，开始检测后，即产生消费，无法退款，请谅解！</p>
        <b>5、检测内容范围？</b>
        <p>系统主要检测论文正文，封面、目录、致谢以及个人信息可以删除后再上传。</p>
        <b>6、检测时作者需要填吗？</b>
        <p>在提交检测的文章中，引用了一些内以前自己所写的内容并且被小论文系统文献库收录，需要在此次检测中排除这些；则需要填写真实作者姓名。</p>
      </div>
    </div>
  </div>


</div>

<!--/.fluid-container-->

@endsection
@section('scripts')
  <script>
     $(document).ready(function () {
    });
  </script>
@stop
