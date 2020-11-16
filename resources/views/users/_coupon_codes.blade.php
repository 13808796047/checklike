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
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" href="#">已激活卡券</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">过期卡券</a>
  </li>
</ul>
</div>
<script>
let fsdafasdf=  {!!$coupon_codes!!}
  console.log(fsdafasdf,"fadsfhjkjkqeruwer")
</script>
