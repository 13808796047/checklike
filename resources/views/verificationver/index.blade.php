@extends('layouts.app')
@section('title','报告验真')
@section('styles')
<style>
.vpcs-banner{
  width: 100%;
  height: 331px;
  background: url("/asset/images/bgyz.jpg") no-repeat center;
}
.vpcs-banner-srk {
    position: relative;
    width: 1200px;
    margin: auto;
}
.vpcs-banner-sr-span {
    position: absolute;
    top: 260px;
    height: 50px;
    display: block;
    line-height: 50px;
    left: 320px;
    color: #fff;
}
.vpcs-banner-sr-input {
    position: absolute;
    top: 260px;
    left: 410px;
    background: #fff;
    outline: none;
    line-height: 50px;
    padding: 0 10px;
    width: 360px;
    height: 50px;
    border: 0;
}
.vpcs-banner-sr-button {
    position: absolute;
    outline:none;
    top: 260px;
    left: 810px;
    width: 100px;
    height: 50px;
    line-height: 50px;
    text-align: center;
    background: #ff3b2e;
    color: #fff;
    outline: none;
    font-size: 16px;
    border: 0;
    cursor: pointer;
    transition: background ease .3s;
}
.vpcs-main {
    width: 1200px;
    min-height: 480px;
    margin: auto;
}
.vpcs-bgyz-jg {
    text-align: center;
    width: 100%;
    color: #ff2b3e;
    padding-top: 30px;
}
.vpcs-bgyz-table {
    width: 1198px;
    border: 1px solid #eaeaea;
    margin-top: 30px;
}
.vpcs-bgyz-table tr td {
    height: 44px;
    line-height: 44px;
    border-bottom: 1px solid #eaeaea;
}
.vpcs-bgyz-table-title {
    border-right: 1px solid #eaeaea;
    width: 200px;
    text-align: right;
    padding-right: 10px;
    background: #f7f7f7;
    color: #6f747a;
}
.vpcs-bgyz-table-content {
    padding-left: 10px;
    width:1000px;
}
button:focus {
  border: 0 none;
  outline: none;
}

</style>
@stop
@section('content')
<!-- Modal -->
<div>
    <div class="vpcs-banner">
    <div class="vpcs-banner-srk">
            <span class="vpcs-banner-sr-span">报告编号：</span>
            <input class="vpcs-banner-sr-input" type="text" id="ver_number" placeholder="请输入报告编号">
            <button class="vpcs-banner-sr-button" id="ver_button">
                开始验证</button>
        </div>
    </div>
    <div style="background:#fff;">
    <div class="vpcs-main">
        <div class="vpcs-bgyz-jg" id="ver_msg" style="display:none;">
           <span>√ 验证通过！您查询的报告已通过【真伪验证】！</span></div>

        <!--<div class="vpcs-bgyz-jg"><i class="fa fa-close"></i> 验证失败！这是假论文！</div>-->
        <br>
        <br>
        <span id="mesage" style="margin-left: 34%; display: none;"></span>
        <table class="vpcs-bgyz-table" id="ver_table" style="display:none">
            <tbody>
                <tr>
                    <td class="vpcs-bgyz-table-title">
                        验证产品：
                    </td>
                    <td class="vpcs-bgyz-table-content" id="name">维普论文检测系统</td>
                </tr>
                <tr>
                    <td class="vpcs-bgyz-table-title">
                        版本类型：
                    </td>
                    <td class="vpcs-bgyz-table-content" id="ver_type"></td>
                </tr>
                <tr>
                    <td class="vpcs-bgyz-table-title">
                        报告编号：
                    </td>
                    <td class="vpcs-bgyz-table-content" id="ver_reportNumber"></td>
                </tr>
                <tr>
                    <td class="vpcs-bgyz-table-title">
                        论文题目：
                    </td>
                    <td class="vpcs-bgyz-table-content" id="ver_title"></td>
                </tr>
                <tr>
                    <td class="vpcs-bgyz-table-title">
                        检测时间：
                    </td>
                    <td class="vpcs-bgyz-table-content" id="ver_checkTime"></td>
                </tr>
                <tr>
                    <td class="vpcs-bgyz-table-title">
                        总相似比：
                    </td>
                    <td class="vpcs-bgyz-table-content" id="ver_similar"></td>
                </tr>
            </tbody>
        </table>
    </div>
    </div>

</div>

