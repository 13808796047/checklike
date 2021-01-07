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
</style>
@stop
@section('content')
<!-- Modal -->
<div>
    <div class="vpcs-banner">
    <div class="vpcs-banner-srk">
            <span class="vpcs-banner-sr-span">报告编号：</span>
            <input class="vpcs-banner-sr-input" type="text" id="number" placeholder="请输入报告编号">
            <button class="vpcs-banner-sr-button">
                开始验证</button>
        </div>
    </div>
</div>

@stop
<!--/.fluid-container-->
@section('scripts')
  <script>
      $(function () {
      })
  </script>
@stop
