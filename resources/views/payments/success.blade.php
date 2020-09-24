@extends('domained::layouts.app')
@section('title','支付结果')
@section('styles')
  <!-- <link href="https://css.lianwen.com/css/public_c.css?v=2018v1" type="text/css" rel="stylesheet"/>
  <link href="https://css.lianwen.com/css/index_2017.css" type="text/css" rel="stylesheet"/> -->
  <!-- <link rel="stylesheet" href="{{asset('asset/css/index.css')}}"> -->
  <link rel="stylesheet" href="{{asset('asset/css/check.css')}}">
  <style>
   .lwjc_title{overflow:hidden; padding:40px;border-bottom:solid 1px #eeeeee; }
   .lwjc_title h4{font-size:28px; padding-left: 115px!important; height:80px!important; color:#666666; font-size:26px; line-height:96px; background:url(../images/icon_eye.png) no-repeat; float:left; padding-left:105px;}
   .lwjc_title h3{ color:#666666;font-size:26px; line-height:36px; float:left;}
   .lwjc_title .nav a{width:90px; height:34px; background-color:#0083cd; display:block; text-align:center; line-height:34px; color:#fff; float:right; margin-top:32px;}
   .lwjc_title p{ float:left; color:#666666; font-size:14px; margin-top:10px; text-indent:2em; line-height:28px;}
   .result{overflow:hidden; padding:30px 40px; padding-bottom:0px; font-size:14px; line-height:28px;}
   .result h3{ color:#666666; font-size:26px; line-height:56px; float:left;}
   .cbox{ padding:30px; font-size:14px;}
   .submit dl{ clear:both; width:738px; margin:0px auto; padding:12px;}
   .submit dt{ float:left; padding:5px; padding-right:20px;}
   .submit dd{ float:left; text-align:left;}
   .down{ width:738px; margin:0 auto;}
   table.mylist {
	border: 1px solid #CDCDCD;
	border-collapse: collapse;
	padding: 2px;
	width: 756px;
	margin: 5px 0;
}

.mylist td, .mylist th {
	border: 1px solid #CDCDCD;
	padding: 8px 5px;
	text-align: center;
}
.mylist .td{ text-align:left !important; padding-left:10px !important; padding-top:15px !important; padding-top:15px !important;}
.tips{ font-size:12px; color:#777; text-indent:1.5em; line-height:23px; padding-top:5px;}
.text-error {
  color: #b94a48;
}
   .submit .txt{ padding:5px 10px; width:168px;}
   .yh0{font-family: Microsoft YaHei,"微软雅黑", STXihei,"华文细黑",SimSun,"宋体", Heiti,"黑体",sans-serif;}
   .submit .radio input{ padding-left:0;}
   .submit .text{ border:#C8C4C4 solid 1px; margin-top:12px; padding:11px; margin-bottom:10px; width:600px;}
   .result_no a{width:90px; height:34px; background-color:#0083cd; display:block; text-align:center; line-height:34px; color:#fff; float:right; margin-top:10px; font-size:12px;}
   .success { background:url('https://css.lianwen.com/images/success.png') no-repeat; margin-top:25px; margin-left:125px; width:111px; height:111px;float:left; display:inline-block;}
  </style>
@stop
@section('content')
      <!--左边导航-->
      <!--右边内容-->
    <div class="main clearfix">
    <div class="lbox fl">
      <div class="con_right">
        <div class="lwjcBox">
          <div class="lwjc">
            <div class="result clearfix">
              <i class="success"></i>
              <div style="width:666px; float:right; text-align:right;">
                <div class="nav"></div>
                <h3>{{$msg}}</h3>
              </div>
              <div style="width:666px; float:right; text-align:left;"><font color="#0000FF">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;系统已经收到您的付款，论文正在检测中，预计需要10分钟左右。</font>您记下报告查询网址后可以关闭本页面，如长时间未收到检测报告请联系客服微信：cx5078处理。
                <br/>报告查询网址：<a class="blue" href="https://weipu.lianwen.com" target="_blank">https://weipu.lianwen.com</a>
              </div>
            </div>

            <div class="cbox submit yh">
              <div class="down clearfix">
                <table class="mylist">
                  <tr>
                    <td><span class="hl bred">检测编号（请牢记）</span></td>
                    <td><span class="hl bgreen">{{$order->orderid}}</span></td>
                  </tr>
                  <tr>
                    <td>检测</td>
                    <td>{{$order->category->name}}</td>
                  </tr>
                  <tr>
                    <td>标题</td>
                    <td>《{{$order->title}}》</td>
                  </tr>
                  <tr>
                    <td>字数</td>
                    <td>{{$order->words}}</td>
                  </tr>
                  <tr>
                    <td>价格</td>
                    <td style="color:#FF5300; font-weight:bold;">{{ $order->pay_price }} 元</td>
                  </tr>
                  <tr>
                    <td>状态</td>
                    <td><span class="hl bgreen">{{ \App\Models\Enum\OrderEnum::getStatusName($order->status) }}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>时间</td>
                    <td>{{ $order->created_at }}</td>
                  </tr>
                </table>


                <div class="clearfix"></div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    <div class="rbox fr">
      <!-- <div class="tit">在线客服</div>
      <div class="box">客服微信:cx5078</div> -->
      <div class="box">
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

@stop
