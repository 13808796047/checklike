@extends('layouts.app')
@section('title','免费查重')
@section('styles')
<!-- <link href="{{asset('asset/css/toast-min.css')}}" rel="stylesheet" /> -->
<link rel="stylesheet" href="{{asset('asset/css/check.css')}}">
<style>
</style>
  <div id="header1">
     <nav id="navigation" class="navbar scrollspy affix" style="position: static;">
				<div class="container">
					<div class="navbar-brand" style="width:395px;margin-right:70px;">
						<a href="javascript:void(0)" onclick="window.location.href='/'"><img src= "{{ asset('asset/images/checklike.png') }}" alt=""></a>
					</div>
					<ul class="newul" style="flex:1;">
            <div style="display:flex;justify-content:space-between;width:100%;">
            <div style="display:flex;align-items: center;margin-left:13px;">
						      <li><a href="javascript:void(0)" onclick="window.location.href='/'" class="smooth-scroll">网站首页</a></li>
                  <li><a href="/categories/1" class="smooth-scroll">论文查重</a></li>
                  <li><a href="/categories/4" class="smooth-scroll">免费查重</a></li>
                  <li><a href="/rewrite" class="smooth-scroll">自动降重</a></li>
                  <li><a href="/orders" class="smooth-scroll">报告下载</a></li>
            </div>
            <div style="display:flex;align-items: center;">
                <li class="ambtn"><a href="/users/{{Auth::user()->id}}">个人中心</a></li>
                <li class="ambtn" style="margin:0;"><a class="logout" href="javascript:;">退出</a></li>
            </div>
            </div>
          </ul>
          </div></nav>
  </div>
  <div class="container" style="margin:18px auto">
      <div class="grid grid-cols-12 gap-4">
      </div>
    <div class="col-span-3"  id="jcright">
      <div>
      <div style="background:#54B538;color: #fff;padding-left: 20px;font-size: 15px;height: 44px;line-height: 44px;">系统客服</div>
      <div style="border-bottom: 1px solid #c1bebd;box-shadow: 0px 0px 5px #c1bebd;padding: 15px;background: #FFFFFF;">
          <img src="https://www.checklike.com/images/qrcode/sz-work.png" style="width:171px;height:171px;display:block;margin:0 auto;">
          <p style="text-align:center;margin-top:7px;font-size:13px;">微信扫一扫，与客服在线沟通</p>
      </div>
      </div>
      <div style="background:#fff;box-shadow: 0 0 6px rgba(0, 0, 0, 0.3);margin-top:13px;" class="p-4">
        <b>1、怎么选择适合自己的论文检测系统？</b>
        <p>只有使用和学校相同的数据库，才能保证重复率与学校、杂志社100%一致：</br>论文初次修改可使用联文检测、PaperPass，定稿再使用与学校一样的系统。</p>
        <b>2、检测要多长时间，报告怎么还没出来？</b>
        <p>正常检测20分钟左右，毕业高峰期，服务器检测压力大，时间会有延长，请大家提前做好时间准备。超过2小时没出结果可以联系客服处理！</p>
        <b>3、同一篇论文可以多次检测吗？？</b>
        <p>本站不限制论文检测次数，但检测一次需支付一次费用。</p>
        <b>4、检测报告有网页版、pdf格式的吗？</b>
        <p>检测完成后会提供网页版和pdf格式的检测报告，报告只是格式不同，重复率都一样的。</p>
      </div>
    </div>
  </div>
</div>
@stop
@section('scripts')

  <script>
  </script>
@stop
