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
      border-bottom: 1px solid;
      margin: 10px 18px;
    }

    .userword {
      margin-left: 20px;
      color: #1E90FF;
      cursor: pointer;
    }
  </style>
@stop
@section('content')


  <div class="main clearfix" style="flex:1">

    <div class="card topic-reply mt-4" style="margin:30px 60px;width:100%;">
      <div class="usertitle">基本信息</div>
      <div style="margin:0 18px;">
        <p>用户名：{{Auth::user()->phone}}<span class="userword">修改密码</span></p>
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

        <p></p>
      </div>
      <div class="usertitle" style="display:flex;justify-content: space-between;">卡券管理<p
          style="color: #1E90FF;cursor: pointer;margin-right:10px;" id="activationBtn">卡券激活</p></div>
      <div></div>
      <div class="card-body">
        @include('users._coupon_codes', ['coupon_codes' => $user->couponCodes()->whereIn('type',[\App\Models\CouponCode::TYPE_PERCENT,\App\Models\CouponCode::TYPE_FIXED])->where('status',\App\Models\CouponCode::STATUS_ACTIVED)->with('category')->paginate(5)])
      </div>
    </div>
  </div>


  <!--/.fluid-container-->

@endsection
@section('scripts')
  <script>
    $(document).ready(function () {
      $('.navbar').css('position', 'static')
      $('#navigation').addClass('affix')
      $('#app').removeClass('newmain')
      $("#lwfooter").css("position", "absolute")
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
                  toastr.success(res.data.msg);
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
    });
  </script>
@stop
