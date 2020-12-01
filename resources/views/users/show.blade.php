@extends('layouts.app')
@section('title', '个人中心')
@section('styles')
  <link href="{{asset('asset/css/check.css')}}" rel="stylesheet"/>
  <link href="{{asset('asset/css/theme.css')}}" rel="stylesheet"/>
  <style>
    .curfont {
      font-size: 16px;
    }

    .usertitle {
      font-size: 17px;
      font-weight: bold;
      border-bottom: 1px solid #dee2e6;
      margin: 10px 18px;
    }

    .userword {
      margin-left: 20px;
      color: #1E90FF;
      cursor: pointer;
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
      font-size:1rem;
    }
    .ambtn{
      border-radius: 16px;
      border: 1px solid #fff;
      padding: 5px 17px;
    }
    a:hover{
      text-decoration:none ;
    }
    .user_info_message div{
      display:flex;
    }
    .user_info_message div p:nth-child(1){
				width:100px;
				text-align: right;
			}
  </style>
@stop
@section('content')
<!-- 降重模态 -->
<div class="modal fade bd-example-modal-sm" id="jctimeModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true" style="user-select: none;">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">提示</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="text-align:center;">
          <p>购买自动降重次数</p>
          <p style="margin: 6px 0;font-size: 11px;color: #F4A460;">(价格:1元/次)</p>
          <p>请输入购买次数<span style="padding:0 10px;cursor:pointer" id="cutjctime">-</span><span style="border: 1px solid;padding: 3px;" id="curjctime">10</span><span style="padding:0 10px;cursor:pointer" id="addjctime">+</span></p>
        </div>
        <div class="modal-footer">
          <p style="color:#4876FF;margin-right:25%;display:none;" id="freeadd">免费增加</p>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
          <button type="button" class="btn btn-primary" id="sureshop">确定</button>
        </div>
      </div>
    </div>
  </div>
  <!-- 降重模态 -->
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
                  <li><a href="/freecheck" class="smooth-scroll">免费查重</a></li>
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
  <div class="main clearfix container" style="flex:1;">

    <div class="card topic-reply mt-4" style="margin:30px auto;width:100%;min-height:calc(100vh * 0.81);">
    <div style="margin:15px 50px;">
      <div class="usertitle">基本信息</div>
      <div style="margin:0 18px;display:flex;align-items:center;margin:20px;">
      <div style="margin-left:17px;">
        <img src="{{Auth::user()->avatar ? Auth::user()->avatar : asset('asset/images/avtarno.jpg')}}" alt="" style="width:130px;height:130px;border-radius: 50%;">
      </div>
      <div style="margin-left:30px;">

      <div class="user_info_message">

			<div>
				<p>用户名 ：</p>
				<p>{{Auth::user()->nick_name? Auth::user()->nick_name : Auth::user()->phone }}
        </p>

			</div>

			<div>
				<p>手机号 ：</p>
        @if(Auth::user()->phone)
				<p>{{Auth::user()->phone}}</p>
        <span class="userword" id="userxiugaipsd">修改密码</span>
        @else
        <span class="userword" id="userbindPhone">绑定手机号</span>
        @endif
			</div>
			<div>
				<p>降重次数 ：</p>
				<p>{{Auth::user()->jc_times}}次</p>
        <span  class="userword" id="jcchongzhi">充值</span>
			</div>
			<div>
				<p>会员等级 ：</p>
				<p>
          @if(Auth::user()->user_group ==3)
            <span style="color:#FF8C00">VIP会员</span>
          @elseif(Auth::user()->user_group ==0)
            普通会员
          @elseif(Auth::user()->user_group ==2)
            高级代理
          @elseif(Auth::user()->user_group ==2)
            普通代理
          @endif
        </p>
          @if(Auth::user()->user_group !=3)
            <span class="userword" id="kaitonghuiyuan">开通会员</span>
          @else
            <span style="margin-left:20px;">(有效期：{{Auth::user()->vip_expir_at}})</span>
          @endif
			</div>
		</div>


      </div>

        <p></p>
      </div>
      <div class="usertitle" style="display:flex;justify-content: space-between;">卡券管理<p
          style="color: #1E90FF;cursor: pointer;margin-right:10px;" id="activationBtn">卡券激活</p></div>
      <div></div>
      <div class="card-body" style="margin:0 17px;">
        @include('users._coupon_codes', ['coupon_codes' => $coupon_codes])
      </div>
      </div>
    </div>

  </div>
  <!--/.fluid-container-->
