@extends('layouts.app')
@section('title','查看报告')
@section('styles')
  <link rel="stylesheet" href="{{asset('asset/css/check.css')}}">

  <style>
    .card-body p {
      text-indent: 2em !important;
    }
    .newul{
      display:flex;
      margin-bottom:0 !important;
      align-items:center;

    }
    .newul li{
      margin:0 17px;
    }
    .newul li a{
      color:#fff;
      font-size:15px;
    }
    .ambtn{
      border-radius: 16px;
      border: 1px solid #fff;
      padding: 5px 17px;
    }
    a:hover{
      text-decoration:none ;
    }
  </style>

@stop
@section('content')
<div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="width:300px;">
      <div class="modal-content">
        <div class="modal-body">
        <label for="validationTooltipUsername" class="col-form-label">当前系统无法获取到检测结果，请输入相似比继续，如：18.60</label>
        <div style="display:flex;align-items: center;justify-content: center;">
        <input type="number" class="form-control" id="recipient-name" min="1" max="100" step="0.01" style="width:200px" >
        <span>%</span>
        </div>
        <div style="color:red;display:none" id="isshow">
          请填写正确值(0-100)
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
          <button type="button" class="btn btn-primary" id="sure">确定</button>
        </div>
      </div>
    </div>
  </div>
  <div id="header1">
     <nav id="navigation" class="navbar scrollspy affix" style="position: static;">
				<div class="container">
					<div class="navbar-brand" style="width:25%;margin-right:10px;">
						<a href="javascript:void(0)" onclick="window.location.href='/'"><img src= "{{ asset('asset/images/checklike.png') }}" alt=""></a>
					</div>
					<ul class="newul" style="flex:1;width:72%;">
            <div style="display:flex;justify-content:space-between;width:100%;">
            <div style="display:flex;align-items: center;margin-left:13px;">
						      <li><a href="javascript:void(0)" onclick="window.location.href='/'" class="smooth-scroll">网站首页</a></li>
                  <li><a href="/categories/1" class="smooth-scroll">论文查重</a></li>
                  <li><a href="/categories/4" class="smooth-scroll">免费查重</a></li>
                  <li><a href="/ai_rewrite" class="smooth-scroll">自动降重</a></li>
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
  <div class="container" style="margin:18px auto;">
    <div class="grid grid-cols-12 gap-4">
      <div class="col-span-9 p-4" style="box-shadow: 0 0 6px rgba(0, 0, 0, 0.3);background: #fff;">
        <div>
          <div class="card-body" style="padding:0">
            <div class="card-title">
              <h2 class="text-3xl text-center">{{ $order->title }}</h2>
              <div class="info">
                <!-- <span>作者:</span>
                &emsp;
                <span>{{ $order->writer }}</span>
                &emsp;
                <span>提交时间:</span>
                &emsp;
                <span>{{ $order->created_at }}</span>
                &emsp;
                <span>重复率:</span>
                &emsp;
                <span>{{ $order->rate }}</span>
                &emsp;
                <a href="{{ route('orders.download',['orderid'=>$order->orderid]) }}"
                   class="bg-blue-500 px-2 rounded-sm text-white">下载报告</a>
                <span class="bg-blue-500 px-2 rounded-sm text-white" style="margin-left:13px" id="qrcode">生成二维码</span> -->
                <span style="color:red;">注:检查报告系统仅保存10天，请及时下载保存,如需帮助请联系客服微信(查重问题：LwCheck 降重帮助：cx5078)</span>
              <div style="margin-top:10px;">
              <a href="{{ route('orders.download',['orderid'=>$order->orderid]) }}"
                   class="bg-blue-500 px-2 rounded-sm text-white" style="display: inline-block;width: 203px;padding:5px 0;" >下载完整报告</a>
                <span class="px-2 rounded-sm text-white" style="margin-left:13px;display: inline-block;width: 203px;background:	#32CD32;padding:5px 0;" id="qrcode">生成检测证书</span>
              </div>
              </div>

            </div>
            <!-- Modal -->

          <!-- Modal-end -->
            @if($order->report->content)
             <div style="text-align:center;margin-top:100px;color:red;">抱歉，报告暂不支持预览，请下载完整报告查看</div>
           @else
              <!-- <h2 class="text-center text-5xl">暂无内容!!!!</h2> -->
              <iframe src="https://dev.lianwen.com/pdf/{{$order->orderid}}.pdf" width="100%" height="650"></iframe>
            @endif
          </div>
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
        <p>正常情况，检测需要10分钟左右，高峰期可能会延迟。如果长时间未出结果请联系客服解决。</p>
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
  <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="qrcodebox">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;padding-top: 0;padding-bottom: 0;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <p style='font-size: 16px;font-weight: bold;text-align: center;'>证书生成成功！</p>
      <div id="qrimgs" style="width: 200px;height: 200px;margin: 0 auto;">
      </div>
      <p style="text-align: center;font-size: 13px;margin-bottom: 12px;">使用手机扫一扫，查看检测报告证书</p>
    </div>
  </div>
</div>
@stop
@section('scripts')
  <script !src="">
    $(function () {

      $("#qrcode").click(function(){
          let order = {!!$order!!};
          $('#qrimgs').children().remove();
          //判断是否存在重复率
          if(order.rate==0.00 ||order.rate=='0.0%'){
            $('#exampleModal').modal('show')

            $('#sure').click(function(){
              if($("#recipient-name").val()<0.00 ||$("#recipient-name").val()>100.00 || $("#recipient-name").val()==''){
                $("#isshow").css('display','block')
                return;
              }
            $('#qrcodebox').modal('show')
            $("#qrimgs").append(`<img src='/orders/${order.id}/qrcode/?rate=${$("#recipient-name").val()}' style="display: block;margin: 0 auto;"/>`)

            $('#exampleModal').modal('hide')
            })
          }else{
            $("#qrimgs").append(`<img src='/orders/${order.id}/qrcode' style="display: block;margin: 0 auto;"/>`)
            $('#qrcodebox').modal('show')
          }
      })

      // $('.navbar>div').removeClass('container').addClass('container-fluid')
      $('#headerlw').addClass('curfont')
    })
  </script>
@stop
