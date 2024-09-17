@extends('layouts.app')

@section('content')
<script  language="javascript" type="text/javascript">

function getUsers() {
  $('#json-content').html('');
  var jqxhr = $.get( "{{ url('api/users') }}", function(response) {
    $('#json-content').html(response);
  });
}
</script>
<div class="container">
    <div class="row justify-content-center" style="vertical-align: middle;">
        <div class="title" style="color: #B0BEC5; font-weight: 100; font-size: 96px; margin-top:160px;">Welcome</div>
        <?php /**<div class="text-center"> <br/> <img src="{{ asset('/images/eSupport-Logo.png') }}" alt="Niya"></div>***/ ?>
    </div>
</div>
@endsection
