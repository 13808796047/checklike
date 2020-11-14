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
<div>
  <div style="display: flex;flex-wrap: wrap;">

    {{$coupon_codes}}
  </div>
</div>
</div>
<script>
  console.log({{!!$coupon_codes!!}})
</script>
