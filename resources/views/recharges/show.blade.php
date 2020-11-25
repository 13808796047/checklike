@extends('layouts.app')
@section('title', '订单')
@section('styles')
  <link href="{{asset('asset/css/check.css')}}" rel="stylesheet"/>
  <link href="{{asset('asset/css/theme.css')}}" rel="stylesheet"/>
  <style>
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
    .order_msg{
      padding:0 30px;
    }
    .order_msg div{
      display:flex;
      border-bottom: 1px dashed #ececec;
      line-height: 2.9;
      padding-left: 145px;
    }
    .order_msg div p:nth-child(1){
      font-size: 15px;
      font-weight: 600;
      width: 110px;
      text-align: end;
    }
    .order_msg div p:nth-child(2){
      font-size: 14px;
      margin-left:33px;
    }
  </style>
@stop
@section('content')

<div class="modal fade" id="wxcodeTcDialog" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="wxcodeTcDialogLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" style="width:333px;">
    <div class="modal-content">
      <div class="modal-body">
         <div style="padding:10px 17px;">
            <p style="text-align:center;font-size:16px;color:#808080;">打开微信使用扫一扫完成付款</p>
            <div>
              <img src="" alt="" srcset="" id="wxcodeurl" style="width:210px;height:210px;display:block;margin:0 auto;">
            </div>
            <div style="display:flex;justify-content: center;margin-top:5px;">
              <button type="button" class="btn btn-secondary" id="closewxCodeDialog">关闭</button>
              <div style="margin:0 10px;"></div>
              <button type="button" class="btn btn-primary" id="completewxCodeDialog">已完成付款</button>
            </div>
         </div>
      </div>
    </div>
  </div>
</div>

<!-- 购买降重字数模态框 -->
<div class="modal fade bd-example-modal-sm" id="wxModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="text-align:center;">
          <p>购买自动降重次数</p>
          <p style="margin: 6px 0;font-size: 11px;color: #F4A460;">(价格:1元/次)</p>
          <p>请输入购买次数<span style="padding:0 10px;" id="cutjctime">-</span><span style="border: 1px solid;padding: 3px;" id="curjctime">1</span><span style="padding:0 10px;" id="addjctime">+</span></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
          <button type="button" class="btn btn-primary" id="sureshop">确定</button>
        </div>
      </div>
    </div>
</div>
  <!-- 购买降重字数模态框结束 -->
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
<div class="container" style="margin:18px auto;">
<div class="grid grid-cols-12 gap-4">
<div class="col-span-9 p-4" style="box-shadow: 0 0 6px rgba(0, 0, 0, 0.3);background: #fff;">
      <div>
      <p style="font-weight: bold;font-size: 17px;">订单信息</p>
      <div style="width:100%;border-bottom:1px dotted #333;margin:10px 0;"></div>


      <div class="order_msg">
        <div>
          <p>订单号：</p>
          <p>{{$recharge->no}}</p>
        </div>
        <div>
          <p>订单类型：</p>
          <p>自动降重次数充值</p>
        </div>
        <div>
          <p>购买次数：</p>
          <p>{{$recharge->amount}}</p>
        </div>
        <div>
          <p>价格：</p>
          <p>￥{{ $recharge->total_amount}}</p>
        </div>

      </div>
      <p style="font-weight: bold;font-size: 17px;margin-top:21px;">支付方式</p>
      <div style="width:100%;border-bottom:1px dotted #333;margin:10px 0;"></div>
      <div style="display: flex;justify-content: center;" >
            <div style="display: flex;align-items: center;margin-right: 30px;">
              <input type="radio" name="paytype" value="alipay" checked="checked">
              <img src="{{asset('asset/images/alipay.png')}}" style="margin-left:17px;">
            </div>
            <div style="display: flex;align-items: center;">
            <input type="radio" name="paytype" value="wxpay" />
              <img src="{{asset('asset/images/wxpay.png')}}" style="margin-left:17px;
              height: auto;width:100px;">
            </div>
      </div>
        <a type="button" id="bottonsubmit" style="height:33px; margin-left:20px; margin-left:320px;" href="javascript:;" target="_blank"
						 class="btn btn-primary btn-sm sbtn">提交</a>
				<a type="button" id="btn-wechat" style="height:33px; margin-left:20px; margin-left:320px;display: none" href="javascript:;"
						class="btn btn-primary btn-sm sbtn">提交</a>
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
        <b>1、论文上传之后安全吗？</b>
        <p>本系统有明确的条文规定并遵守严格的论文保密规定，对所有用户提交的送检文档仅做检测分析，绝不保留全文，承诺对用户送检的文档不做任何形式的收录和泄露。</p>
        <b>2、提交以后能不能退款？</b>
        <p>系统一旦提交，开始检测后，即产生消费，无法退款，请谅解！</p>
        <b>3、检测内容范围？</b>
        <p>系统主要检测论文正文，封面、目录、致谢以及个人信息可以删除后再上传。</p>
      </div>
    </div>
  </div>
</div>

<!--/.fluid-container-->

@endsection
@section('scripts')
  <script>
    $(document).ready(function () {
      $("input[name='paytype']").change(() => {
        $('#bottonsubmit').toggle();
        $('#btn-wechat').toggle();
      })
      $('#lwfoot').removeClass('footers')
      $("#app").removeClass("newmain")
      //微信支付
      $('#btn-wechat').click(function () {
        let order = {!!$recharge!!}
        console.log(order,213)
        // swal({
        //   title: "打开微信使用扫一扫完成付款",
        //   // content 参数可以是一个 DOM 元素，这里我们用 jQuery 动态生成一个 img 标签，并通过 [0] 的方式获取到 DOM 元素
        //   content: $(`<img src="/payments/${order.id}/wechat/recharge" style="display: block;margin: 0 auto;"/>`)[0],
        //   // buttons 参数可以设置按钮显示的文案
        //   buttons: ['关闭', '已完成付款'],
        // })
        //   .then(function (result) {
        //     //如果用户点击了 已完成付款 按钮，则重新加载页面
        //     if (result) {
        //       location.href=`https://p.checklike.com/ai_rewrite`
        //     //location.href=`/payments/${order.id}/wechat/return/order`
        //     }
        //   })
        // ;
        $("#wxcodeTcDialog").modal("show")
        $('#wxcodeurl').attr("src", `/payments/${order.id}/wechat/recharge`);
      });
      $("#closewxCodeDialog").click(()=>{
        $("#wxcodeTcDialog").modal("hide")
      })
      $("#completewxCodeDialog").click(()=>{
        let order = {!!$order!!}
        location.href=`/payments/${order.id}/wechat/return/order`
      })
     //支付宝支付
     $('#bottonsubmit').click(function(){
       let id = {!!$recharge!!};
       console.log(id)
       // /payments/7/alipay/recharge
       location.href=`/payments/${id.id}/alipay/recharge`
     })
    })
  </script>
@stop
