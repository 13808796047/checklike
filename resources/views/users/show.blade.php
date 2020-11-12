@extends('layouts.app')
@section('title', '个人中心')
@section('styles')
  <link href="{{asset('asset/css/check.css')}}" rel="stylesheet"/>
  <link href="{{asset('asset/css/theme.css')}}" rel="stylesheet"/>
  <style>
    .curfont{
      font-size:16px;
    }

  </style>
@stop
@section('content')


<div class="main clearfix" style="flex:1">

     <div class="card topic-reply mt-4" style="margin:30px 60px;">
          <div>
              <p>用户名：{{Auth::user()->phone}}</p>
              <p>手机号：{{Auth::user()->phone}}</p>
              <p>自动降重次数: {{Auth::user()->jc_times}}</p>
              <p>会员:{{Auth::user()->is_free}}</p>
          </div>

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
