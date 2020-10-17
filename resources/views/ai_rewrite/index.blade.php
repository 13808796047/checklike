@extends('layouts.app')

@section('title','智能查重')
@section('styles')
  <!-- <link href="https://css.lianwen.com/css/public_c.css?v=2018v1" type="text/css" rel="stylesheet"/>
  <link href="https://css.lianwen.com/css/index_2017.css" type="text/css" rel="stylesheet"/> -->
  <!-- <link rel="stylesheet" href="{{asset('asset/css/index.css')}}"> -->
@stop
@section('content')
  <!-- alert提示框 -->

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
          <p>剩余次数：{{ auth()->user()->jc_times}}<span style="color:#4876FF;margin-left:10px;" id="addjctimes">增加次数</span></p>

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
  <!-- 购买降重字数模态框 -->
  @auth
  <div class="modal fade bd-example-modal-sm" id="jctimeModal" tabindex="-1" role="dialog"
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
          <p>购买自动降重次数</p>
          <p style="margin: 6px 0;font-size: 11px;color: #F4A460;">(价格:1元/次)</p>
          <p>请输入购买次数<span style="padding:0 10px;" id="cutjctime">-</span><span style="border: 1px solid;padding: 3px;" id="curjctime">10</span><span style="padding:0 10px;" id="addjctime">+</span></p>
        </div>
        <div class="modal-footer">
          <p style="color:#4876FF;margin-right:25%;" id="freeadd">免费增加</p>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
          <button type="button" class="btn btn-primary" id="sureshop">确定</button>
        </div>
      </div>
    </div>
  </div>
  @endauth
  <!-- 购买降重字数模态框结束 -->
  <!-- 推荐弹框 -->
  @auth
  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="tjModal">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header" style="padding:5px 10px;border-bottom:0;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding:0;text-align:center;">
          <p style="font-weight: bold;font-size: 18px;">推荐注册，赠送自动降重次数</p>
          <p style="font-size: 13px;color: #FFA54F;">双方各送5次</p>
          <p style="margin:10px 0;">方式1：分享地址，邀请好友注册（适合电脑此操作）</p>
          <div style="display:flex;justify-content: center;">
            <p id="demo" style="border: 1px solid;padding: 0 10px;" >https://www.lianwen.com/zt/jc?uid={{auth()->user()->id}}</p>
            <p style="margin-left: 10px;background: red;color: #fff;padding: 0 10px;" class="btn" id="copybtn" >复制链接</p>
          </div>
          <p style="margin:10px 0;">方式2：微信扫码，邀请好友注册（适合手机操作）</p>
          <div style="display:flex;justify-content: center;" id="qrcode">

          </div>
          <p style="font-size: 13px;margin-top: 5px;">微信扫码分享</p>
        </div>
        <div class="modal-footer" style="border:none;display:block;font-size:13px;">
          <p>活动规则</p>
          <p>1、每推荐1名好友成功注册（微信登录或绑定手机号），推荐人和注册人各获得5次自动降重次数，获得的次数可叠加，无上限；</p>
          <p>2、所获得降重次数不可提现，仅用于使用自动降重服务时抵扣；</p>
          <p>3、严禁使用非法手段获取，对于问题账号本站有权撤销相应数据或封禁账号。</p>
        </div>
    </div>
  </div>
