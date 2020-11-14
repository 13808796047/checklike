@extends('layouts.app')
@section('title', '查看订单')
@section('styles')
  <link href="{{asset('asset/css/check.css')}}" rel="stylesheet"/>
  <link href="{{asset('asset/css/theme.css')}}" rel="stylesheet"/>
  <link href="{{asset('asset/css/font-awesome.min.css')}}" rel="stylesheet"/>
  <link href="{{asset('asset/css/alertify.css')}}" rel="stylesheet"/>
  <style>
    img[src=""],img:not([src]){opacity:0;}
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
    .currentBoder{
        border: 2px solid #E43A3D;
        position: relative;
		    box-shadow:0px 2px 7px 0px rgba(85,110,97,0.35);
      }
      .currentBoder:before {
	    	content: '';
		    position: absolute;
		    right: 0;
		    bottom: 0;
		    border: 17px solid #E43A3D;
		    border-top-color: transparent;
		    border-left-color: transparent;
	    }
	    .currentBoder:after {
		    content: '';
		    width: 5px;
		    height: 12px;
		    position: absolute;
		    right: 6px;
		    bottom: 6px;
		    border: 2px solid #fff;
		    border-top-color: transparent;
		    border-left-color: transparent;
		    transform: rotate(45deg);
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
          <td>{{$order->created_at}}</td>
        </tr>
        </table>
        <div>
						<p style="font-weight: bold;font-size: 17px;margin-top:19px;">使用优惠卡券</p>
						<div style="width:100%;border-bottom:1px solid;margin:10px 0;"></div>
						<div style="display:flex;flex-wrap: wrap;height:255px;overflow: auto;" id="couponbox">

            <!-- <div style="margin:10px 20px;">
							<div class="currentBoder" style="width:210px;height:110px;">
								<div class="discount_topbox" style="padding: 8px;" i>
									<p style="color:#fff;"><span style="font-size: 19px;">
										8.0<span style="font-size:15px;margin-left:5px;">折</span>
									</span> 满10可用</p>
									<p style="color:#F5FFFA;font-size:9px;">有效期至2020-11-10 16:33:00</p>
								</div>
								<p style="padding:1px 8px;font-size:9px;">适用系统：维普大学生版</p>
              </div>
              <div style="display:flex;align-items:center;"><img src="{{asset('asset/images/gantanhao.png')}}" style="width:15px;height:15px;"><p style="color:#D1D1D1;font-size:11px;margin-left:5px;">已减去8元</p></div>
            </div> -->

            </div>
            <div style="width:100%;border-bottom:1px solid;margin:15px 0 10px 0;"></div>
            <div style="margin-bottom: 23px;">
              <p>订单原价:25.00元，卡券优惠:-9.09元，应付金额：<span style="font-size: 19px;color: #FF5300;">15.10元</span>，请选择以下任一一种方式完成支付。</p>
            </div>
        </div>
        <div style="display: flex;justify-content: center;">
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
        <a type="button" id="bottonsubmit" style="height:33px;margin:13px auto" href="javascript:;"
						 class="btn btn-primary btn-sm sbtn">提交</a>
				<a type="button" id="btn-wechat" style="height:33px;margin:13px auto;display:none;" href="javascript:;"
						class="btn btn-primary btn-sm sbtn">提交</a>
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
       var couponArr=[];
       var arrStr = "";
       var couponItem = {};
      //  axios.get("/coupon_codes").then(res=>{
      //    console.log(res)
      //    couponArr=res.data.data;
      //    changeCoupon(couponArr)
      //  }).catch(err=>{
      //    console.log(err,"错误")
      //  })

       let currentId = {!!$order->id!!}
       axios.get(`/orders/${currentId}/coupon_codes`).then(res=>{
        console.log(res,"fsafs")
        couponArr=res.data.data;
         changeCoupon(couponArr)
       }).catch(err=>{})


       function changeCoupon(item){
        let currentCid = {!!$order->cid!!} //当前订单CID
        let currentPrice =  {{$order->price}} //当前订单价格
         //过滤掉已过期的
        let currentArr = item.filter(curitem=>{
           return !curitem.is_enable
         })
        currentArr.sort((a,b)=>{
          // let val1=(!a.cid&&currentPrice>=a.min_amount)||(a.cid==currentCid&&currentPrice>=a.min_amount);
          // let val2=(!b.cid&&currentPrice>=b.min_amount)||(b.cid==currentCid&&currentPrice>=b.min_amount);
          return (b.reason=="") - (a.reason=="")
        })
         //遍历所有未过期的项目
         currentArr.forEach(e=>{
          let judgeTerm = (!e.cid&&currentPrice>=e.min_amount)||(e.cid==currentCid&&currentPrice>=e.min_amount)
           arrStr +=`
              <div style="margin:10px 20px;" class="cardToast">
							<div style="width:210px;height:110px;" class="${judgeTerm ? 'discount_box' : 'discount_boxborder'}">
								<div style="padding: 8px;" class="${judgeTerm ? 'discount_topbox' : 'discount_curbg'}">
									<p style="color:#fff;"><span style="font-size: 19px;">
										8.0<span style="font-size:15px;margin-left:5px;">折</span>
									</span> 满${e.min_amount}可用</p>
									<p style="color:#F5FFFA;font-size:9px;">有效期至${e.enable_date}</p>
								</div>
								<p style="padding:1px 8px;font-size:9px;">适用系统：${e.cid ? e.category.name : '不限' }</p>
              </div>
              <div style="display:flex;align-items:center;" class="infofooter"><img src="${e.reason!=""?'/asset/images/gantanhao.png':''}" style="width:15px;height:15px;"><p style="color:#D1D1D1;font-size:11px;margin-left:5px;">${e.reason}</p></div>
            </div>
            `
        })
        $("#couponbox").html(arrStr)
        doStyle()
       }
       //tab切换
       function doStyle(){
          let CardBox = $(".cardToast").children(".discount_box")
          CardBox.click(function(){
            $(this).addClass('currentBoder')
            console.log($(this).parent().siblings().children(".discount_box"))
            $(this).parent().siblings().children(".discount_box").removeClass("currentBoder")
          })
       }


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