@endsection
@section('scripts')
  <script>
    $(document).ready(function () {
      $('#app').removeClass('newmain')
      $("#activationBtn").click(() => {
        var timer1 = null;
        clearTimeout(timer1);
        $.confirm({
          title: "提示",
          content: '' +
            '<form action="" class="formName">' +
            '<div class="form-group" style="display:flex">' +
            '<label style="margin-right:10px;">卡券编号</label>' +
            '<input type="text" placeholder="请输入卡券编号" class="name form-control" required style="width:80%"/>' +
            '</div>' +
            '</form>',
          buttons: {
            formSubmit: {
              text: '确认',
              btnClass: 'btn-blue',
              action: function () {
                var name = this.$content.find('.name').val();
                if (!name) {
                  $.alert('密钥不能为空');
                  return false;
                }
                axios.post("/coupon_codes/active-coupon-code", {code: name}).then(res => {
                  toastr.success(res.data.message);
                  timer1 = setTimeout(function(){
                    window.location.reload();
                  }, 2000);

                }).catch(err => {
                  toastr.error(err.response.data.msg);
                })
              }
            },
            cancel: {
              text: '取消',
            },
          },
          // onContentReady: function () {
          //   var jc = this;
          //   this.$content.find('form').on('submit', function (e) {
          //     e.preventDefault();
          //     jc.$formSubmit.trigger('click');
          //   });
          // }
        });
      })
      $("#userbindPhone").click(()=>{
        $("#bindTitle").modal("show")
      })
      $("#kaitonghuiyuan").click(()=>{
        window.open("https://detail.tmall.com/item.htm?spm=a212k0.12153887.0.0.4d7c687dvfKPtV&id=631864348638","_blank");
      })
      $("#jcchongzhi").click(()=>{
        $("#jctimeModal").modal('show')
      })
      //增加降重字数
  $("#addjctime").click(()=>{
    let current = Number($("#curjctime").text())+1;
    $("#curjctime").text(current)
  })
  //减少降重次数
  $("#cutjctime").click(()=>{
    let current = Number($("#curjctime").text());
    if(current==1) return;
    let cur = current -1;
    $("#curjctime").text(cur)
  })
     //确认购买
      $("#sureshop").click(()=>{
        let totalprice=$("#curjctime").text();
        console.log(totalprice,3131)
        axios.post('{{ route('recharges.store') }}',{
          total_amount:totalprice,
          amount:totalprice
        }).then(res => {
          let number = res.data.data.amount;
          let id =res.data.data.id;
          let price=res.data.data.total_amount;
          location.href=`/recharges/${id}`
        }).catch(err => {
          console.log(err,31312)
        })
      })
      var currentCode="";

      //修改密码
      $("#userxiugaipsd").click(()=>{
        $("#xgtoast").text("")
        $("#xgpsd").val("")
        $("#xgsurepsd").val("")
        $("#staticXiugai").modal("show")
      })
      $("#xiugaicancel").click(()=>{
        $("#staticXiugai").modal("hide")
      })
      $("#xiugaisure").click(()=>{

        if($("#xgpsd").val().length<8){
           $("#xgtoast").text("密码不少于8位")
           return;
       }
       if($("#xgpsd").val()!=$("#xgsurepsd").val()){
         $("#xgtoast").text("两次密码不一致")
         return;
       }
        axios.post('/password/reset', {
          password: $("#xgpsd").val(),
          password_confirmation: $("#xgsurepsd").val()
        }).then(res=>{
            toastr.success(res.data.message);
            $("#staticXiugai").modal("hide")
        }).catch(err=>{
            toastr.error(err.response.data.message);
        })
      })
    });
  </script>
@stop