</div>
@endauth
  <!-- 推荐弹框结束 -->
    <!--左边导航-->
    <div class="main clearfix" id="jcafter">
      <div class="lbox fl">
      <p style="font-size: 20px;">请输入你要降重的内容。<span style="font-size:16px;color:#757575;">（最大支持1000字）</span></p>
      <textarea name="content" id="content"
        style="width:97%;height: 500px;padding:20px;box-sizing:border-box;font-size:20px;outline: none;border:1px solid #ddd;margin-top:20px"></textarea>
      @auth
      <p style="color:#696969">注：采用人工智能技术，实现自动降低论文查重率，降重结果仅供参考，如需更专业的人工论文降重服务请联系微信：cx5078</p>
      <div style="display:flex;align-items: center;justify-content: space-between;">
      <p style="background-color: #4876FF;display: inline;padding: 5px 20px;color:#fff;text-align: center;font-size:15px;"
        id="reduce">
        一键降重</p>
        <p style="float: right;font-size: 13px;padding-right: 30px;" id="words">当前输入<span>0</span>字</p>
      </div>

      @else
      <p style="color:#696969">注：采用人工智能技术，实现自动降低论文查重率，降重结果仅供参考，如需更专业的人工论文降重服务请联系微信：cx5078</p>
      <div style="display:flex;align-items: center;justify-content: space-between;">
      <p style="background-color: #4876FF;display: inline;padding: 5px 20px;color:#fff;text-align: center;font-size:15px;"
        id="noreduce">
        一键降重</p>
      </div>

      @endauth
      <div style="display: flex;justify-content: center;margin-top: 15px;">
      @auth
      <p>剩余次数:<span id="jc_time">{{ auth()->user()->jc_times}}</span></p><span style="color:#4876FF;margin-left: 10px;" id="shopjctime">增加次数</span>
      @endauth
    </div>
    </div>
    <!--右边内容-->
    <div class="rbox fr" style="min-height:900px;font-size:14px;">
      <div class="box">
        <b>1、工具说明</b>
        <p>本工具具有强大的自然语言语义分析能力，通过自主研发的中文分词、句法分析、语义联想和实体识别技术，结合海量行业语料，在不改变原文语义的情况下对原文进行替换和重组，从而达到降低文章重复率的效果。</p>
        <b>2、使用方法</b>
        <p>将需要降重的论文粘贴到输入框，点击“一键降重”即可，系统处理完成后会将删减过的文字以红色背景标出，新增文字为绿色背景。然后要将降重后的内容读一遍，修改通顺后插入到论文原来的位置即可。</p>
        <b>3、注意问题</b>
        <p>本工具一次最大支持1000字，10个段落以内，多个段落会导致降重失败。</p>
        <b>4、会不会记录我的论文</b>
        <p>本工具实时处理，所有内容均不保存数据库，用户需要自己保存结果，关闭页面后无法找回。</p>
        <b>5、专业的人工降重服务</b>
        <p>联系微信：13878811985</p>
        <div style="height:247px;"></div>
      </div>
    </div>
    </div>
    <!-- 降重成功后 -->
    <div style="padding: 21px; display: none;min-height:800px;" id="jclater">
    <div style="display: flex;">
      <!-- <div style="width: 50%;">
        <p style="font-size: 17px;font-weight: bold;">降重前</p>
        <textarea name="" id="content_after"
          style="width:100%;height: 550px;box-sizing: border-box;overflow-x:visible;border:1px solid #ccc;outline: none;"></textarea>
      </div>
      <div style="width: 50%;">
        <p style="font-size: 17px;font-weight: bold;">降重后</p>
        <textarea name="" id="content_later" style="width: 100%;height: 550px;border: none;outline: none;border:1px solid #ccc"
          readonly></textarea>
      </div> -->
      <table style="width:100%;">
        <tr>
            <td style="width:48%;">
              <div style="font-size:19px;font-weight:bold;margin-left:10px;">降重前</div>
              <div style="height:650px;overflow-y:auto;background:#fff;border: 1px solid #ddd;padding: 19px;margin-right:5px;" id="content_after">
              </div>
            </td>
            <td style="width:48%;">
              <div style="font-size:19px;font-weight:bold;margin-left:10px;">降重后</div>
              <div style="height:650px;overflow-y:auto;background:#fff;border: 1px solid #ddd;padding: 19px;margin-left:5px;" id="content_later">
              </div>
            </td>
        </tr>
      </table>
    </div>
    <p style="font-size: 13px;margin-top: 10px;text-align: center;">
      注：本工具是通过运用AI技术对原文进行降重，结果仅供参考，需要稍作调整让语句更通顺。如需高质量人工降重请联系微信：13878811985
    </p>
    <p style="background-color: #4876FF;padding: 5px 20px;color:#fff;text-align: center;margin:0 auto;width:100px;margin-top:16px;" id="againjc">
      再来一篇</p>
    <div style="display: flex;justify-content: center;margin-top: 15px;">
      <p>剩余次数:<span id="jc_timeend"></span></p>
      <span style="color:#4876FF;margin-left: 10px;" id="shopjctime">增加次数</span>
    </div>

  </div>
  <!-- 未登录模态框 -->
  <div class="modal fade " id="noLoginModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" >
    <div class="modal-dialog modal-dialog-centered " role="document" >
      <div class="modal-content">
          <div class="modal-header border-none">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <div class="modal-body">
        <ul class="nav nav-pills mt-4 d-flex justify-content-center" id="pills-tab" role="tablist">
            <li class="nav-item mr-4">
              <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                 aria-controls="pills-home" aria-selected="true" style="font-size:15px;">账号登录</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                 aria-controls="pills-profile" aria-selected="false" style="font-size:15px;">手机登录</a>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
              <div class="w-full">
                <form class="bg-white rounded px-4 pt-6">

                  <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">
                      用户名:
                    </label>
                    <input
                      class="appearance-none border rounded w-full py-2 px-3 mb-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      name="phone"
                      id="phone" type="text" placeholder="请输入手机号码" value="{{ old('phone') }}" style="font-size:14px;">


                  </div>
                  <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                      密码:
                    </label>
                    <input
                      class="appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                      name="password"
                      id="password" type="password" placeholder="请输入密码" value="{{ old('password') }}" style="font-size:14px;">

                  </div>
                  <div class="flex items-center justify-between my-2">
                    <button
                      class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 w-full px-4 rounded focus:outline-none focus:shadow-outline"
                      type="button" id="accountLogin" style="font-size:15px;">
                      登录
                    </button>
                  </div>

                </form>

              </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
              <div class="w-full">
                <form class="bg-white rounded px-4 pt-6">
                  <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                      手机号码:
                    </label>
                    <input
                      class="appearance-none border rounded w-full py-2 px-2 mb-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="mobile" type="text" placeholder="请输入手机号码">
                    <p class="text-red-500 text-xs italic "></p>
                  </div>
                  <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                      验证码:
                    </label>
                    <div class="d-flex justify-content-between">
                      <input
                        class="appearance-none border border-red-500 rounded   py-2 px-2  w-full mr-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="verification_code" type="text" placeholder="请输入短信验证码"/>
                      <input
                        class="bg-blue-500 hover:bg-blue-700 px-2 py-1  text-white font-bold rounded"
                        type="button" id="verificationCode" value="发送验证码">

                    </div>
                    <p class="text-red-500 text-xs italic "></p>
                  </div>
                  <div class="flex items-center justify-between my-4">
                    <button
                      class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 w-full px-4 rounded focus:outline-none focus:shadow-outline"
                      type="button" id="phoneLogin">
                      登录
                    </button>
                  </div>

                </form>

              </div>
            </div>
          </div>
          <p class="text-gray-500 text-xs px-8 d-flex justify-content-center">
            <a href="{{route('oauth',['type'=>'wechat'])}}" class="block mr-4">
              <svg t="1585367706568" class="icon" viewBox="0 0 1024 1024" version="1.1"
                   xmlns="http://www.w3.org/2000/svg" p-id="1112" width="24" height="24">
                <path
                  d="M347.729118 353.0242c-16.487119 0-29.776737 13.389539-29.776737 29.776737S331.241998 412.677596 347.729118 412.677596s29.776737-13.389539 29.776737-29.776737-13.289617-29.876659-29.776737-29.876659zM577.749415 511.800156c-13.689305 0-24.880562 11.091335-24.880563 24.880562 0 13.689305 11.091335 24.880562 24.880563 24.880562 13.689305 0 24.880562-11.191257 24.880562-24.880562s-11.191257-24.880562-24.880562-24.880562zM500.909446 412.677596c16.487119 0 29.776737-13.389539 29.776737-29.776737s-13.389539-29.776737-29.776737-29.776737c-16.487119 0-29.776737 13.389539-29.776737 29.776737s13.289617 29.776737 29.776737 29.776737zM698.455113 511.600312c-13.689305 0-24.880562 11.091335-24.880562 24.880562 0 13.689305 11.091335 24.880562 24.880562 24.880562 13.689305 0 24.880562-11.091335 24.880562-24.880562-0.099922-13.689305-11.191257-24.880562-24.880562-24.880562z"
                  fill="#00C800" p-id="1113"></path>
                <path
                  d="M511.601093 0.799375C229.12178 0.799375 0.000781 229.820453 0.000781 512.399688s229.021077 511.600312 511.600312 511.600312 511.600312-229.021077 511.600312-511.600312S794.180328 0.799375 511.601093 0.799375z m-90.229508 634.504294c-27.37861 0-49.361436-5.595628-76.839969-10.991413l-76.640125 38.469945 21.882904-65.948477c-54.957065-38.370023-87.73146-87.831382-87.73146-148.084309 0-104.318501 98.722873-186.554254 219.32865-186.554255 107.815769 0 202.34192 65.648712 221.327088 153.979703-6.994536-0.799375-13.989071-1.298985-21.083529-1.298985-104.118657 0-186.454333 77.739266-186.454332 173.564403 0 15.98751 2.498048 31.275566 6.794692 45.964091-6.794692 0.599532-13.689305 0.899297-20.583919 0.899297z m323.547228 76.839969l16.48712 54.757221-60.153006-32.874317c-21.882904 5.495706-43.965652 10.991413-65.848555 10.991413-104.318501 0-186.554254-71.344262-186.554255-159.175644 0-87.631538 82.135831-159.175644 186.554255-159.175644 98.523029 0 186.254489 71.444184 186.254488 159.175644 0.099922 49.461358-32.774395 93.227166-76.740047 126.301327z"
                  fill="#00C800" p-id="1114"></path>
              </svg>
            </a>
            <a class="block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800"
               href="{{route('register')}}">
              还没有账号?去注册
            </a>
          </p>
          <p style="height:30px;"></p>
        </div>
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
    $(() => {
      @auth
      $('#freeadd').click(function(){
        $('#tjModal').modal('show')
      })
      $('#freeadds').click(function(){
        $('#tjModal').modal('show')
      })
      //生成分享二维码
      var qrcode = document.getElementById('qrcode')

      /*也可以配置二维码的宽高等*/
       var qrcodeObj = new QRCode('qrcode', {
          text: 'http://www.lianwen.com/zt/jc?uid='+{{auth()->user()->id}},
          width: 120,
          height: 120,
          colorDark: '#000000', //前景色
          colorLight: '#ffffff',//背景色
          correctLevel: QRCode.CorrectLevel.H
      })
      toastr.options = {

        "closeButton": true, //是否显示关闭按钮

        "debug": true, //是否使用debug模式

        "showDuration": "1000",//显示的动画时间

        "hideDuration": "1000",//消失的动画时间

        "positionClass": "toast-center-center",//弹出窗的位置

        "timeOut": "1000", //展现时间

        "extendedTimeOut": "1000",//加长展示时间

        "showEasing": "swing",//显示时的动画缓冲方式

        "hideEasing": "linear",//消失时的动画缓冲方式

        "showMethod": "fadeIn",//显示时的动画方式

        "hideMethod": "fadeOut" //消失时的动画方式


      };

      //获取字数
      $("#content").bind('input',(e)=>{
        $('#words span').html(e.target.value.length)
      })
      //增加降重次数
      $("#shopjctime").click(function(){
        $("#jctimeModal").modal('show')
      })
      $("#addjctimes").click(function(){
        $('#exampleModal').modal('hide')
        $("#jctimeModal").modal('show')
      })
      //点击增加降重次数
      $("#addjctime").click(function(){
        let current = Number($("#curjctime").text())+1;
        $("#curjctime").text(current)
      })
      //复制链接
      var clipboard = new Clipboard("#copybtn",{
        target:function(){
          return document.querySelector('#demo');
        }
      });
      clipboard.on('success', function(e) {
　　    console.log(e); //返回值类型给控制台 没什么用 可以注释掉
　　    toastr.success('复制成功');
        @endauth
      });
      //确认购买
      @auth
      $("#sureshop").click(function(){
        let totalprice=$("#curjctime").text();
        console.log(totalprice,3131)
        axios.post('{{ route('recharges.store') }}',{
          total_amount:totalprice,
          amount:totalprice
        }).then(res => {
          let number = res.data.data.amount;
          let id =res.data.data.id;
          let price=res.data.data.total_amount;
          location.href=`/recharges/${id}`
        }).catch(err => {
          console.log(err,31312)
        })
      })
      })
      //点击减少降重次数
      $("#cutjctime").click(function(){
        let current = Number($("#curjctime").text());
        if(current==1) return;
        let cur =current-1;
        $("#curjctime").text(cur)
      })
      //点击降重
      $('#reduce').click(function(){
        let words =  $('#words span').text();
        let contents = $('#content').val();
        console.log(words,contents,31)
        if(words>1000){
          toastr.error('字数不能大于1000字');
          return
        }
        $('#exampleModal').modal('show')
      })
      //再来一篇
      $('#againjc').click(function(){
        window.location.reload()
      })
       //对比diff方法
       function changed(a,b,c) {
            var oldContent = a
            var content1 = b
            var diff = JsDiff['diffChars'](oldContent, content1);
      var arr = new Array();
      for (var i = 0; i < diff.length; i++) {
        if (diff[i].added && diff[i + 1] && diff[i + 1].removed) {
          var swap = diff[i];
          diff[i] = diff[i + 1];
          diff[i + 1] = swap;
        }
        var diffObj = diff[i];
        var content = diffObj.value;

        //可以考虑启用，特别是后台清理HTML标签后的文本
        if (content.indexOf("\n") >= 0) {

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
          document.getElementById('content_after').innerHTML = html;

          document.getElementById('content_later').innerHTML = c;
        }
       //点击确认显示正在降重弹框
      $("#surecheck").click(function () {
        $('#exampleModal').modal('hide')
        $('#beingModal').modal('show')
        let num = 3;
        togetJc(num)
      })

      function togetJc(num){
        let contents = $('#content').val();
        axios.post('{{ route('ai_rewrite.store') }}',{content:contents})
          .then(res => {
            if(res.data.user.jc_times){
              console.log(res.data.user.jc_times,1323122321)
              $('#jc_timeend').html(res.data.user.jc_times)
            }
            $('#beingModal').modal('hide')
            $('#jcafter').css('display', 'none')
            var htmlstring=res.data.result.new_content;
            var stringtemp =htmlstring.replace(/<[^>]+>/g, "");
            changed(contents,stringtemp,htmlstring)

            $("#jclater").css('display', 'block')
          })
          .catch(err =>{
            num--;
            if(num>=0){
              togetJc(num)
              return;
            }else{
              $('#beingModal').modal('hide')
              toastr.error('降重失败，请重试');
            }
          }
          );
      }
      @endauth
      @unless(Auth::user())
        $('#content').focus(function(){
          $('#noLoginModal').modal('show')
        })
        $('#noreduce').click(function(){
          $('#noLoginModal').modal('show')
        })
        $('#dlzcrk').click(function(){
          $('#noLoginModal').modal('show')
        })
         //账号登录
      $('#accountLogin').click(function () {
        axios.post('{{route('login') }}', {
          phone: $("input[name='phone']").val(),
          password: $("input[name='password']").val(),
          type: 'account'
        }).then(res => {
          if (res.status == 200) {
            swal("提示", res.data.message, "success");
            location.reload();
          } else {
            swal("提示", res.data.message, "error");
          }
        }).catch(err => {
          if (err.response.status == 422) {
            $.each(err.response.data.errors, (field, errors) => {
              swal("提示", errors[0], "error");
            })
          }
          if (err.response.status == 401) {
            $.each(err.response.data, (field, errors) => {
              swal("提示", errors, "error");
            })
          }
        })
      })
      var wait = 60;
      var verification_key = '';

      function time(o) {
        if (wait == 0) {
          o.removeAttribute("disabled");
          o.value = "点击获取验证码";
          wait = 60;
        } else {
          o.setAttribute("disabled", true);
          o.value = "重新发送(" + wait + ")";
          wait--;
          setTimeout(function () {
              time(o)
            },
            1000)
        }
      }

      function getcode(index) {
        index.setAttribute('disabled', true);
        var phone = $("#mobile").val();
        var reg = /^1[34578]\d{9}$/;
        if (!reg.test(phone)) {
          index.removeAttribute("disabled");
          $("input[name='phone']").focus();
          swal('提示信息', "请输入正确的手机号码!!!", "error");
          return;
        }
        axios.post('/api/v1/verificationCodes', {
          phone: phone,
        }).then(res => {
          swal('验证码已发送成功!,请注意查收!')
          time(index);
          verification_key = res.data.key;
        }).catch(err => {
          index.removeAttribute("disabled");
          if (err.response.status == 401) {
            $.each(err.response.data.errors, (field, errors) => {
              swal("提示", errors[0], "error");
            })
          }
        })
      }

      $('#verificationCode').click(function () {
        getcode(this)
      })
      $('#phoneLogin').click(() => {
        axios.post('{{ route('login') }}', {
          phone: $('#mobile').val(),
          verification_code: $('#verification_code').val(),
          verification_key: verification_key,
          type: 'phone'
        }).then(res => {
          location.reload();
        }).catch(err => {
          if (err.response.status == 401) {
            swal("提示", '用户不存在！！！', "error");
          }
          if (err.response.status == 422) {
            $.each(err.response.data.errors, (field, errors) => {
              swal("提示", errors[0], "error");
            })
          }
        });
      });
      @endunless

      toastr.options = {

"closeButton": true, //是否显示关闭按钮

"debug": true, //是否使用debug模式

"showDuration": "1000",//显示的动画时间

"hideDuration": "1000",//消失的动画时间

"positionClass": "toast-cent-cent",//弹出窗的位置

"timeOut": "1000", //展现时间

"extendedTimeOut": "1000",//加长展示时间

"showEasing": "swing",//显示时的动画缓冲方式

"hideEasing": "linear",//消失时的动画缓冲方式

"showMethod": "fadeIn",//显示时的动画方式

"hideMethod": "fadeOut" //消失时的动画方式
};

@unless(Auth::user())
console.log(window.location.href)
if(window.location.href=='https://www.lianwen.com/'){
 $('#jbrk').css('display','block')
}else{
 $('#jbrk').css('display','none')
}
if(window.location.href=='https://www.lianwen.com/ai_rewrite'){
 $('#dlzcrk').css('display','block')
}else{
 $('#dlzcrk').css('display','none')
}
let atag = document.getElementsByClassName("istoaster");
console.log(atag,3131)
for(let i in atag){
 atag[i].onclick = function(event){
     event.preventDefault()
     toastr.error('当前未登录账号，请登录后再操作');
 }
}
@endunless
  </script>
@stop
