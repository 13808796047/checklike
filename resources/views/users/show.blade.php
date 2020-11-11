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

     <div class="card topic-reply mt-4">
            <div>上班部分</div>
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
    });
  </script>
@stop
