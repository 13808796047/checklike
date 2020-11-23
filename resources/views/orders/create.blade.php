@extends('layouts.app')
@section('title', '创建订单')
@section('styles')
  <link href="{{asset('asset/css/jqcxcalendar.css')}}" rel="stylesheet"/>
  <style>
    .selected {
      display: block;
    }

    .curfont {
      font-size: 16px;
    }

    #newelement input {
      border: 1px solid;
      margin-right: 10px;
    }
    #catergatya li a:visited{
      color:black;
    }
    .isusergroup{
      text-decoration: line-through;
    }
    .newul{
      display:flex;
      margin-bottom:0 !important;
      align-items:center;
    }
    .newul li{
      margin:0 15px;
    }
    .newul li a{
      color:#fff;
    }
    .ambtn{
      border-radius: 16px;
      border: 1px solid #fff;
      padding: 5px 13px;
    }
    a:hover{
      text-decoration:none ;
    }
  </style>
@stop
@section('content')
  <!-- alert弹框 -->
  <div class="modal fade bd-example-modal-sm" id="alertbot" tabindex="-1" role="dialog"
       aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header" style="padding:7px;">
          <h5 class="modal-title" id="exampleModalLabel">提示</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding:0;margin:0;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="model-body-container"></p>
        </div>
      </div>
    </div>
  </div>
  <!-- alert弹框结束 -->
  <!-- 提交弹框款 -->
  <div class="modal fade bd-example-modal-sm" id="submitAlertModal" tabindex="-1" role="dialog"
    aria-labelledby="submitAlertModalLabel" aria-hidden="true" data-backdrop="static" >
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-body" style="text-align:center;">
          <div style="padding:20px 0">文件解析中，请稍后...</div>
        </div>
      </div>
    </div>
  </div>
  <!-- 二维码弹窗 -->
  <!-- 二维码弹窗结束 -->
  <div id="header1">
     <nav id="navigation" class="navbar scrollspy affix" style="position: static;">
				<div class="container">
					<div class="navbar-brand" style="width:25%;">
						<a href="javascript:void(0)" onclick="window.location.href='/'"><img src= "{{ asset('asset/images/checklike.png') }}" alt=""></a>
					</div>
					<ul class="newul" style="flex:1;width:75%;">
						<li><a href="javascript:void(0)" onclick="window.location.href='/'" class="smooth-scroll">网站首页</a></li>
                        <li><a href="/categories/1" class="smooth-scroll">论文查重</a></li>
                                    <li><a href="/categories/4" class="smooth-scroll">免费查重</a></li>
                                    <li><a href="/ai_rewrite" class="smooth-scroll">自动降重</a></li>
                                    <li><a href="/orders" class="smooth-scroll">报告下载</a></li>
                                    <li class="ambtn"><a href="/users/{{Auth::user()->id}}">个人中心</a></li>
            <li class="ambtn"><a class="logout" href="javascript:;">退出</a></li>
            					</ul>
          </div></nav>
  </div>
  <div class="container" style="margin:18px auto">
    <div class="grid grid-cols-12 gap-4">

      <div class="col-span-9 p-4" style="box-shadow: 0 0 6px rgba(0, 0, 0, 0.3);background:#fff;">
         <!-- 新添加 -->
         <ul class="nav nav-tabs" id="catergatya" style="margin-bottom:18px;">
           <li class="nav-item">
           <a class="nav-link" href="/categories/1">初稿查重</a>
           </li>
           <li class="nav-item">
            <a class="nav-link" href="/categories/2">维普查重</a>
           </li>
           <li class="nav-item">
            <a class="nav-link" href="/categories/4">万方查重</a>
           </li>
           <li class="nav-item">
           <a class="nav-link" href="/categories/3">知网查重</a>
           </li>
           <li class="nav-item">
           <a class="nav-link" href="/categories/5">PaperPass</a>
           </li>
          </ul>



      <!-- 添加结束 -->
        <ul class=" category">
          @foreach($categories as $item)
            <li class="float-left position-relative mr-3 "
                data-id="{{ $item->id }}" data-sintro="{{ $item->sintro }}">
              <i class="position-absolute hidden"><img src="{{ asset('asset/images/icon-y.png') }}"
                                                       style="width:100%;height:90px"
                                                       alt=""></i>
              <a href="javascript:;" class="icon-img checkpro-1">
                <img src="{{$item->sys_logo}}" alt=""
                     style="width:100%;height:90px">
              </a>
              <p class="text-center text-xs py-2">

                <span>{{$item->name}}</span>
                <br>
                @if(auth()->user()->user_group==0)
                <span>
                <span class="text-danger">{{$item-> price }}</span>
                <span>/{{\App\Models\Category::$priceTypeMap[$item->price_type]}}</span>
                </span>
                @else
                <span class="isusergroup">
                <span>{{$item-> price }}</span>
                <span>/{{\App\Models\Category::$priceTypeMap[$item->price_type]}}</span>
                </span>
                @endif

                <br>
                @switch(auth()->user()->user_group)
                  @case(3)
                  <span>VIP价:</span>
                  <b class="text-danger">{{  $item->vip_price  }}</b>
                  <span>/{{\App\Models\Category::$priceTypeMap[$item->price_type]}}</span>
                  @break
                  @case(2)
                  <span>代理价:</span>
                  <b class="text-danger">{{ $item->agent_price2 }}</b>
                  <span>/{{\App\Models\Category::$priceTypeMap[$item->price_type]}}</span>
                  @break
                  @case(1)
                  <span>代理价:</span>
                  <b class="text-danger">{{ $item->agent_price1 }}</b>
                  <span>/{{\App\Models\Category::$priceTypeMap[$item->price_type]}}</span>
                  @break
                @endswitch
              </p>
            </li>

          @endforeach
        </ul>
      <!-- <form action="{{route('orders.store')}}" method="post" id="form"> -->

        <form>
        <!-- @csrf -->
          <input type="hidden" name="cid" id="cid">
          <input type="hidden" name="from" value="wp-pc">
          <input type="hidden" name="file_id" value="" id="hidden_form_id">
          <input type="hidden" name="type" value="content" id="hideen_type">
          <div>
              <div class="input-group" id="sintroTips" style="margin:13px 0;font-size:13px;">

              </div>
          </div>
          <div>
            <div class="input-group mt-3">
              <div class="input-group-prepend">
                <span class="input-group-text">论文标题</span>
              </div>
              <input id="title" type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                     placeholder="必须填写，在检测报告中显示" value="{{ old('title') }}"
              >
              @error('title')
              <span class="invalid-feedback" role="alert" style="display:block;">
                                        <strong>{{ $message }}</strong>
               </span>
              @enderror
            </div>
          </div>
          <div class="form-group">
            <div class="input-group mt-3">
              <div class="input-group-prepend">
                <span class="input-group-text">论文作者</span>
              </div>
              <input id="writer" type="text" name="writer" class="form-control @error('writer') is-invalid @enderror"
                     placeholder="必须填写，在检测报告中显示" value="{{ old('writer') }}"
              >
              @error('writer')
              <span class="invalid-feedback" role="alert" style="display:block;">
                                        <strong>{{ $message }}</strong>
               </span>
              @enderror
            </div>
          </div>
          <div class="form-group" style="display:none" id="isfbtime">
            <div class="input-group mt-3">
              <div class="input-group-prepend">
                <span class="input-group-text">发表时间</span>
              </div>
              <input id="element_id" type="text" name="element_id"
                     class="form-control @error('writer') is-invalid @enderror">
            </div>
          </div>
          <div>
            <span style="display:none;color:red;" id="riqiture">请选择正确日期</span>
          </div>
          <div class="mt-3">
            <ul class="nav nav-tabs tab-list" role="tablist" id="navbarText">
              <li class="nav-item">
                <a class="nav-link active list-fw fw-a" data-contenttype="file" data-toggle="tab"
                   href="#contentfile">上传文档</a>
              </li>
              <li class="nav-item">
                <a class="nav-link list-fw" data-contenttype="text" data-toggle="tab" href="#contenttext">粘贴文本</a>
              </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
              <div id="contentfile" class="tab-pane active">
                <br>
                <p class="text-xs">
                  <img class="inline-block" src="http://check.lianwen.com/portal/weipu/static2/images/icon-01.png"
                       alt="">
                  系统在检测时会分析论文的前后文关系， 所以请您提交论文的全部内容，如果是非全文的检测将不能保证检测的准确性。
                </p>
                <div class="custom-file my-2">
                  <input type="file" class="custom-file-input @error('file') is-invalid @enderror" id="customFile"
                         lang="cn"
                  >
                  @error('file')
                  <span class="invalid-feedback" role="alert" style="display: block">
                                        <strong>{{ $message }}</strong>
               </span>
                  @enderror
                  <label class="custom-file-label" for="customFile" data-browse="选择文件"></label>
                  <div style="display:flex;">
                    <div class="progress" style="width:30%;margin-top:15px;display:none" id="progress_bar">
                      <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                           aria-valuemax="100" style="width: 0%;" id="progress_bar_line">
                      </div>
                    </div>
                    <div style="margin-top: 11px;padding-left: 30px;display:none;" id="progress_text">正在上传</div>
                  </div>
                </div>
                <p class="text-xs">仅支持docx和txt格式，最大支持15M</p>
              </div>
              <div id="contenttext" class="tab-pane fade">
                <br>
                <p class="text-xs">
                  <img class="inline-block" src="http://check.lianwen.com/portal/weipu/static2/images/icon-01.png"
                       alt="">
                  系统在检测时会分析论文的前后文关系， 所以请您提交论文的全部内容，如果是非全文的检测将不能保证检测的准确性。
                </p>
                <div class="form-group">
                  <textarea id="content" class="form-control @error('content') is-invalid @enderror" name="content"
                            placeholder="输入论文内容不少于1000字"
                            rows="10" value="{{ old('content') }}"></textarea>
                  @error('content')
                  <span class="invalid-feedback" role="alert" style="display: block">
                                        <strong>{{ $message }}</strong>
               </span>
                  @enderror
                </div>
                <p id="words" class="text-right">共输入<span class="text-red-500">0</span>字</p>
              </div>
            </div>
          </div>
          <!-- <input type="submit" value="提交论文" class="btn btn-danger my-4 px-8"> -->
          <input type="button" value="提交论文" class="btn btn-danger my-4 px-8 rounded font-bold" id="tosubmit">
          <button class="btn btn-danger" type="button" disabled style="display:none;margin:20px 0" id="submitBtn">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            正在提交
          </button>
        </form>
      @if(auth()->user()->user_group==99)
        <!-- 批量上传 -->
          <div id="newelement" style="display:none;">
            <div id="newelement_container">
            </div>
            <div id="batchBtn" style="width: 100px;background: #3490dc;color: #fff;text-align: center;margin: 0 auto;">
              批量提交
            </div>
          </div>
          <div id="paymsg" style="display:none;">
            <p>订单确认</p>
            <div id="paymsg_container">
            </div>
            <div style="width:150px;background:red;color:#fff;text-align:center;" id="toSecup">再次上传</div>
          </div>
          <div style="display:flex;" id="manyupload">
            批量上传<input type="file" id="customFiles" style="width:70%;border:1px solid" lang="cn" multiple>
          </div>
          <!-- 批量上传结束 -->
        @endif
      </div>
      <div class="col-span-3 p-4" style="box-shadow: 0 0 6px rgba(0, 0, 0, 0.3);background:#fff">
        <b>1、检测结果是否准确？</b>
        <p>如果你们学校也是用维普检测，那结果是一致的。同一个的系统、同样的比对库、同样的算法，所以只要在本系统提交的内容和学校的一致，那检测结果是一致的。</p>
        <b>2、检测需要多少时间？</b>
        <p>正常情况，维普检测需要10分钟左右，高峰期可能会延迟，但不会超过1个小时，如果长时间未出结果请联系客服微信：cx5078解决。</p>
        <b>3、论文上传之后安全吗？</b>
        <p>本系统有明确的条文规定并遵守严格的论文保密规定，对所有用户提交的送检文档仅做检测分析，绝不保留全文，承诺对用户送检的文档不做任何形式的收录和泄露。</p>
        <b>4、提交以后能不能退款？</b>
        <p>此系统一旦提交，系统开始检测后，即产生消费，无法退款！</p>
        <b>5、检测内容范围？</b>
        <p>系统不检测文章中的封面、致谢、学校(需要替换成"X")等个人信息，请在提交前自己删除，若提交后由系统自动删除时出现的任何问题责任自负！</p>
        <b>6、检测时作者需要填吗？</b>
        <p>在提交检测的文章中，引用了一些内以前自己所写的内容并且被小论文系统文献库收录，需要在此次检测中排除这些；则会有“去除本人已发表文献复制比”的结果。</p>
      </div>
    </div>
  </div>
