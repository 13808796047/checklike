@extends('layouts.app')
@section('title','自动降重')
@section('styles')
<!-- <link href="{{asset('asset/css/toast-min.css')}}" rel="stylesheet" /> -->
<link rel="stylesheet" href="{{asset('asset/css/check.css')}}">
<style>
  del { background: #FFB6C1; }
  ins { background: #90EE90;text-decoration:none; }
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
</style>
  <!-- <link href="https://css.lianwen.com/css/public_c.css?v=2018v1" type="text/css" rel="stylesheet"/>
  <link href="https://css.lianwen.com/css/index_2017.css" type="text/css" rel="stylesheet"/> -->
  <!-- <link rel="stylesheet" href="{{asset('asset/css/index.css')}}"> -->
@stop
@section('content')
  <!-- 模态框 -->
  @auth
  <div class="modal fade bd-example-modal-sm" id="exampleModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">提示</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="text-align:center;">
          <p>本次操作将消耗1次降重次数</p>
          <p>剩余次数：<span id="requestcishuNum">{{ auth()->user()->jc_times}}</span><span style="color:#4876FF;margin-left:10px;cursor:pointer;" id="addjctimes">增加次数</span></p>
        </div>
        <div class="modal-footer">
          <p style="color:#4876FF;margin-right:25%;display:none;" id="freeadds">免费增加</p>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
          <button type="button" class="btn btn-primary" id="surecheck">确定</button>
        </div>
      </div>
    </div>
  </div>
  @endauth
  <!-- 模态框结束 -->
   <!-- 模态框2 -->
   @auth
   <div class="modal fade bd-example-modal-sm" id="beingModal11" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" >
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-body" style="text-align:center;">
          <div style="padding:20px 0">正在降重中，请勿刷新页面</div>
        </div>
      </div>
    </div>
  </div>
  @endauth
  <!-- 购买降重字数模态框 -->
  @auth
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
  @endauth
  <!-- 购买降重字数模态框结束 -->
  <!-- 模态框2结束-->
  <div class="container" style="margin:18px auto">
      <div class="grid grid-cols-12 gap-4">
    <div class="col-span-9 p-4" style="box-shadow: 0 0 6px rgba(0, 0, 0, 0.3);background:#fff;min-height:calc(100vh * 0.81);" id="jcleft">
        <div style="display:flex;align-items:flex-end;font-size:15px;">
          <div style="font-weight: bolder;font-size: 18px;">智能降重</div>
          <p style="margin-left:13px;font-size:13px;" id="isshowtimes">当前剩余次数 ：<span>{{ auth()->user()->jc_times}}次</span><span style="margin-left: 11px;color: #1E90FF;cursor:pointer;font-size:13px;" id="pageAdd">增加次数</span></p>
        </div>


        <div style="margin-top:25px;" id="jcqian">
           <textarea class="form-control" rows="19" id="content" placeholder="请输入降重内容，不能超4000字"></textarea>
           <div style="margin:10px 0;">
              <p style="color:#A9A9A9;font-size:13px;">注:本工具是通过运用AI技术对原文进行智能原创，需要稍作调整让语句更加通顺。如需高质量人工降重请联系微信:cx5078</p>
            </div>
           <div style="margin-top:10px;">

              <button type="button" class="btn btn-primary" id="aiSubmitBtn">提交</button>
              <button type="button" class="btn btn-secondary" id="clearcontainer">清除内容</button>

             <p style="float: right;font-size: 13px;padding-right: 30px;" id="words">当前输入<span>0</span>字</p>
          </div>
        </div>
      <div style="margin-top:25px;display:none;" id="jchou">
        <div style="display:flex;">
            <div style="width:100%;">
                <div style="display:flex;justify-content:space-between;">
                <p style="margin-bottom:10px;">降重前</p>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1" checked>
                    <label class="custom-control-label" for="customSwitch1">显示修改对比</label>
                </div>
                </div>

                <div id="content_after" style="height:450px;overflow-y:auto;background:#fff;border: 1px solid #ddd;padding: 19px;"></div>
            </div>
            <div style="margin:0 17px;"></div>
            <div style="width:100%;">
            <div style="display:flex;justify-content:space-between;">
                <p style="margin-bottom:10px;">降重后</p>
                <div>
                   <p style="color:#3490dc;font-size:13px;">与原稿相似度：<span id="xiangsiduNum"></span></p>
                </div>
                </div>
                <textarea id="content_later" style="height:450px;overflow-y:auto;background:#fff;border: 1px solid #ddd;padding: 19px;width:100%;"></textarea>
            </div>
        </div>
        <div style="margin:10px 0;">
          <p style="color:#A9A9A9;">注:本工具是通过运用AI技术对原文进行智能原创，需要稍作调整让语句更加通顺。如需高质量人工降重请联系微信:cx5078</p>
        </div>
        <div style="margin-top:10px;">
          <button type="button" class="btn btn-primary" id="againjc">再次降重</button>
        </div>
      </div>
      </div>
    <div class="col-span-3" id="jcright">
      <div>
      <div style="background:#54B538;color: #fff;padding-left: 20px;font-size: 15px;height: 44px;line-height: 44px;">系统客服</div>
      <div style="border-bottom: 1px solid #c1bebd;box-shadow: 0px 0px 5px #c1bebd;padding: 15px;background: #FFFFFF;">
          <img src="https://www.checklike.com/images/qrcode/sz-work.png" style="width:171px;height:171px;display:block;margin:0 auto;">
          <p style="text-align:center;margin-top:7px;font-size:13px;">微信扫一扫，与客服在线沟通</p>
      </div>
      </div>
      <div style="background:#fff;box-shadow: 0 0 6px rgba(0, 0, 0, 0.3);margin-top:13px;" class="p-4">
        <b>1、怎么选择适合自己的论文检测系统？</b>
        <p>只有使用和学校相同的数据库，才能保证重复率与学校、杂志社100%一致：</br>论文初次修改可使用联文检测、PaperPass，定稿再使用与学校一样的系统。</p>
        <b>2、检测要多长时间，报告怎么还没出来？</b>
        <p>正常检测20分钟左右，毕业高峰期，服务器检测压力大，时间会有延长，请大家提前做好时间准备。超过2小时没出结果可以联系客服处理！</p>
        <b>3、同一篇论文可以多次检测吗？？</b>
        <p>本站不限制论文检测次数，但检测一次需支付一次费用。</p>
        <b>4、检测报告有网页版、pdf格式的吗？</b>
        <p>检测完成后会提供网页版和pdf格式的检测报告，报告只是格式不同，重复率都一样的。</p>
      </div>
    </div>
  </div>
</div>
@stop
@section('scripts')
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> -->
<script type="text/javascript" src="{{ asset('asset/js/qrcode.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('asset/js/copy_cliboard.js') }}"></script>
<script type="text/javascript" src="{{ asset('asset/js/diff.js') }}"></script>
  <script>

  if(!!window.ActiveXObject || "ActiveXObject" in window){
      $("#jcright").css("display","none")
    }else{
      $("#jcright").css("display","block")
　　}
  //清空内容
  $("#clearcontainer").click(function(){
    $.confirm({
        title: '提示',
        content: '您确认要清空内容吗?',
        buttons: {
            ok: {
                text: '确认',
                btnClass:  'btn-danger',
                action: function() {
                  $("#content").val("")
                  $("#words span").text(0)
                }
            },
            cancel: {
                text: '取消',
                btnClass: 'btn-info'
            }
        }
      });
  })

  //增加降重字数
  $("#addjctime").click(function(){
    let current = Number($("#curjctime").text())+1;
    $("#curjctime").text(current)
  })
  //减少降重次数
  $("#cutjctime").click(function(){
    let current = Number($("#curjctime").text());
    if(current==1) return;
    let cur = current -1;
    $("#curjctime").text(cur)
  })
  // 增加次数
  $("#addjctimes").click(function(){
        $('#exampleModal').modal('hide')
        $("#jctimeModal").modal('show')
    })

  $("#pageAdd").click(function(){
    $("#jctimeModal").modal('show')
  })

  //获取字数
  $("#content").bind('input',function(e){
        $('#words span').html(e.target.value.length)
  })
   //再来一篇
   $('#againjc').click(function(){
        window.location.reload()
      })
  $("#aiSubmitBtn").click(function(){
    let words =  $('#words span').text();
    if(words>4000){
      toastr.error('字数不能大于4000字');

      return;
    }


    $('#exampleModal').modal('show')
  })
  $("#surecheck").click(function(){
    $('#exampleModal').modal('hide')

    let num = $("#requestcishuNum").html();
    if(num == 0){
      toastr.error('您的降重次数不足');
      return;
    }

    togetJc(num)
  })
  //确认购买
  $("#sureshop").click(function(){
        let totalprice=$("#curjctime").text();
        console.log(totalprice,3131)
        axios.post('{{ route('recharges.store') }}',{
          total_amount:totalprice,
          amount:totalprice
        }).then(function(res){
          let number = res.data.data.amount;
          let id =res.data.data.id;
          let price=res.data.data.total_amount;
          location.href="/recharges/"+id
        }).catch(function(err){
          console.log(err,31312)
        })
      })
  var Similarity = ""
  function togetJc(num){
    let contents = $('#content').val();
    // $('#beingModal').modal('hide')
        $('#beingModal11').modal('show')
        axios.post("/ai_rewrite",{ txt:contents,sim:1,th:"",retype:"",filter:"",type:"rewrite"})
          .then(function(res){
            if(res.data.errcode==100101){
              $('#beingModal11').modal('hide');
              toastr.error('今日配额已满，请明天再试或联系客服');
              return;
            }
            $('#jcqian').css('display', 'none')
            $("#jchou").css('display', 'block')
            $('#beingModal11').modal('hide')
            $("#jcright").css("display",'none')
            $("#jcleft").addClass("col-span-12").removeClass("col-span-9")
            $('#jcqian').css('display', 'none')
            var htmlstring=res.data.data;
            Similarity = res.data.like;
            $("#jchou").css('display', 'block')
            $("#isshowtimes").css("display","none")
            changed(contents,htmlstring)
          })
          .catch(function(err){
            num--;
            if(num>=0){
              togetJc(num)
              return;
            }else{
              $('#beingModal11').modal('hide')
              toastr.error('降重失败，请重试');
            }
          }
          ).finally(function(){
            $('#beingModal11').modal('hide')
          })
    }
    var currentJcContainer = ""
    var currentAllContainer = ""
    function changed(a,b) {
            var diff = JsDiff['diffChars'](a, b);
            var arr = new Array();
            for (var i = 0; i < diff.length; i++) {
                if (diff[i].added && diff[i + 1] && diff[i + 1].removed) {
                    var swap = diff[i];
                    diff[i] = diff[i + 1];
                    diff[i + 1] = swap;
                }
                var diffObj = diff[i];
                var content = diffObj.value;
                //可以考虑启用，特别是后台清理HTML标签后的文本
                if (content.indexOf("\n") >= 0) {
                    //console.log("有换行符");
                    //替换为<br/>
                    var reg = new RegExp('\n', 'g');
                    content = content.replace(reg, '<br/>');
                }
                if (diffObj.removed) {
                    arr.push('<del title="删除的部分">' + content + '</del>');
                } else if (diffObj.added) {
                    arr.push('<ins title="新增的部分">' + content + '</ins>');
                } else {
                    //没有改动的部分
                    arr.push('<span title="没有改动的部分">' + content + '</span>');
                }
            }
            var html = arr.join('');
            // document.getElementById('content_later').innerHTML = html;
            // document.getElementById('content_after').innerHTML = a;
            currentAllContainer = html;

            a = a.replace(/\r\n/g, '<br/>'); //IE9、FF、chrome
            a = a.replace(/\n/g, '<br/>'); //IE7-8
            a = a.replace(/\s/g, ' '); //空格处理
            currentJcContainer = a;
            document.getElementById('content_later').innerHTML = b;
            document.getElementById('content_after').innerHTML = html;
            Similarity = Number(Similarity*100).toFixed(1);
            $("#xiangsiduNum").text(Similarity+"%")
        }

        //切换显示详情
        $("#customSwitch1").change(function(e){
          let currentStatus = $("#customSwitch1").prop('checked')
          if(currentStatus){
            $("#content_after").html(currentAllContainer)
          }else{
            $("#content_after").html(currentJcContainer)
          }
        })

  </script>
@stop
