@extends('layouts.app')
@section('title', '查看订单')
@section('styles')
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
    .freecheckleft p{
      font-size:15px;
      text-indent:2em;
      line-height:2;
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
  <div style="padding:30px 50px;" class="freecheckleft">
    <div style="text-align: center;font-size: 23px;font-weight: bold;">真金不怕火炼，CheckLike提供免费查重服务</div>
    <div style="font-size:13px;color:#A9A9A9;text-align:center;margin:5px 0;">活动时间：2020-10-01 至2021-07-31</div>
    <p>CheckLike论文相似度检测系统采用国际领先的海量论文动态语义跨域识别加指纹比对技术，通过运用最新的云检测服务部署使其能够快捷、稳定、准确地检测到文章中存在的抄袭和不当引用现象，实现了对学术不端行为的检测服务。</p >
    <p>通过系统检测可快速准确地检测出论文中不当引用、过度引用甚至是抄袭、伪造、篡改等学术不端行为，可自动生成检测报告，并支持PDF、网页等浏览格式。详细的检测报告通过不同颜色标注相似片段、引用片段、专业用语，形象直观地显示相似内容比对、相似文献汇总、引用片段出处、总相似比、引用率、复写率和自写率等重要指标，为教育机构、科研单位、各级论文评审单位和发表单位提供了论文原创性和新颖性评价的重要依据。经过不断发展和努力，已经在众多行业和部门得到了广泛使用，受到了用户的高度评价。</p>
    <p>为了让更多用户体验到CheckLike的检测效果，我们推出免费查重活动：</p>
    <p><b>活动对象：</b>所有用户</p>
    <p><b>规则说明：</b>活动期间，所有用户均可使用CheckLike专业版免费查重一篇1万字以内的论文（一万字以内免费，超过一万字部分按3元/万字收费）。</p >
    <p><b>活动时间：</b>2020-10-01 至2021-07-31</p>

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
