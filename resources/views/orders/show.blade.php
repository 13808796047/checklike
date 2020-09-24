@extends('domained::layouts.app')
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
			<div class="cbox submit yh">
				<div class="down clearfix">

						<table class="mylist" style="line-height: 30px">
							<tr>
								<td width="149">
									<span>检测编号</span>
								</td>
								<td style="text-align: left;">
									<span>{{ $order->orderid }}</span>
								</td>
							</tr>
							<tr>
								<td width="">论文标题</td>
								<td style="text-align: left;">
									{{$order->title}}
								</td>
							</tr>
              <tr>
								<td width="">作者</td>
								<td style="text-align: left;">
									{{$order->writer}}
								</td>
							</tr>
							<tr>
								<td width="">检测系统</td>
								<td style="text-align: left;">{{$order->category->name}}</td>
							</tr>
							<tr>
								<td>检测价格</td>
								<td style="text-align: left;">
									<span style="color:#FF5300; font-weight:bold;">￥{{$order->price}} 元</span>
									(总共{{$order->words}}字)
								</td>
							</tr>
							<tr bgcolor="#D0EAFF">
								<td colspan="2" align="center">
									<b>
										<font color="#BF2020">支付检测费用（请选择以下任意一种方式支付）</font>
									</b>
								</td>
							</tr>
							<tr style="display: none">
								<td class="td">②、淘宝订单号支付</td>
								<td class="td">
									<input type="checkbox" name="usetaobao" id="usetaobao" checked="checked" />
									<input type="text" style="width:300px;" class="txt" name="taobao" size="40" placeholder="使用在线支付请留空，多个订单号用,分隔"
									 value="" />
									<div class="tips">
										通过淘宝担保交易，检测完成后可在淘宝网评价，适合经常淘宝购物的同学使用。<span class="hl bgreen">不要等卖家发货</span>，记下淘宝订单号返回这里将单号填到上面的框框↑，再点击提交，如订单金额不足，需使用支付宝或微信支付差额。
									</div>
								</td>
							</tr>
							<tr style="display: none">
								<td class="td">③、代金券/秘钥支付</td>
								<td class="td">
									<input type="checkbox" name="usecoupon" id="usecoupon" checked="checked" />
									<!--<input type="hidden" name="coupon" class="txt"
                                                 placeholder="请输入8位秘钥/代金券密码，没有请留空" value="" style="width:300px;">-->
									<select name="coupon"> </select>
									<script>
										//let a = document.getElementById('djq');
                        //a.addEventListener('change', function () {

                        //});
                      </script>
									<div class="tips">
										持有手机版购买检测秘钥、或者赠送的代金券，输入后↑即可抵扣相应的检测金额，如秘钥/代金券不足以支付需使用支付宝或微信↓支付差额。
									</div>
								</td>
							</tr>
							<tr style="display: none">
								<td class="td">④、折扣券</td>
								<td class="td">
									<input type="checkbox" name="usedaze" id="usedaze" checked="checked" />
									<input type="text" name="daze" class="txt" placeholder="请输入8位折扣券密码，没有请留空" value="" style="width:300px;" />
									<a href="./zt/dazhe.html" target="_blank" style="color:#0000FF">点击获取折扣券</a>
									<div class="tips">
										<font color="#ff0000">折扣券需配合“⑤在线支付”方可享受折扣</font>，使用后享受全平台检测费九折优惠(知网检测九五折)。
									</div>
								</td>
							</tr>
							<tr>
								<td class="td">
									在线支付<font color="#FF0004">(推荐)</font>
								</td>
								<td class="td">
									<div style="display:flex;align-items: center">
										<input type="radio" name="paytype" value="alipay" checked="checked" />
										<img src="{{asset('asset/images/alipay.png')}}" style="margin-left:17px;" />
									</div>
									&nbsp;&nbsp;
									<!--<label><input type="radio" name="paytype" value="tenpay" > <img src="./asset/imgs/tenpay.png" /></label> -->
									<div style="display:flex;align-items: center">
										<input type="radio" name="paytype" value="wxpay" />
										<img src="{{asset('asset/images/wxpay.png')}}" style="width:99px;margin-left:17px;" />
									</div>
									<div class="tips">
										直接使用支付宝或者微信支付，即时返回支付结果，方便快捷，推荐使用。
									</div>
								</td>
							</tr>
						</table>
						<a type="button" id="bottonsubmit" style="height:33px; margin-left:20px; margin-left:320px;" href="javascript:;"
						 class="btn btn-primary btn-sm sbtn">提交</a>
						<a type="button" id="btn-wechat" style="height:33px; margin-left:20px; margin-left:320px;display: none" href="javascript:;"
						 class="btn btn-primary btn-sm sbtn">提交</a>
					<div class="clearfix"></div>
				</div>
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
      $('.navbar>div').removeClass('container').addClass('container-fluid')
      $('#headerlw').addClass('curfont')
      $('#lwfooter').removeClass('absolute');
      $("input[name='paytype']").change(() => {
        $('#bottonsubmit').toggle();
        $('#btn-wechat').toggle();
      })
      // 微信支付按钮事件
      $('#btn-wechat').click(function () {
        let order = {!!$order!!}
        swal({
          title: "打开微信使用扫一扫完成付款",
          content: $(`<img src="/payments/${order.id}/wechat/order" style="display: block;margin: 0 auto;"/>`)[0],
          // buttons 参数可以设置按钮显示的文案
          buttons: ['关闭', '已完成付款'],
        })
          .then(function (result) {
            if (result) {
             location.href=`/payments/${order.id}/wechat/return/order`
            }
          })
      });
      //支付宝
      $('#bottonsubmit').click(function(){
       let order = {!!$order!!};
       console.log(order.id,31231)
      location.href=`/payments/${order.id}/alipay/order`
     })
    });
  </script>
@stop
