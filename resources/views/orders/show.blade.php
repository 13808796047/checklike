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
    }
    .order_msg div p:nth-child(2){
      font-size: 14px;
      margin-left:33px;
    }
  </style>
@stop
@section('content')


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
  <p style="font-weight: bold;font-size: 17px;">订单信息</p>
  <div style="width:100%;border-bottom:1px dotted #333;margin:10px 0;"></div>


      <div class="order_msg">
        <div>
          <p>订单编号：</p>
          <p>{{$order->orderid}}</p>
        </div>
        <div>
          <p>论文题目：</p>
          <p>{{$order->title}}</p>
        </div>
        <div>
          <p>论文作者：</p>
          <p>{{$order->writer}}</p>
        </div>
        <div>
          <p>检测系统：</p>
          <p>{{$order->category->name}}</p>
        </div>
        <div>
          <p>订单价格：</p>
          <p><span style="color:#FF5300;font-weight:bold;">{{$order->price}}元</span>({{$order->words}}字)</p>
        </div>
        <div>
          <p>上传时间：</p>
          <p>{{$order->created_at}}</p>
        </div>


      </div>




        <div id="isfeizero">
        <div>
						<p style="font-weight: bold;font-size: 17px;margin-top:19px;">使用优惠卡券</p>
            <div style="width:100%;border-bottom:1px dotted #333;margin:10px 0;"></div>
						<div style="display:flex;flex-wrap: wrap;height:255px;overflow: auto;" id="couponbox">

            </div>
            <div style="width:100%;border-bottom:1px dotted #333;margin:10px 0;"></div>
            <div style="margin-bottom: 23px;">
              <p id="dingdanprice" style="display:none;">订单原价:{{$order->price}}元，卡券优惠:<span id="yhje"></span>元，应付金额：<span style="font-size: 19px;color: #FF5300;" id="sjprice">元</span>，请选择以下任一一种方式完成支付。</p>
            </div>
        </div>
        <div id="isshowicon">
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
        <a type="button" id="bottonsubmit" style="height:33px;margin:13px auto" href="javascript:;"
						 class="btn btn-primary btn-sm sbtn">提交</a>
				<a type="button" id="btn-wechat" style="height:33px;margin:13px auto;display:none;" href="javascript:;"
						class="btn btn-primary btn-sm sbtn">提交</a>
	     </div>
      </div>
      <div id="iszero" style="display:none;">
          <p style="color:#fff;background: red;width: 10%;margin: 0 auto;text-align:center;" id="freefee">提交</p>
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
        <p>正常情况，检测需要<span id="banbentimer">10分钟</span>左右，高峰期可能会延迟。如果长时间未出结果请联系客服解决。</p>
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
      let current_cid ={{$order->cid}}
      if(current_cid==1||current_cid==2){
        $("#banbentimer").text("10分钟")
        $("#rightcontainer").text("CheckLike是通用检测系统，能够检测出大部分相似文献内容，适合初稿。定稿建议使用与学校或评审机构一致的系统检测一遍，这样比较准确。")
      }
      if( current_cid==3 || current_cid==4 || current_cid==5 || current_cid == 6){
        $("#banbentimer").text("10分钟")
        $("#rightcontainer").text("如果你们学校也是用维普检测，那结果是一致的。我们是同一套系统，只要提交的内容一致那检测结果也相同。")
      }
      if(current_cid==12||current_cid==13||current_cid==14||current_cid==15){
        $("#banbentimer").text("10分钟")
        $("#rightcontainer").text("如果你们学校也是用万方检测，那结果是一致的。我们是同一套系统，只要提交的内容一致那检测结果也相同。")
      }
      if(current_cid==7||current_cid==8||current_cid==8||current_cid==10||current_cid==11){
        $("#banbentimer").text("2小时")
        $("#rightcontainer").text("我们使用的是跟知网同一套系统，但是每个版本有轻微差别，具体参考系统介绍。")
      }
      if(current_cid==16){
        $("#banbentimer").text("10分钟")
        $("#rightcontainer").text("PaperPass是通用检测系统，能够检测出大部分相似文献内容，适合初稿。定稿建议使用与学校或评审机构一致的系统检测一遍，这样比较准确。")
      }
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
       let curPrice = {{$order->price}};
       if(curPrice==0){
         $("#iszero").css("display","block")
         $("#isfeizero").css("display","none")
       }else{
        $("#iszero").css("display","none")
         $("#isfeizero").css("display","block")
       }


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
										${e.type=="fixed"? `￥${e.value}`:`${e.description}`}
									</span> 满${e.min_amount}可用</p>
									<p style="color:#F5FFFA;font-size:9px;">有效期至${e.enable_date}</p>
								</div>
								<p style="padding:1px 8px;font-size:9px;">适用系统：${e.cid ? e.category.name : '不限' }</p>
                <div style="display:none;" class="codedisplay">${e.code}</div>
              </div>
              <div style="display:flex;align-items:center;" class="infofooter"><img src="${e.reason!=""?'/asset/images/gantanhao.png':''}" style="width:15px;height:15px;"><p style="color:#D1D1D1;font-size:11px;margin-left:5px;">${e.reason}</p></div>
            </div>
            `
        })
        if(arrStr==""){
          arrStr = `<div style="margin-top:13%;width:100%;color:#666;font-size:19px;text-align:center;">暂无可用优惠券</div>`
        }
        $("#couponbox").html(arrStr)
        doStyle()
       }
       //tab切换
       function doStyle(){
          let CardBox = $(".cardToast").children(".discount_box")
          CardBox.click(function(){
            $(this).addClass('currentBoder')
            $(this).parent().siblings().children(".discount_box").removeClass("currentBoder")
            countPrice($(this))

          })
       }
       var clickCode =""
       //计算价格
       function countPrice(e){
          //当前CODE
          clickCode = e.find('.codedisplay').text()
          //当前价格
          axios.get(`/orders/${currentId}/coupon-price`,{params:{code:clickCode}}).then(res=>{
            let currentPrice =  {{$order->price}} //当前订单价格
            $("#sjprice").text(res.data+"元")
            $("#yhje").text((currentPrice-res.data).toFixed(2))
            $("#dingdanprice").css("display","block")

            if($("#sjprice").text()=="0元"){
              $("#isshowicon").css("display","none")
              $("#iszero").css("display","block")
            }else{
              $("#isshowicon").css("display","block")
              $("#iszero").css("display","none")
            }
          }).catch(err=>{
            console.log(err,"err")
          })
       }




       $("#freefee").click(()=>{
          axios.get(`/payments/${currentId}/free_pay?code=${clickCode}`).then(res=>{
              location.href = "/orders"
          })
       })

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
        //判断是否选择优惠
        let isCode = $(".cardToast").children().hasClass("currentBoder")
        if(!isCode){
          clickCode = ""
        }
        $("#codeTcDialog").modal("show")
        $('#codeurl').attr("src", `/payments/${order.id}/wechat/order?code=${clickCode}`);
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
        //判断是否选择优惠
        let isCode = $(".cardToast").children().hasClass("currentBoder")
        if(!isCode){
          clickCode = ""
        }
        location.href=`/payments/${order.id}/alipay/order?code=${clickCode}`
      })
    });
  </script>
@stop