@stop
<!--/.fluid-container-->
@section('scripts')
  <script>
      $(function () {

      if(!!window.ActiveXObject || "ActiveXObject" in window){
        $("#Ieno").css("display","none")
      }else{
        $("#Ieno").css("display","block")
　　  }
      var timer = null
      $('#staticBackdrop').on('show.bs.modal', function () {
        axios.get("/official_account").then(function(res){
          var img = new Image();
          img.onload = function() {
            $("#qrimg").attr('src',res.data.url);
            $("#qrimg").css("display","block");
            $("#loginIcon").css("display","none");
          }
          img.src = res.data.url;
          var wechatFlag = res.data.wechatFlag;
          timer = setInterval(function(){
            axios.post("login_check",{
              wechat_flag:wechatFlag
            }).then(function(res){
              if(res.status==200){
                clearInterval(timer);
                swal("提示", "登录成功", "success");
                location.reload();
              }
            })
          }, 1000);
        })
      })
      //注册
      $("#quiklyRegister").click(function(){
        $("#staticBackdrop").modal("hide")
        $("#registerTcDialog").modal('show')
      })
      $("#noregister").click(function(){
        $("#registerTcDialog").modal('hide')
        $("#staticBackdrop").modal("show")
        $("#pills-home-tab").attr("aria-selected",true)
        $("#pills-home-tab").addClass('active')
        $("#pills-profile-tab").attr("aria-selected",false)
        $("#pills-profile-tab").removeClass('active')
        $("#pills-profile").removeClass('active show')
        $("#pills-home").addClass("active show")

      })
      //模态框关闭
      $('#staticBackdrop').on('hidden.bs.modal', function () {
          clearInterval(timer);
      })
      // Tab切换
      $('.banner-li').click(function () {
        $(this)
          .addClass('li-current')
          .siblings()
          .removeClass('li-current')
        let liIndex = $(this).index()
        $('.listbox')
          .eq(liIndex)
          .css('display', 'block')
          .siblings('.listbox')
          .css('display', 'none')
      })
      $(document).keydown(function (e) {
        if (e.keyCode == 13) {
          $("#btnSubmit").click()
        }
      })
      //账号登录
      $('#accountLogin').click(function () {
        axios.post('{{route('login') }}', {
          phone: $("#phone").val(),
          password: $("#password").val(),
          type: 'account'
        }).then(function(res){
          if (res.status == 200) {
            swal("提示", res.data.message, "success");
            location.reload();
          } else {
            swal("提示", res.data.message);
          }
        }).catch(function(err){
          if (err.response.status == 422) {
            $.each(err.response.data.errors, function(field, errors){
              swal("提示", errors[0]);
            })
          }
          if (err.response.status == 401) {
            $.each(err.response.data, function(field, errors){
              swal("提示", errors);
            })
          }
        })
      })
      var wait = 60;
      var verification_key = '';
      function time(o) {
        if (wait == 0) {
          o.removeAttribute("disabled");
          o.value = "点击获取验证码";
          wait = 60;
        } else {
          o.setAttribute("disabled", true);
          o.value = "重新发送(" + wait + ")";
          wait--;
          setTimeout(function () {
              time(o)
            },
            1000)
        }
      }

      function getcode(index) {
        index.setAttribute('disabled', true);
        var phone = $("#mobile").val();
        var reg = /^1[34578]\d{9}$/;
        if (!reg.test(phone)) {
          index.removeAttribute("disabled");
          $("input[name='phone']").focus();
          swal('提示信息', "请输入正确的手机号码!!!");
          return;
        }
        axios.post('/api/v1/verificationCodes', {
          phone: phone,
        }).then(function(res){
          swal('验证码已发送成功!,请注意查收!')
          time(index);
          verification_key = res.data.key;
        }).catch(function(err){
          index.removeAttribute("disabled");
          if (err.response.status == 401) {
            $.each(err.response.data.errors, function(field, errors){
              swal("提示", errors[0]);
            })
          }
        })
      }
      //忘记密码
      $("#forgetpsw").click(function(){
        $("#staticBackdrop").modal('hide')
        $("#forgetModal").modal("show");
      })
      $('#verificationCode').click(function () {
        getcode(this)
      })
      $('#phoneLogin').click(function() {
        axios.post('{{ route('login') }}', {
          phone: $('#mobile').val(),
          verification_code: $('#verification_code').val(),
          verification_key: verification_key,
          type: 'phone'
        }).then(function(res){
          swal("提示", '登录成功', "success");
          location.reload();
        }).catch(function(err) {
          if (err.response.status == 401) {
            swal("提示", '用户不存在！！！');
          }
          if (err.response.status == 422) {
            $.each(err.response.data.errors, function(field, errors){
              swal("提示", errors[0]);
            })
          }
        });
      });
      // Tab切换
      $(".banner-li").click(function () {
        $(this)
          .addClass("li-current")
          .siblings()
          .removeClass("li-current");
        let liIndex = $(this).index();
        $(".listbox")
          .eq(liIndex)
          .css("display", "block")
          .siblings(".listbox")
          .css("display", "none");
      });
      })



        $("#ver_button").click(function(){
          var vernum = $("#ver_number").val()
          if(!vernum){
            $.alert('请输入报告编号');
            return;
          }
          axios.post("/api/v1/verification-report",{number:vernum}).then(function(res){
              if(!res.data.msg){
                $("#ver_type").text(res.data.type)
                $("#ver_reportNumber").text(res.data.paperobject.guid)
                $("#ver_title").text(res.data.paperobject.title)
                $("#ver_checkTime").text(res.data.checktime)
                $("#ver_similar").text(res.data.paperobject.Percentage+"%")
                $("#ver_msg").css('display','block')
                $("#ver_table").css('display','block')
              }else{
                $("#ver_msg").css('display','none')
                $("#ver_table").css('display','none')
                $.alert('报告不存在')
              }
          })
        })
      })
  </script>
@stop
