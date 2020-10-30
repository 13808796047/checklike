@extends('layouts.app')
@section('title', '订单')
@section('styles')
  <link href="{{asset('asset/css/check.css')}}" rel="stylesheet"/>
  <link href="{{asset('asset/css/theme.css')}}" rel="stylesheet"/>
  <style>
  </style>
@stop
@section('content')
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
<div class="main clearfix" style="flex:1;background: rgb(235,237,243)">
<div class="lbox fl">
      <div>
			<div class="cbox submit yh" >
				<div class="down clearfix">
						<table class="mylist" style="line-height: 30px">
            <tr>
								<td width="149">
									<span>订单号</span>
								</td>
								<td style="text-align: left;">
									<span>{{$recharge->no}}</span>
								</td>
							</tr>
							<tr>
								<td width="149">
									<span>购买次数</span>
								</td>
								<td style="text-align: left;">
									<span>{{$recharge->amount}}</span>
								</td>
							</tr>
							<tr>
								<td width="">价格</td>
								<td style="text-align: left;">
									￥{{ $recharge->total_amount}}
								</td>
							</tr>
							<tr bgcolor="#D0EAFF">
								<td colspan="2" align="center">
									<b>
										<font color="#BF2020">支付检测费用（请选择以下任意一种方式支付）</font>
									</b>
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
						<a type="button" id="bottonsubmit" style="height:33px; margin-left:20px; margin-left:320px;" href="javascript:;" target="_blank"
						 class="btn btn-primary btn-sm sbtn">提交</a>
						<a type="button" id="btn-wechat" style="height:33px; margin-left:20px; margin-left:320px;display: none" href="javascript:;"
						 class="btn btn-primary btn-sm sbtn">提交</a>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
    </div>
<div class="rbox fr">
		<div style="background:#fff;padding:20px;font-size:14px;min-height:1000px;">
		    <b>1、检测结果是否准确？</b>
        <p>如果你们学校也是用万方检测，那结果是一致的。同一个的系统、同样的比对库、同样的算法，所以只要在本系统提交的内容和学校的一致，那检测结果是一致的。</p>
        <b>2、检测需要多少时间？</b>
        <p>正常情况，万方检测需要10分钟左右，高峰期可能会延迟，但不会超过1个小时，如果长时间未出结果请联系客服微信：cx5078解决。</p>
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
      $('#navigation').removeClass('navbar').addClass('affix')
      $("input[name='paytype']").change(() => {
        $('#bottonsubmit').toggle();
        $('#btn-wechat').toggle();
      })
      $('#lwfoot').removeClass('footers')
      //微信支付
      $('#btn-wechat').click(function () {
        let order = {!!$recharge!!}
        console.log(order,213)
        swal({
          title: "打开微信使用扫一扫完成付款",
          // content 参数可以是一个 DOM 元素，这里我们用 jQuery 动态生成一个 img 标签，并通过 [0] 的方式获取到 DOM 元素
          content: $(`<img src="/payments/${order.id}/wechat/recharge" style="display: block;margin: 0 auto;"/>`)[0],
          // buttons 参数可以设置按钮显示的文案
          buttons: ['关闭', '已完成付款'],
        })
          .then(function (result) {
            //如果用户点击了 已完成付款 按钮，则重新加载页面
            if (result) {
              location.href=`https://p.checklike.com/ai_rewrite`
            //location.href=`/payments/${order.id}/wechat/return/order`
            }
          })
        ;
      });
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
