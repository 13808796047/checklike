@extends('layouts.app')
@section('title','智能查重')
@section('styles')
<!-- <link href="{{asset('asset/css/toast-min.css')}}" rel="stylesheet" /> -->
<link rel="stylesheet" href="{{asset('asset/css/check.css')}}">
<style>
  del { background: #FF4040; }
  ins { background: #00ff21;text-decoration:none; }
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
          <p style="color:#4876FF;margin-right:25%;" id="freeadds">免费增加</p>
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
   <div class="modal fade bd-example-modal-sm" id="beingModal" tabindex="-1" role="dialog"
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
          <p style="color:#4876FF;margin-right:25%;" id="freeadd">免费增加</p>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
          <button type="button" class="btn btn-primary" id="sureshop">确定</button>
        </div>
      </div>
    </div>
  </div>
  @endauth
  <!-- 购买降重字数模态框结束 -->
  <!-- 模态框2结束-->
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
  <div class="container" style="margin:18px auto">
      <div class="grid grid-cols-12 gap-4">
    <div class="col-span-9 p-4" style="box-shadow: 0 0 6px rgba(0, 0, 0, 0.3);background:#fff;min-height:calc(100vh * 0.81);" id="jcleft">
        <div style="font-weight: bolder;font-size: 18px;">智能降重</div>
        <div>
          <span>模式：</span>
          <label class="radio-inline"><input type="radio" name="radio" style="margin-right:5px;" value="0" checked>智能换词</label>
          <label class="radio-inline" style="margin:0 10px;"><input type="radio" name="radio" style="margin-right:5px;" value="1">智能改写</label>
          <label class="radio-inline"><input type="radio" name="radio" style="margin-right:5px;" value="-1">智能换词、智能改写同时改写</label>
        </div>
        <div style="display:flex;">
          <label for="sel">原创度:</label>
          <select class="custom-select custom-select-sm" id="sel" style="width:10%;margin:0 20px;"  onchange="optionChange()">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3" selected>3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select>
          <p>(数值越大、可读性越高)</p>
        </div>
        <div>
          <p>关键词锁定:(智能原创时，保护以下关键词不被替换，多个关键词以 "|" 搁开)</p>
          <div>
              <textarea class="form-control" rows="3" id="filter"></textarea>
          </div>
        </div>
        <div style="margin-top:25px;" id="jcqian">
           <textarea class="form-control" rows="13" id="content"></textarea>
           <div>
              <p style="color:#A9A9A9;">注:本工具是通过运用AI技术对原文进行智能原创，需要稍作调整让语句更加通顺。如需高质量人工降重请联系微信:cx5078</p>
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
                <p>降重前</p>
                <div id="content_after" style="height:370px;overflow-y:auto;background:#fff;border: 1px solid #ddd;padding: 19px;"></div>
            </div>
            <div style="margin:0 17px;"></div>
            <div style="width:100%;">
                <p>降重后</p>
                <textarea id="content_later" style="height:370px;overflow-y:auto;background:#fff;border: 1px solid #ddd;padding: 19px;width:100%;"></textarea>
            </div>
        </div>
        <div>
          <p style="color:#A9A9A9;">注:本工具是通过运用AI技术对原文进行智能原创，需要稍作调整让语句更加通顺。如需高质量人工降重请联系微信:cx5078</p>
        </div>
        <div style="margin-top:10px;">
          <button type="button" class="btn btn-primary" id="againjc">再次降重</button>
        </div>
      </div>
      </div>
    <div class="col-span-3 p-4" style="box-shadow: 0 0 6px rgba(0, 0, 0, 0.3);background:#fff" id="jcright">
      <div class="p-4">
      <div class="tit">在线客服</div>
      <div class="box">客服微信:cx5078</div>
      </div>
      <div class="box mt10">
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

   var checkvalue = "";
  function getRadioVal(){
    var radio_tag = document.getElementsByName("radio");
    for(let i=0;i<radio_tag.length;i++){
        if(radio_tag[i].checked){
          checkvalue = radio_tag[i].value
          return checkvalue
        }
    }
  }
  //清空内容
  $("#clearcontainer").click(()=>{
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
  var optionVal = "3"
  function optionChange(){
    var sel=document.getElementById('sel');
    var sid=sel.selectedIndex;
    optionVal = sel[sid].value
  }
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
  // 增加次数
  $("#addjctimes").click(()=>{
        $('#exampleModal').modal('hide')
        $("#jctimeModal").modal('show')
    })
  //获取字数
  $("#content").bind('input',(e)=>{
        $('#words span').html(e.target.value.length)
  })
   //再来一篇
   $('#againjc').click(function(){
        window.location.reload()
      })
  $("#aiSubmitBtn").click(()=>{
    let words =  $('#words span').text();
    if(words>5000){
      toastr.error('你有新消息了！');
      // alertify.set('notifier','position', 'top-center');
      // alertify.notify("字数不能大于5000字",'custom',3)
      return;
    }
    optionChange();
    getRadioVal();
    $('#exampleModal').modal('show')
  })
  $("#surecheck").click(()=>{
    $('#exampleModal').modal('hide')

    let num = $("#requestcishuNum").html();
    if(num == 0){
      alertify.set('notifier','position', 'top-center');
      alertify.notify("您的降重次数不足",'custom',3);
      return;
    }
    $('#beingModal').modal('show')
    togetJc(num)
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
  function togetJc(num){
    optionChange();
    getRadioVal();
    let filter = $("#filter").val().replace(/\s*/g,"")
    let contents = $('#content').val();
    $('#beingModal').modal('hide')
    $('#jcqian').css('display', 'none')
    $("#jchou").css('display', 'block')
        axios.post("/ai_rewrite",{ txt:contents,sim:1,th:optionVal,retype:checkvalue,filter:filter})
          .then(res => {
            $('#beingModal').modal('hide')
            $("#jcright").css("display",'none')
            $("#jcleft").addClass("col-span-12").removeClass("col-span-9")
            $('#jcqian').css('display', 'none')
            var htmlstring=res.data.data;
            $("#jchou").css('display', 'block')

            changed(contents,htmlstring)
          })
          .catch(err =>{
            num--;
            if(num>=0){
              togetJc(num)
              return;
            }else{
              $('#beingModal').modal('hide')
              alertify.set('notifier','position', 'top-center');
              alertify.notify("降重失败，请重试",'custom',3)
            }
          }
          );
    }

    function changed(a,b) {
            var diff = JsDiff['diffChars'](a, b);
            var arr = new Array();
            for (var i = 0; i < diff.length; i++) {
                if (diff[i].added && diff[i + 1] && diff[i + 1].removed) {
                    var swap = diff[i];
                    diff[i] = diff[i + 1];
                    diff[i + 1] = swap;
                }
                console.log(diff[i]);
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
            document.getElementById('content_later').innerHTML = b;
            document.getElementById('content_after').innerHTML = html;
        }

  </script>
@stop
