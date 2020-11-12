@extends('layouts.app')
@section('title', '个人中心')
@section('styles')
  <link href="{{asset('asset/css/check.css')}}" rel="stylesheet"/>
  <link href="{{asset('asset/css/theme.css')}}" rel="stylesheet"/>
  <style>
    .curfont{
      font-size:16px;
    }
    .usertitle{
      font-size: 17px;
      font-weight: bold;
      border-bottom: 1px solid;
      margin: 10px 18px;
    }
    .userword{
      margin-left: 52px;
      color: #1E90FF;
    }
  </style>
@stop
@section('content')


<div class="main clearfix" style="flex:1">

     <div class="card topic-reply mt-4" style="margin:30px 60px;">
          <div class="usertitle">基本信息</div>
          <div style="margin:0 18px;">
              <p>用户名：{{Auth::user()->phone}}<span class="userword">修改密码</span></p>
              <p>手机号：{{Auth::user()->phone}}</p>
              <p>自动降重次数: {{Auth::user()->jc_times}}次<span>充值</span></p>
              <div>
                  <span>会员:{{Auth::user()->is_free ==1 ? "您还不是会员" : "会员" }}</span>
                  @if(Auth::user()->is_free ==1)
                     <span class="userword">开通会员</span>
                  @else
                     <span>会员还剩余{{Auth::user()->vip_days}}</span>
                  @endif
              </div>
              <p></p>
          </div>
          <div class="usertitle">卡券管理</div>
          <div></div>
          <div class="card-body">
            @include('users._coupon_codes', ['coupon_codes' => $user->couponCodes()->paginate(5)])
          </div>
    </div>
</div>


<!--/.fluid-container-->

@endsection
@section('scripts')
  <script>
     $(document).ready(function () {
      $('.navbar').css('position','static')
      $('#navigation').addClass('affix')
      $('#app').removeClass('newmain')
      $("#lwfooter").css("position","absolute")

    });
  </script>
@stop
