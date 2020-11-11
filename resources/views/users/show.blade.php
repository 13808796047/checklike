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
	<div class="lbox fl">
     <div class="card topic-reply mt-4">
            <div>上班部分</div>
          <div class="card-body">
            @include('users._coupon_codes', ['coupon_codes' => $user->couponCodes()->paginate(5)])
          </div>
  </div>
	</div>
	<div class="rbox fr">
		<div style="background:#fff;padding:20px;">
		    <b>1、检测结果是否准确？</b>
        <p>如果你们学校也是用维普检测，那结果是一致的。同一个的系统、同样的比对库、同样的算法，所以只要在本系统提交的内容和学校的一致，那检测结果是一致的。</p>
        <b>2、检测需要多少时间？</b>
        <p>正常情况，维普检测需要10分钟左右，高峰期可能会延迟，但不会超过1个小时，如果长时间未出结果请联系客服微信：cx5078解决。</p>
        <b>3、论文上传之后安全吗？</b>
        <p>本系统有明确的条文规定并遵守严格的论文保密规定，对所有用户提交的送检文档仅做检测分析，绝不保留全文，承诺对用户送检的文档不做任何形式的收录和泄露。</p>
        <b>4、提交以后能不能退款？</b>
        <p>此系统一旦提交，系统开始检测后，即产生消费，无法退款！</p>
        <b>5、检测内容范围？</b>
        <p>系统不检测文章中的封面、致谢、学校(需要替换成"X")等个人信息，请在提交前自己删除，若提交后由系统自动删除时出现的任何问题责任自负！</p>
        <b>6、检测时作者需要填吗？</b>
        <p>在提交检测的文章中，引用了一些内以前自己所写的内容并且被小论文系统文献库收录，需要在此次检测中排除这些；则会有“去除本人已发表文献复制比”的结果。</p>
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
      $('#lwfooter').removeClass('absolute');
      var isBindPhone = {!!coupon_codes()!!}
      console.log(isBindPhone,"那哈哈")
    });
  </script>
@stop
