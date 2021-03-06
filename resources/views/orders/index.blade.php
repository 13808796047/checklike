@extends('layouts.app')
@section('title', '检测报告')
@section('styles')
  <link rel="stylesheet" href="{{asset('asset/css/check.css')}}">
  <style>
    .curfont {
      font-size: 16px;
    }
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
    #page {
            color: #666;
            text-align: center;
    }

    #page li {
            display: inline-block;
            min-width: 30px;
            height: 28px;
            cursor: pointer;
            color: #666;
            font-size: 13px;
            line-height: 28px;
            background-color: #f9f9f9;
            border: 1px solid #dce0e0;
            text-align: center;
            margin: 0 4px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .xl-nextPage,
        .xl-prevPage {
            width: 60px;
            color: #0073A9;
            height: 28px;
        }

        #page li.xl-disabled {
            opacity: .5;
            cursor: no-drop;
        }

		#page li.xl-disabled:hover{
			background-color: #f9f9f9 !important;
            border: 1px solid #dce0e0 !important;
			color: #666 !important;
		}

        #page li.xl-active {
            background-color: #3490dc;
            border-color: #3490dc;
            color: #FFF
        }

		#page li:hover{
			background-color:  #3490dc !important;
            border-color: #0073A9;
            color: #FFF
		}

		 #page li.xl-jumpText {
		    background-color: rgba(0,0,0,0);
			border-color: rgba(0,0,0,0);
			opacity: 1;
		}

		#page li.xl-jumpText:hover{
			background-color: rgba(0,0,0,0) !important;
			border-color: rgba(0,0,0,0) !important;
		}

		#page li.xl-jumpButton{
			padding: 0 5px;
		}

		#xlJumpNum {
			width: 35px;
			margin: 0 3px;
		}
		input::-webkit-outer-spin-button,input::-webkit-inner-spin-button{
			-webkit-appearance: none !important;
		}
		input[type="number"]{
			-moz-appearance:textfield;
		}
  </style>
@stop
@section('content')

  <div class="container" style="margin:18px auto">
  <div class="grid grid-cols-12 gap-4">
    <div class="col-span-12 p-4" style="box-shadow: 0 0 6px rgba(0, 0, 0, 0.3);background:#fff;min-height:calc(100vh * 0.81);">
      <table class="table table-hover table-sm text-center">
        <thead class="thead-dark">
        <tr>
          <th scope="col"><input type="checkbox" id="allcheck"></th>
          <th scope="col">论文题目</th>
          <th scope="col" style="width:230px;">系统名称</th>
          <th scope="col" style="width:117px;">状态</th>
          <th scope="col" style="width:117px;">检测结果</th>
          <th scope="col" style="width:249px;">提交日期</th>
          <th scope="col" style="width:110px;">操作</th>
        </tr>
        </thead>
        <tbody>

        @foreach($orders as $order)
          <tr>
            <td><input type='checkbox' name='delete' value='{{$order->id}}'/></td>
            <td style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;word-break: break-all;max-width: 160px;">{{$order->title}}</td>
            <td style="width:230px;">{{ $order->category->name ?? '' }}</td>
            <td style="width:117px;">{{\App\Models\Enum\OrderEnum::getStatusName($order->status)}}</td>
            <td style="width:117px;">
            @if($order->rate==0.00)
            -
            @else
            {{ $order->rate }}%
            @endif
            </td>
            <td style="width:249px;">{{$order->created_at}}</td>
            @if($order->status==0)
              <td style="width:110px;"><a href='{{route('orders.show',$order)}}' class="bbtn" style="color:#fff;background:#3490dc;">支付</a></td>
            @elseif($order->status==4)
              <td style="width:110px;"><a href='{{route('orders.view-report',$order)}}' class="bbtn" style="color:#fff;background:#3490dc;">查看报告</a></td>
            @else
              <td style="width:110px;"><a href='javascript:;' class="bbtn" style="color:#fff;background:#3490dc;">-</a></td>
            @endif
          </tr>
        @endforeach
        </tbody>
      </table>
      @if($orders->total()==0)
      <div style="text-align:center;">暂无订单信息，<a style="cursor:pointer;color: #1E90FF;" href="/categories/1">点击去查重</a></div>
      @else
      @endif
      <div class="flex justify-between">

        <a class="inline-block text-white py-2 px-4" id="del_item"><span style="background: red;
    padding: 5px 10px;">删除</span></a>
        <div style="display:flex;align-items:center;">
        <span class="p-2">共{{$orders->total()}}条</span>
        <div id="page"></div>
        </div>
      </div>

      <div style="margin-top: 10px; font-size: 13px; color: rgb(105, 105, 105); cursor: pointer; display: none;" id="Bindmodel"><span style="background:rgb(0, 189, 42);padding:2px 5px;color:#FFF">提示</span>&nbsp;点击<font color="#0000ff" id="isBindPhonetip">绑定手机号</font>，可将之前用手机号提交的查重订单同步到此账号下，如需帮助请 <font color="#0000ff" id="lxkfimg">联系客服</font>。</div>
    </div>

    </div>

  </div>
