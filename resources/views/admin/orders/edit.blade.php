<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">订单流水号：{{ $order->orderid }}</h3>
    <div class="box-tools">
      <div class="btn-group float-right" style="margin-right: 10px">
        <a href="/admin/orders" class="btn btn-sm btn-default"><i class="fa fa-list"></i> 列表</a>
      </div>
    </div>
  </div>
  <div class="box-body">

    <form class="form-horizontal" enctype="multipart/form-data" id="order-form" method="POST"
          action="{{ route('admin.orders.receved',$order) }}">
      @csrf
      <div class="form-group row">
        <label for="title" class="col-sm-1 col-form-label">标题</label>
        <div class="col-sm-3">
          <input type="text" readonly class="form-control" id="title" value="{{ $order->title }}">
        </div>
        <label for="title" class="col-sm-1 col-form-label">作者</label>
        <div class="col-sm-3">
          <input type="text" readonly class="form-control" id="title" value="{{ $order->writer }}">
        </div>
        <label for="title" class="col-sm-1 col-form-label">字数</label>
        <div class="col-sm-3">
          <input type="text" readonly class="form-control" id="title" value="{{ $order->words }}">
        </div>
      </div>
      <div class="form-group row">
        <label for="title" class="col-sm-1 col-form-label">价格</label>
        <div class="col-sm-3">
          <input type="text" readonly class="form-control" id="title" value="{{ $order->price }}">
        </div>
        <label for="rate" class="col-sm-1 col-form-label">重复率</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" name="rate" id="rate" value="{{ $order->rate }}">
        </div>
        <label for="title" class="col-sm-1 col-form-label">字数</label>
        <div class="col-sm-3">
          <select name="status" id="" class="form-control">
            <option value="0" {{ $order->status==0?'selected':'' }} }}>待支付</option>
            <option value="1" {{ $order->status==1?'selected':'' }} }}>待检测</option>
            <option value="2" {{ $order->status==2?'selected':'' }} }}>排队中</option>
            <option value="3" {{ $order->status==3?'selected':'' }} }}>检测中</option>
            <option value="4" {{ $order->status==4?'selected':'' }} }}>检测完成</option>
            <option value="5" {{ $order->status==5?'selected':'' }} }}>暂停</option>
            <option value="6" {{ $order->status==6?'selected':'' }} }}>取消</option>
            <option value="7" {{ $order->status==7?'selected':'' }} }}>已退款</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label for="title" class="col-sm-1 col-form-label">支付方式</label>
        <div class="col-sm-3">
          <input type="text" readonly class="form-control" id="title" value="{{ $order->pay_type }}">
        </div>
        <label for="title" class="col-sm-1 col-form-label">支付金额</label>
        <div class="col-sm-3">
          <input type="text" readonly class="form-control" id="title" value="{{ $order->pay_price }}">
        </div>
        <label for="title" class="col-sm-1 col-form-label">支付时间</label>
        <div class="col-sm-3">
          <input type="text" readonly class="form-control" id="title" value="{{ $order->date_pay }}">
        </div>
      </div>
      <div class="form-row">
        <label for="title" class="col-sm-1 col-form-label">论文</label>
        <div class="col-sm-3">
          <a class="btn btn-danger" href="{{ $order->paper_path }}" target="_blank">下载</a>(订单支付后才能下载论文)
        </div>
        <label for="title" class="col-sm-1 col-form-label">实际路径</label>
        <div class="col-sm-7">
          <a>{{ $order->paper_path }}</a>
        </div>

      </div>

      <div class="form-row mt-3 mb-3">
        <label for="file" class="col-sm-1 col-form-label">上传</label>
        <div class="col-sm-3">
          <input type="file" class="form-control" name="file" id="file">
        </div>
        <label for="title" class="col-sm-1 col-form-label">论文</label>
        <div class="col-sm-3">
          <a class="btn btn-danger" href="{{ route('admin.orders.download_report',$order) }}" target="_blank">下载</a>(订单支付后才能下载论文)
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-primary" id="btnSubmit">提交</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script !src="">
  Dcat.ready(function () {
    // ajax表单提交

    $('#order-form').form({

      success: function (data) {
        // data 为接口返回数据
        if (!data.status) {
          Dcat.error(data.message);

          return false;
        }

        Dcat.success(data.message);

        if (data.redirect) {
          Dcat.reload(data.redirect)
        }

        // 中止后续逻辑（默认逻辑）
        return false;
      },
      error: function (response) {
        // 当提交表单失败的时候会有默认的处理方法，通常使用默认的方式处理即可
        var errorData = JSON.parse(response.responseText);

        if (errorData) {
          Dcat.error(errorData.message);
        } else {
          console.log('提交出错', response.responseText);
        }

        // 终止后续逻辑执行
        return false;
      },
    });

  });
</script>
