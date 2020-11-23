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
      justify-content: space-around;
    }
    .newul li a{
      color:#fff;
    }
    .ambtn{
      border-radius: 16px;
      border: 1px solid #fff;
      padding: 5px 13px;
    }
    a:hover{
      text-decoration:none ;
    }
  </style>
@stop
@section('content')

<div id="header1">
     <nav id="navigation" class="navbar scrollspy affix" style="position: static;">
				<div class="container">
					<div class="navbar-brand" style="width:25%;">
						<a href="javascript:void(0)" onclick="window.location.href='/'"><img src= "{{ asset('asset/images/checklike.png') }}" alt=""></a>
					</div>
					<ul class="newul" style="flex:1;width:75%;">
						<li><a href="javascript:void(0)" onclick="window.location.href='/'" class="smooth-scroll">网站首页</a></li>
                        <li><a href="/categories/1" class="smooth-scroll">论文查重</a></li>
                                    <li><a href="/categories/4" class="smooth-scroll">免费查重</a></li>
                                    <li><a href="/ai_rewrite" class="smooth-scroll">自动降重</a></li>
                                    <li><a href="/orders" class="smooth-scroll">报告下载</a></li>
                                    <li class="ambtn"><a href="/users/{{Auth::user()->id}}">个人中心</a></li>
            <li class="ambtn"><a class="logout" href="javascript:;">退出</a></li>
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
        <p>用户名：{{Auth::user()->nick_name? Auth::user()->nick_name : Auth::user()->phone }}
        @if(Auth::user()->phone)
        <span class="userword" id="userxiugaipsd">修改密码</span>
        @elseif(!Auth::user()->phone && Auth::user()->nick_name)
        <span class="userword" id="userbindPhone">绑定手机号</span>
        @endif
        </p>
        <p>手机号：{{Auth::user()->phone}}</p>
        <p>自动降重次数: {{Auth::user()->jc_times}}次<span class="userword">充值</span></p>
        <div>
          <span>会员:{{Auth::user()->user_group ==3 ? "会员" : "您还不是会员" }}</span>
          @if(Auth::user()->user_group !=3)
            <span class="userword">开通会员</span>
          @else
            <span>会员还剩余{{Auth::user()->vip_days}}天</span>
          @endif
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
                  window.location.reload();
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
      var currentCode="";
      // 绑定手机号
      $("#bindnow").click(()=>{
        axios.put("https://p.checklike.com/bond_phone",{
        verification_key:currentCode,
        verification_code:$("#bindCodeNow").val()
      }).then(res=>{
        swal("绑定成功", {
          icon: "success",
        }).then(willDelete => {
          $("#bindTitle").modal("hide")
          // location.replace('https://p.checklike.com')
          window.location.reload()
      });
      }).catch(err=>{
        toastr.error(err.response.data.message);
      })
      })
      $("#bindno").click(()=>{
        $("#bindTitle").modal("hide")
      })
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
        axios.post('https://p.checklike.com/password/reset', {
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