@stop
@section('scripts')
  <script type="text/javascript" src="{{ asset('asset/js/jquery-cxcalendar.js') }}"></script>
  <script>
    $(() => {

      $("#catergatya li a").each(function(){
        let currenthref = $(this).attr("href")
        if(currenthref == window.location.pathname){
          $(this).addClass("active")
        }
      })

      // $("#headerfree").css("display","none")
      // $("#headerfree1").css("display","block")
      let set = new Set();
      let name = '';
      var oneid = ''
      $('.category>li:first-child i').addClass('selected')
      $('#cid').val($('.category>li:first-child').data('id'))

      let datas = {!!$categories!!}
      $("#sintroTips").html(datas[0].sintro)



      $('.category>li').click(function () {
        $(this).siblings().children('i').removeClass('selected')
        $(this).children('i').addClass('selected')
        $('#cid').val($(this).data('id'))
        $("#sintroTips").html($(this).data('sintro'))
        if ($(this).data('id') == 6|| $(this).data('id') == 15) {
          $('#element_id').val(getNowFormatDate())
          $('#isfbtime').css('display', 'block')
        } else {
          $('#isfbtime').css('display', 'none')
          $('#element_id').val('')
        }
      })
      $('#content').bind('input propertychange', (e) => {
        $('#words span').html(e.target.value.length)
      })
      //  //时间选择
      $('#element_id')[0].dataset.startDate = '2000/1/1'
      $('#element_id')[0].dataset.endDate = getNowFormatDate()
      $('#element_id').cxCalendar();

      function getNowFormatDate() {
        var date = new Date();
        var seperator1 = "-";
        var year = date.getFullYear();
        var month = date.getMonth() + 1;
        var strDate = date.getDate();
        if (month >= 1 && month <= 9) {
          month = "0" + month;
        }
        if (strDate >= 0 && strDate <= 9) {
          strDate = "0" + strDate;
        }
        var currentdate = year + seperator1 + month + seperator1 + strDate
        return currentdate;
      }
      //   //时间选择结束
      //多文件上传
      $('#customFiles').change(function (e) {
        $('#newelement').css('display', 'block');
        //console.log(e,'312312');

        // $('.custom-file-label').html(e.target.files[0].name)
        var file = e.target.files;
        console.log(file, 123123)

        $('#progress_bar').css("display", "block");
        $('#progress_text').css('display', "block");
        var index = 0;
        var array = [];
        for (let i = 0; i < file.length; i++) {
          let item = file[i];
          name += item.name;
          var formData = new FormData();
          formData.append("file", item);  //上传一个files对
          axios.post('{{ route('files.store') }}', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          }).then(res => {
            array.push({
              'file_id': res.data.data.id, 'from': 'pc', 'type': 'file',
              'content': ''
            });
            index++;
            console.log(res, 'fsadf')
            let obj = {!!$categories!!}
            // let obj =[{id:3,name:'维普大学生版'},{id:4,name:'维普研究生版'},{id:5,name:'维普编辑部版'},{id:6,name:'维普职称版'}]
            console.log(obj, Object.prototype.toString.call(obj));
            console.log(obj, 3123)
            var option = ""
            for (let i = 0; i < obj.length; i++) {
              var id = obj[i].id;
              var name = obj[i].name;
              option += `<option value=${id} class='options'>${name}</option>`
            }
            console.log(option, "xixixifsaddjfa")
            var file_id = res.data.data.id;
            set.add(file_id);
            $("#hidden_form_id").val(file_id);
            $("#hideen_type").val('file');
            $('#progress_bar_line').css("width", "100%")
            $('#progress_bar_line').html('上传成功')
            $('#progress_text').html("上传成功");
            // alert('上传成功')
            $("#newelement_container").append(`<div style='margin-bottom:10px;'><span style="margin-right:10px">订单${index}</span><input id='title' type='text' name='title' value=${item.name}>论文题目<input type='text' class='titlec' value=${item.name}>论文作者<input type='text' class='authorc' value='匿名'>检测系统<select>${option}</select></div>`);
          }).catch(err => {
            console.log(err);
            index++;
            $('#progress_bar_line').css("width", "100%")
            $('#progress_text').html("不允许上传的文件类型");
            $("#newelement_container").append(`<div style='margin-bottom:10px'><span style="margin-left:10px">订单${index}<span><input id='title' type='text' name='title' value=${item.name}><span style="margin-left:10px;">上传失败，请选择正确格式</span>`);
          })
        }
        $('#batchBtn').click(_ => {
          $('#newelement').css('display', 'none')
          $('.titlec').each((index, ele) => {
            console.log(index, ele, 312321)
            array[index]['title'] = ele.value;
          })
          $('.authorc').each((index, ele) => {
            console.log(index, ele, 312321)
            array[index]['writer'] = ele.value;
          })
          $('select').each((index, ele) => {
            if (index + 1 > array.length) return;
            // array[index]['cid']=$("select").val();
            array[index]['cid'] = ele.value;
          })
          console.log(array, 312, 'fsdafa');
          $('#paymsg').css('display', 'block')
          for (let item of array) {
            axios.post('{{route('orders.store')}}', item).then(res => {

              if (res.status == 201) {
                var paymsg = res.data.data;
                $('#paymsg_container').append(`<div style='width: 602px;border: 1px solid;margin-bottom:20px;'><p>论文题目:${paymsg.title}</p><p>作者：${paymsg.writer}</p><p>字数:${paymsg.words}</p><p>价格:${paymsg.price}元</p></div>`)
              }

            }).catch(err => {
              $('#paymsg_container').append(`<div style='width: 602px;border: 1px solid;margin-bottom:20px;'><p>提交失败<p></div>`)
            })
          }
        })
        $('.custom-file-label').html(name);
        $('#manyupload').css('display', "none")
      });
      //多文件上传刷新
      $('#toSecup').click(function () {
        window.location.reload();
      })
      //单文件上传
      $('#customFile').change(function (e) {
        $('.custom-file-label').html(e.target.files[0].name)
        $("#tosubmit").val("文件上传中")
        $('#tosubmit').attr("disabled", true);
        var file = e.target.files[0];
        var formData = new FormData();
        formData.append("file", file);  //上传一个files对
        axios.post('{{ route('files.store') }}', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }).then(res => {
          console.log(res, 3123123)
          $('#tosubmit').attr("disabled", false);
          $("#tosubmit").val("提交论文")
          $('#model-body-container').html('上传成功')
          $('#alertbot').modal('show')
          setTimeout("$('#alertbot').modal('hide')", 1000);
          oneid = res.data.data.id;
        }).catch(err => {
          $('#model-body-container').html('上传失败，仅支持docx和txt格式，最大支持15M')
          $('#alertbot').modal('show')
          setTimeout("$('#alertbot').modal('hide')", 2000);
          $('#tosubmit').attr("disabled", true);
          $("#tosubmit").val("提交论文")
        })
      })
      // $("form").submit(function(e){
      // <s></s>
      // });
      //文件上传提交论文
      $("#tosubmit").click(function () {
        if ($('#cid').val() == "6") {
          let riqi = $('#element_id').val();
          let seperator = "-";
          let endriqi = riqi.split(seperator);
          if (endriqi.length != 3) {
            $("#riqiture").css("display", "block")
            return false;
          } else {
            $("#riqiture").css("display", "none")
          }
        }
        if ($('#title').val() == '') return false;
        if ($('#writer').val() == '') return false;
        // 判断选择谁
        if ($('#contentfile').hasClass('active')) {
          if (oneid == '') return false;
          $('#tosubmit').css("display", "none");
          $('#submitBtn').css("display", "block")
          $("#submitAlertModal").modal('show')
          axios.post('{{route('orders.store')}}', {
              cid: $('#cid').val(),
              from: 'pc',
              file_id: oneid,
              type: 'file',
              content: '',
              title: $('#title').val(),
              writer: $('#writer').val(),
              endDate: $('#element_id').val()
            }
          ).then(res => {
            console.log(res, 3123123)
            var order = res.data.data
            $("#submitAlertModal").modal('hide')
            location.href = '/orders/' + res.data.data.id
          }).catch(err => {
            console.log(err.response.status, 3112312312)
            if(err.response.status == 400){

            }
            alert('提交失败，请重试')
            $('#tosubmit').css("display", "block");
            $('#submitBtn').css("display", "none")
            $("#submitAlertModal").modal('hide')
          })
        } else {
          $('#tosubmit').css("display", "none");
          $('#submitBtn').css("display", "block");
          axios.post('{{route('orders.store')}}', {
              cid: $('#cid').val(),
              from: 'pc',
              type: 'content',
              // content: $('#content').val(),
              content:  $('#content').val().replace(/\n/g,'\r\n'),
              title: $('#title').val(),
              writer: $('#writer').val(),
              endDate: $('#element_id').val()
            }
          ).then(res => {
            console.log(res, 3123123)
            var order = res.data.data
            location.href = '/orders/' + res.data.data.id
          }).catch(err => {
            alert('提交失败，请重试')
            $('#tosubmit').css("display", "block");
            $('#submitBtn').css("display", "none")
          })
        }
      })
    })
  </script>
@stop
