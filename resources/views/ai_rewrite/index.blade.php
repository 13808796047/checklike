@extends('layouts.app')
@section('title','智能查重')
@section('styles')
<link rel="stylesheet" href="{{asset('asset/css/check.css')}}">
  <style>
</style>
  <!-- <link href="https://css.lianwen.com/css/public_c.css?v=2018v1" type="text/css" rel="stylesheet"/>
  <link href="https://css.lianwen.com/css/index_2017.css" type="text/css" rel="stylesheet"/> -->
  <!-- <link rel="stylesheet" href="{{asset('asset/css/index.css')}}"> -->
@stop
@section('content')
  <!-- alert提示框 -->

  <!-- 模态框 -->
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
        <!-- <div style="margin-top:25px;">
           <textarea class="form-control" rows="13" id="content"></textarea>
        </div> -->
        <div style="margin-top:25px;display:flex;">
            <textarea class="form-control" rows="13"></textarea>
            <textarea class="form-control" rows="13"></textarea>
        </div>
        <div>
          <p style="color:#A9A9A9;">注:本工具是通过运用AI技术对原文进行智能原创，需要稍作调整让语句更加通顺。如需高质量人工降重请联系微信:cx5078</p>
        </div>
        <div style="margin-top:10px;">
          <button type="button" class="btn btn-primary" id="aiSubmitBtn">提交</button>
          <button type="button" class="btn btn-secondary">清除内容</button>
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
    let filter = $("#filter").val().replace(/\s*/g,"")
    let contents = $('#content').val();
        axios.post("/ai_rewrite",{ txt:contents,sim:1,th:optionVal,retype:checkvalue,filter:filter})
          .then(res => {
            console.log(res,"fdsafs")
          })
          .catch(err =>{
            console.log(err,"xixijsafjsajf")
          }
        );
  })

  </script>
@stop
