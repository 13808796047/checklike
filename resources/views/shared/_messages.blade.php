{{--@foreach (['danger', 'warning', 'success', 'info'] as $msg)--}}
{{--  @if(session()->has($msg))--}}
{{--    <div class="flash-message">--}}
{{--      <p class="alert alert-{{ $msg }}">--}}
{{--        {{ session()->get($msg) }}--}}
{{--      </p>--}}
{{--    </div>--}}
{{--  @endif--}}
{{--@endforeach--}}
{{--@if (count($errors) > 0)--}}
{{--  <div class="alert alert-danger">--}}
{{--    <ul>--}}
{{--      @foreach($errors->all() as $error)--}}
{{--        <li>{{ $error }}</li>--}}
{{--      @endforeach--}}
{{--    </ul>--}}
{{--  </div>--}}
{{--@endif--}}
