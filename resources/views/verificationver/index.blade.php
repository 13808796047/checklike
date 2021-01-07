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
    <div class="vpcs-main">
        <div class="vpcs-bgyz-jg" id="msg" style="">
            <i class="fa fa-check"></i><span>验证通过！您查询的报告已通过【真伪验证】！</span></div>
        <!--<div class="vpcs-bgyz-jg"><i class="fa fa-close"></i> 验证失败！这是假论文！</div>-->
        <br>
        <br>
        <span id="mesage" style="margin-left: 34%; display: none;"></span>
        <table class="vpcs-bgyz-table" id="table" style="">
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
                    <td class="vpcs-bgyz-table-content" id="type">维普论文检测（大学生版）</td>
                </tr>
                <tr>
                    <td class="vpcs-bgyz-table-title">
                        报告编号：
                    </td>
                    <td class="vpcs-bgyz-table-content" id="reportNumber">251841098581c0ea</td>
                </tr>
                <tr>
                    <td class="vpcs-bgyz-table-title">
                        论文题目：
                    </td>
                    <td class="vpcs-bgyz-table-content" id="title">我国乡村旅游发展中的成功经验研究——以昆明市为例</td>
                </tr>
                <tr>
                    <td class="vpcs-bgyz-table-title">
                        检测时间：
                    </td>
                    <td class="vpcs-bgyz-table-content" id="checkTime">2020-10-27 12:09:56</td>
                </tr>
                <tr>
                    <td class="vpcs-bgyz-table-title">
                        总相似比：
                    </td>
                    <td class="vpcs-bgyz-table-content" id="similar">40.47</td>
                </tr>
            </tbody>
        </table>
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
