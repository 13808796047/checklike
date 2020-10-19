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
        <div>智能降重</div>
        <div>
          <span>模式：</span>
          <label class="radio-inline"><input type="radio" name="optradio">智能换词</label>
          <label class="radio-inline"><input type="radio" name="optradio">智能改写</label>
          <label class="radio-inline"><input type="radio" name="optradio">智能换词、智能改写同时改写</label>
        </div>
        <div style="display:flex;">
          <label for="sel1">原创度:</label>
          <select class="custom-select custom-select-sm" id="sel1" style="width:10%;margin:0 20px;">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
          </select>
          <p>(数值越大、可读性越高)</p>
        </div>
        <div>
          <p>关键词锁定:(智能原创时，保护以下关键词不被替换，多个关键词以"|搁开)</p>
          <div>
              <textarea class="form-control" rows="3"></textarea>
          </div>
        </div>
        <div style="margin:25px 0;">
           <textarea class="form-control" rows="10"></textarea>
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

  </script>
@stop
