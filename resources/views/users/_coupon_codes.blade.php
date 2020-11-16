<style>
  .yhcard {
    width: 220px;
    position: relative;
    color: #FFFAFA;
    background: radial-gradient(circle at 110px 0, transparent 10px, #74D2D4 0) top left/220px 100% no-repeat;
    margin: 10px 15px;
  }

  .yhcard::after {
    content: '';
    position: absolute;
    height: 5px;
    width: 100%;
    left: 0;
    bottom: -5px;
    background-image: linear-gradient(to right, #74D2D4 5px, transparent 5px, transparent),
    radial-gradient(10px circle at 10px 5px, transparent 5px, #74D2D4 5px);
    background-size: 15px 5px;
  }

  .gqcard {
    width: 220px;
    position: relative;
    color: #FFFAFA;
    background: radial-gradient(circle at 110px 0, transparent 10px, #D1D1D1 0) top left/220px 100% no-repeat;
    margin: 10px 15px;
  }

  .gqcard::after {
    content: '';
    position: absolute;
    height: 5px;
    width: 100%;
    left: 0;
    bottom: -5px;
    background-image: linear-gradient(to right, #D1D1D1 5px, transparent 5px, transparent),
    radial-gradient(10px circle at 10px 5px, transparent 5px, #D1D1D1 5px);
    background-size: 15px 5px;
  }

  .cardpline {
    font-size: 11px;
    margin: 0 0 0 10px;
    padding-bottom: 10px;
  }

  .cardpline p {
    line-height: 1.5;
  }
</style>
<div>
<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Home</a>
    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</a>

  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
  <div style="display: flex;flex-wrap: wrap;">
    @foreach($coupon_codes as $item)
        @if ($item->is_enable == true)
          @continue
        @endif
      <div class="yhcard">
        <div style="text-align: center;padding-top: 23px;font-size: 29px;font-weight: bold;">
          @if($item->type =="fixed")
            ￥{{$item->value}}
          @else
            {{$item->value}}折
          @endif
        </div>
        <div style="text-align:center;font-size:11px;">
          @if($item->type =="vip")
            VIP专属
          @else
            满{{$item->min_amount}}元可用，限一次
          @endif
        </div>
        <div class="cardpline">
          <p>适用系统：{{$item->category? $item->category->name:"不限"}}</p>
          <p>有效期：剩余{{$item->enable_days}}天</p>
          <p>卡券编号：{{$item->code}}</p>
        </div>
      </div>
    @endforeach
  </div>
  </div>
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
  <div style="display: flex;flex-wrap: wrap;">
    @foreach($coupon_codes as $item)
        @if ($item->is_enable == false)
          @continue
        @endif
      <div class="gqcard">
        <div style="text-align: center;padding-top: 23px;font-size: 29px;font-weight: bold;">
          @if($item->type =="fixed")
            ￥{{$item->value}}
          @else
            {{$item->value}}折
          @endif
        </div>
        <div style="text-align:center;font-size:11px;">
          @if($item->type =="vip")
            VIP专属
          @else
            满{{$item->min_amount}}元可用，限一次
          @endif
        </div>
        <div class="cardpline">
          <p>适用系统：{{$item->category? $item->category->name:"不限"}}</p>
          <p></p>
          <p>卡券编号：{{$item->code}}</p>
        </div>
      </div>
    @endforeach
  </div>
  </div>
</div>

</div>
<script>
let fsdafasdf=  {!!$coupon_codes!!}
  console.log(fsdafasdf,"fadsfhjkjkqeruwer")
</script>
