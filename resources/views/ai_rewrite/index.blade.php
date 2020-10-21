@extends('layouts.app')
@section('title','智能查重')
@section('styles')
<link href="{{asset('asset/css/toast-min.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('asset/css/check.css')}}">
<style>
  del { background: #FF4040; }
  ins { background: #00ff21;text-decoration:none; }
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
          <p>剩余次数：<span id="requestcishuNum">{{ auth()->user()->jc_times}}</span><span style="color:#4876FF;margin-left:10px;" id="addjctimes">增加次数</span></p>
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
  <!-- 模态框2结束-->
  <div class="main clearfix" style="min-height:800px;">
    <div class="lbox fl">
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
              <button type="button" class="btn btn-secondary">清除内容</button>
          </div>
        </div>
      <div style="margin-top:25px;" id="jchou">
        <div style="display:flex;">
            <div style="width:100%;">
                <p>降重前</p>
                <div id="content_later" style="height:550px;overflow-y:auto;background:#fff;border: 1px solid #ddd;padding: 19px;"></div>
            </div>
            <div style="margin:0 17px;"></div>
            <div style="width:100%;">
                <p>降重后</p>
                <div id="content_later" style="height:550px;overflow-y:auto;background:#fff;border: 1px solid #ddd;padding: 19px;"></div>
            </div>
        </div>
      </div>
      </div>


  <div class="rbox fr">
      <div class="tit">在线客服</div>
      <div class="box">客服微信:cx5078</div>
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
@stop
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
  var optionVal = "3"
  function optionChange(){
    var sel=document.getElementById('sel');
    var sid=sel.selectedIndex;
    optionVal = sel[sid].value
  }

  $("#aiSubmitBtn").click(()=>{
    optionChange();
    getRadioVal();
    $('#exampleModal').modal('show')
    // let filter = $("#filter").val().replace(/\s*/g,"")
    // let contents = $('#content').val();
    //     axios.post("/ai_rewrite",{ txt:contents,sim:1,th:optionVal,retype:checkvalue,filter:filter})
    //       .then(res => {
    //         console.log(res,"fdsafs")
    //       })
    //       .catch(err =>{
    //         console.log(err,"xixijsafjsajf")
    //       }
    //     );
  })
  $("#surecheck").click(()=>{
    $('#exampleModal').modal('hide')
    $('#beingModal').modal('show')
    // alertify.set('notifier','position', 'top-center');
    //   alertify.notify("fdsjafsjf",'custom',3)
    let num = $("#requestcishuNum").html();
    togetJc(num)
  })

  function togetJc(num){
    optionChange();
    getRadioVal();
    let filter = $("#filter").val().replace(/\s*/g,"")
    let contents = $('#content').val();
    $('#beingModal').modal('hide')
    $('#jcqian').css('display', 'none')
    $("#jchou").css('display', 'block')
    var htmlstring="一切正常检测20分钟上下，大学毕业高峰期，网络服务器检测压力太大，时间会有增加，请大伙儿提早做好时间提前准备。超出2钟头没出結果能够联络在线客服解决"

    changed(contents,stringtemp,htmlstring)
    // var stringtemp =htmlstring.replace(/<[^>]+>/g, "");
        // axios.post("/ai_rewrite",{ txt:contents,sim:1,th:optionVal,retype:checkvalue,filter:filter})
        //   .then(res => {
        //     $('#beingModal').modal('hide')
        //     $('#jcqian').css('display', 'none')
        //     var htmlstring=res.data.data;
        //     var stringtemp =htmlstring.replace(/<[^>]+>/g, "");
        //     $("#jchou").css('display', 'block')
        //     changed(contents,stringtemp,htmlstring)
        //   })
        //   .catch(err =>{
        //     num--;
        //     if(num>=0){
        //       togetJc(num)
        //       return;
        //     }else{
        //       $('#beingModal').modal('hide')
        //       alertify.set('notifier','position', 'top-center');
        //       alertify.notify("降重失败，请重试",'custom',3)
        //     }
        //   }
        //   );
    }

    function changed(a,b) {
      var oldContent = "正常检测20分钟左右，毕业高峰期，服务器检测压力大，时间会有延长，请大家提前做好时间准备。超过2小时没出结果可以联系客服处理！";
            var content1 = "一切正常检测20分钟上下，大学毕业高峰期，网络服务器检测压力太大，时间会有增加，请大伙儿提早做好时间提前准备。超出2钟头没出結果能够联络在线客服解决"
            var diff = JsDiff['diffChars'](oldContent, content1);
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

            result.innerHTML = html;
        }

  </script>
@stop
