@extends('layouts.app')

@section('content')
<script  language="javascript" type="text/javascript">
$(document).ready(function() {

});

function getSubscriptionDetails() {
  
  toastr.remove(); // Remove existing Toaster
  $('#result').html('<div class="text-center" style="padding-top: 50px"><img alt="" src="{{asset('images/ajax-loader-big.gif')}}"></div>');
  
  var postData = {
    "_token": "{{ csrf_token() }}",
    'search_type' : $('#search_type').val(),
    'search_text' : $('#search_text').val()
  };
  
  if(postData.search_text == '') {
    var message = 'Please enter the search text';
    toastr.error(message, '', {preventDuplicates: false, progressBar: true, timeOut: 10000, extendedTimeOut: 5000});
    $('#result').html('');
    return false;
  }
  
  /**if(typeof xhrSubscriptionDetails !== 'undefined' && xhrSubscriptionDetails.readyState != 4){
      xhrSubscriptionDetails.abort();
  }**/
        
  xhrSubscriptionDetails = $.ajax({
      url: "{{ action('WebSupport\CustomerProfile\SubscriptionController@getSubscription') }}",
      headers: {
              'X-Requested-With': 'XMLHttpRequest',
              "X-CSRF-TOKEN" : '{{ csrf_token() }}',
      },
      type: 'GET',
      dataType: 'json',
      data: postData,
  })
  .done(function(response) {
    if(response.status == 'SUCCESS') {
      toastr.remove(); // Remove existing Toaster
      $('#result').html(response.html);
    }
  })
  .fail(function(response) {
    toastr.remove(); // Remove existing Toaster
    if(typeof response.responseJSON.errors !== 'undefined') {
      var message = response.responseJSON.errors;
    }else {
      var message = 'Sorry there was an error while retreiveing subcription. Please retry or contact support desk';
    }
    $('#result').html('');
    toastr.error(message, '', {preventDuplicates: false, progressBar: true, timeOut: 10000, extendedTimeOut: 5000});
  });
}
</script>

<div class="container-fluid px-0">
  <div class="container">
    <div class="row page-header">
      @include('modules.page-title')
      <span class="float-right page-controller" style="margin-left: auto;">
        <a href="{{ url('') }}" class="btn btn-outline-primary btn-md">Back</a>
      </span>
    </div>
  </div>
  
  
  <div class="row px-5">
    <div class="card card-search col-12 py-4 px-5">
      <div class="card-status bg-blue"></div>
      <div class="form-group row mb-0">
        <label for="search_text" class="col-sm-1 col-form-label">Search: </label>
        <div class="col-sm-2">
          <select class="form-control" id="search_type" name="search_type">
            <option value="email">Email</option>
            <option value="ccgid">CCGID</option>
          </select>
        </div>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="search_text" name="search_text" placeholder="Email id / CCGID" value="">
        </div>
        <div class="col-sm-2">
          <button type="button" class="btn btn-outline-info btn-md btn-block" style="line-height: 0.8rem;" onclick=" javascript:getSubscriptionDetails();"> <em class="fe fe-search"></em> &nbsp; Search</button>
        </div>
        <div class="col-sm-4">
          &nbsp;
        </div>
      </div>
    </div>
  </div>
  
  <div id="result" class="">
     <div class="px-5">Please enter CCGID or email address to search</div>
  </div>
  
</div>
@endsection