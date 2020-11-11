@extends('layouts.app')
@section('title', '查看订单')
@section('styles')
  <link href="{{asset('asset/css/check.css')}}" rel="stylesheet"/>
  <link href="{{asset('asset/css/theme.css')}}" rel="stylesheet"/>
  <link href="{{asset('asset/css/font-awesome.min.css')}}" rel="stylesheet"/>
  <link href="{{asset('asset/css/alertify.css')}}" rel="stylesheet"/>
  <style>
    .curfont{
      font-size:16px;
    }
    table tr td{
				border:1px solid;
				text-align: center;
				padding:5px 0;
		}
    .discount_box{
       border: 1px solid #74D2C3;
    }
    .discount_boxborder{
      border: 1px solid #D1D1D1;
    }
    .discount_topbox{
      background-color: #74D2D4;
    }
    .discount_curbg{
      background-color: #D1D1D1;
    }
  </style>
@stop
@section('content')

{{--  <div class="container my-4 bg-white shadow">--}}
{{--    <div class="py-4">--}}
{{--      <h5 class="mb-4"><span class="text-xl text-primary mr-2"><i class="text-xl iconfont icon-file-done"></i></span>订单信息--}}
{{--      </h5>--}}
{{--    </div>--}}
{{--  </div>--}}
<div class="main clearfix" style="flex:1">
	<div class="lbox fl">
		<div>
    <p style="font-weight: bold;font-size: 17px;">订单信息</p>
    <table style="border:1px solid;border-collapse: collapse;padding: 2px;width: 780px;margin: 5px 0;">
        <tr>
          <td >订单编号</td>
          <td>{{ $order->orderid }}</td>
        </tr>
        <tr>
          <td >论文题目</td>
          <td>{{$order->title}}</td>
        </tr>
        <tr>
          <td>论文作者</td>
          <td>{{$order->writer}}</td>
        </tr>
        <tr>
          <td>检测系统</td>
          <td>{{$order->category->name}}</td>
        </tr>
        <tr>
          <td>订单价格</td>
          <td ><span style="font-size:17px;color: #FF5300;font-weight: bold;">
          {{$order->price}}元
          </span>({{$order->words}}字)</td>
        </tr>
        <tr>
          <td>上传时间</td>
          <td>2012年3月31日</td>
        </tr>
        </table>
        <a type="button" id="bottonsubmit" style="height:33px; margin-left:20px; margin-left:320px;" href="javascript:;"
						 class="btn btn-primary btn-sm sbtn">提交</a>
				<a type="button" id="btn-wechat" style="height:33px; margin-left:20px; margin-left:320px;display: none" href="javascript:;"
						class="btn btn-primary btn-sm sbtn">提交</a>
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
  <div class="modal fade" id="codeTcDialog" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="codeTcDialogLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" style="width:333px;">
    <div class="modal-content">
      <div class="modal-body">
         <div style="padding:10px 17px;">
            <p style="text-align:center;font-size:16px;color:#808080;">打开微信使用扫一扫完成付款</p>
            <div>
              <img src="" alt="" srcset="" id="codeurl" style="width:210px;height:210px;display:block;margin:0 auto;">
            </div>
            <div style="display:flex;justify-content: center;margin-top:5px;">
              <button type="button" class="btn btn-secondary" id="closeCodeDialog">关闭</button>
              <div style="margin:0 10px;"></div>
              <button type="button" class="btn btn-primary" id="completeCodeDialog">已完成付款</button>
            </div>
         </div>
      </div>
    </div>
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
      $("input[name='paytype']").change(() => {
        $('#bottonsubmit').toggle();
        $('#btn-wechat').toggle();
      })
      // 微信支付按钮事件
      $('#btn-wechat').click(function () {
        let order = {!!$order!!}
        console.log(order,"fsajdfjsdf")
        $("#codeTcDialog").modal("show")
        $('#codeurl').attr("src", `/payments/${order.id}/wechat/order`);
        // swal({
        //   title: "打开微信使用扫一扫完成付款",
        //   content: $(`<img src="/payments/${order.id}/wechat/order" style="display: block;margin: 0 auto;"/>`)[0],
        //   // buttons 参数可以设置按钮显示的文案
        //   buttons: ['关闭', '已完成付款'],
        // })
        //   .then(function (result) {
        //     if (result) {
        //      location.href=`/payments/${order.id}/wechat/return/order`
        //     }
        //   })
      });
      $("#closeCodeDialog").click(()=>{
        $("#codeTcDialog").modal("hide")
      })
      $("#completeCodeDialog").click(()=>{
        let order = {!!$order!!}
        location.href=`/payments/${order.id}/wechat/return/order`
      })
      //支付宝
      $('#bottonsubmit').click(function(){
       let order = {!!$order!!};
       console.log(order.id,31231)
      location.href=`/payments/${order.id}/alipay/order`
     })
    });
  </script>
@stop