@stop
@section('scripts')
<script type="text/javascript" src="{{ asset('asset/js/pagination.js') }}"></script>
  <script>
      $(document).ready(function () {
      //手机号不存在
      var isbindPhone = {!!Auth::user()!!}
      if(!isbindPhone.phone){
        console.log("cunz")
        $("#Bindmodel").css("display","block")
      }else{
        console.log("no")
        $("#Bindmodel").css("display","none")
      }
      $("#isBindPhonetip").click(function(){
        $("#bindTitle").modal("show")
      })

      $("#lxkfimg").click(function(){
        $.dialog({
          title:"",
          closeIcon: true,
          useBootstrap: false,
          boxWidth: '300px',
          // content:` <img src="https://www.checklike.com/images/qrcode/sz-work.png" style="width:171px;height:171px;display:block;margin:0 auto;">
          // <div style="color:#696969;text-align:center;margin:5px 0;font-size:13px;">微信扫一扫，与客服在线沟通</div>
          // `,
          content:" <img src=\"https://www.checklike.com/images/qrcode/sz-work.png\" style=\"width:171px;height:171px;display:block;margin:0 auto;\">\n          <div style=\"color:#696969;text-align:center;margin:5px 0;font-size:13px;\">\u5FAE\u4FE1\u626B\u4E00\u626B\uFF0C\u4E0E\u5BA2\u670D\u5728\u7EBF\u6C9F\u901A</div>\n          "
        });
      })








      var last_page={{$orders->lastPage()}}

      var current_page = {{$orders->currentPage()}}
      let a =new Paging('page', {
        nowPage: current_page, // 当前页码
        pageNum: last_page, // 总页码
        buttonNum: 7, //要展示的页码数量
        canJump: 0,// 是否能跳转。0=不显示（默认），1=显示
        showOne: 1,//只有一页时，是否显示。0=不显示,1=显示（默认）
        callback: function (num) { //回调函数
          window.location.href = "/orders?page=".concat(num);
        }
    })

      setTimeout(function(){
        window.location.reload();
      }, 120000);
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
          toastr.error('请最少选择一项删除');
          return
        }
        // 选择后状态
      $.confirm({
        title: '提示',
        content: '您确认要删除数据?',
        buttons: {
            ok: {
                text: '确认',
                btnClass:  'btn-danger',
                action: function() {
                  var valuelist = [];
                  $("input[name='delete']:checked").each(function () {
                  var inputval = $(this).val()
                  valuelist.push(inputval);
                });
                axios.delete('{{route('orders.destroy')}}', {
                data: {
                  ids: valuelist
                }
                }).then(function(res){
                  toastr.success('删除成功');
                  location.reload()
                })
              }
            },
            cancel: {
                text: '取消',
                btnClass: 'btn-info'
            }
        }
      });
    })
  })
  </script>
@stop
