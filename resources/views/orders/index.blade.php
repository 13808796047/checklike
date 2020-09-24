@extends('domained::layouts.app')
@section('title', '检测报告')
@section('styles')
  <link rel="stylesheet" href="{{asset('asset/css/check.css')}}">
  <style>
    .curfont{
      font-size:16px;
    }
  </style>
@stop
@section('content')
  <div class="main clearfix" style="min-height:800px;">
    <div class="lbox fl">
      <table class="table table-hover table-sm text-center">
        <thead class="thead-dark">
        <tr>
          <th scope="col"><input type="checkbox" id="allcheck"></th>
          <th scope="col">论文题目</th>
          <th scope="col">系统名称</th>
          <th scope="col">状态</th>
          <th scope="col">检测结果</th>
          <th scope="col">提交日期</th>
          <th scope="col">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
          <tr>
            <td><input type='checkbox' name='delete' value='{{$order->id}}'/></td>
            <td>{{$order->title}}</td>
            <td>{{ $order->category->name ?? '' }}</td>
            <td>{{\App\Models\Enum\OrderEnum::getStatusName($order->status)}}</td>
            <td>{{ $order->rate }}</td>
            <td>{{$order->created_at}}</td>
            @if($order->status==0)
              <td><a href='{{route('orders.show',$order)}}' class="bbtn">支付</a></td>
            @elseif($order->status==4)
              <td><a href='{{route('orders.view-report',$order)}}' class="bbtn">查看报告</a></td>
            @else
              <td><a href='javascript:;' class="bbtn">-</a></td>
            @endif
          </tr>
        @endforeach
        </tbody>
      </table>
      <div class="flex justify-between">

        <a class="inline-block text-white py-2 px-4" id="del_item"><span style="background: red;
    padding: 5px 10px;">删除</span></a>

        <span class="p-2">共{{$orders->total()}}条</span>
        <nav aria-label="Page navigation ">
          <ul class="pagination ">
            <li class="page-item"><a class="page-link" href="{{$orders->previousPageUrl()	}}">上一页</a></li>
            @for($i=1;$i<=$orders->lastPage();$i++)
              <li class="page-item {{ $i==$orders->currentPage()?'active':'' }}"><a class="page-link"
                                                                                    href="{{$orders->url($i)}}">{{$i}}</a>
              </li>
            @endfor
            <li class="page-item"><a class="page-link" href="{{$orders->nextPageUrl()}}">下一页</a></li>
          </ul>
        </nav>
      </div>
      {{--      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="orderlist">--}}
      {{--        <tbody>--}}
      {{--        <tr>--}}
      {{--          <th scope="col" width="30" align="center"><input type="checkbox" id="allcheck">--}}
      {{--          </th>--}}
      {{--          <th scope="col">论文题目</th>--}}
      {{--          <th scope="col" width="130">系统名称</th>--}}
      {{--          <th scope="col" width="75">状态</th>--}}
      {{--          <th scope="col" width="70">检测结果</th>--}}
      {{--          <th scope="col" width="168">提交日期</th>--}}
      {{--          <th scope="col" width="100">操作</th>--}}
      {{--        </tr>--}}
      {{--        @foreach($orders as $order)--}}
      {{--          <tr>--}}
      {{--            <td align="center"><input type='checkbox' name='delete' value='{{$order->id}}'/></td>--}}
      {{--            <td>{{$order->title}}</td>--}}
      {{--            <td align="center">{{ $order->category->name }}</td>--}}
      {{--            <td align="center">{{\App\Models\Enum\OrderEnum::getStatusName($order->status)}}</td>--}}
      {{--            <td align="center">{{ $order->rate }}</td>--}}
      {{--            <td align="center">{{$order->created_at}}</td>--}}
      {{--            @if($order->status==0)--}}
      {{--              <td align="center"><a href='{{route('orders.show',$order)}}' class="bbtn">支付</a></td>--}}
      {{--            @elseif($order->status==4)--}}
      {{--              <td align="center"><a href='{{route('orders.view-report',$order)}}' class="bbtn">查看报告</a></td>--}}
      {{--            @else--}}
      {{--              <td align="center"><a href='javascript:;' class="bbtn">-</a></td>--}}
      {{--            @endif--}}
      {{--          </tr>--}}
      {{--        @endforeach--}}

      {{--        <tr>--}}
      {{--          <td colspan="2" align="left">&ensp;<a class="rbtn" id="del_item">删除</a></td>--}}
      {{--          <td colspan="5" align="right">--}}
      {{--            共{{$orders->lastPage()}}页--}}
      {{--            <span>共{{$orders->total()}}条</span>--}}
      {{--            <span><a href="{{$orders->previousPageUrl()	}}">上一页</a></span>--}}
      {{--            <span>--}}
      {{--              @for($i=1;$i<=$orders->lastPage();$i++)--}}
      {{--                @if($i==$orders->currentPage())--}}
      {{--                  <span>&nbsp;</span><a style="color: red;" href='{{$orders->url($i)}}'>{{$i}}</a><span>&nbsp;</span>--}}
      {{--                  <span>&nbsp;</span>--}}
      {{--                @else--}}
      {{--                  <span>&nbsp;</span><a href='{{$orders->url($i)}}'>{{$i}}</a><span>&nbsp;</span><span>&nbsp;</span>--}}
      {{--                @endif--}}
      {{--              @endfor--}}
      {{--            </span>--}}
      {{--            <span><a href="{{$orders->nextPageUrl()}}">下一页</a></span>--}}
      {{--          </td>--}}
      {{--        </tr>--}}

      {{--        </tbody>--}}
      {{--      </table>--}}
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
  <script>
    $(function () {
      setTimeout(() => {
        window.location.reload();
      }, 120000);
      $('.navbar>div').removeClass('container').addClass('container-fluid')
      $('#headerlw').addClass('curfont')
      // 全选
      $('#allcheck').click(function () {
        $("input[name='delete']").prop("checked", this.checked);
      })
      // 单选
      let single = $("input[name='delete']")
      single.click(function () {
        $("#allcheck").prop("checked", single.length == single.filter(":checked").length ? true : false);
      });
      $('#del_item').click(function () {
        // 判断是否至少选择一项
        var checkedNum = $("input[name='delete']:checked").length;
        if (checkedNum == 0) {
          swal('请最少选择一项删除!')
          return
        }
        // 选择后状态
        swal({
          title: "您确认要删除数据?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then(willDelete => {
          if (willDelete) {
            var valuelist = [];
            $("input[name='delete']:checked").each(function () {
              var inputval = $(this).val()
              valuelist.push(inputval);
            });
            axios.delete('{{route('orders.destroy')}}', {
              data: {
                ids: valuelist
              }
            }).then(res => {
              swal('删除成功!')
              location.reload()
            })
          }
        })
      })
    })
  </script>
@stop
