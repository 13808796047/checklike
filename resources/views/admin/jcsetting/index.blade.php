<div class="card">
  <div class="card-body">
    <form id="jcsetting-form" method="POST" action="{{ route('admin.jcsetting.update') }}">
      <div class="card-text my-2">
        @csrf
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" id="customRadioInline1" {{$type=='ai'?'checked':''}} name="type"
                 class="custom-control-input"
                 value="ai">
          <label class="custom-control-label" for="customRadioInline1">AI</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" id="customRadioInline2" {{$type=='baidu'?'checked':''}} name="type"
                 class="custom-control-input"
                 value="baidu">
          <label class="custom-control-label" for="customRadioInline2">百度</label>
        </div>

      </div>
      <input type="submit" class="btn btn-primary" value="提交">
    </form>
  </div>
</div>
<script>
  Dcat.ready(function () {
    // ajax表单提交
    $('#jcsetting-form').form({

      success: function (data) {
        // data 为接口返回数据
        if (!data.status) {
          Dcat.error(data.message);

          return false;
        }

        Dcat.success(data.message);

        if (data.redirect) {
          Dcat.reload()
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
