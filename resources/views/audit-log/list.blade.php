@extends('layouts.app')

@section('content')
<script>
$(document).ready(function() {
  $('#LogTable').DataTable( {
    "lengthMenu": [[25, 50, -1], [25, 50, "All"]],
    "order": [[ 0, "desc" ]]
  });
});
</script>
<div class="container-fluid px-0">
  <div class="container">
    <div class="row page-header">
      @include('modules.page-title')
      <span class="float-right page-controller" style="margin-left: auto;">
      </span>
    </div>
  </div>

  <div class="row">
    <div class="card card-search col-12 py-4 px-5">
      <div class="card-status bg-blue"></div>
      <div class="form-group row mb-0">
        <label for="search_text" class="col-sm-1 col-form-label">Category: </label>
        <div class="col-sm-2">
          <input type="text" class="form-control" id="search_category" name="search_category" value="{{$data['event_category']}}" readonly="readonly">
        </div>
        <label for="search_text" class="col-sm-1 col-form-label">Event: </label>
        <div class="col-sm-2">
          <input type="text" class="form-control" id="search_event" name="search_event" value="{{$data['event']}}" readonly="readonly">
        </div>
        <label for="search_text" class="col-sm-1 col-form-label">Id: </label>
        <div class="col-sm-2">
          <input type="text" class="form-control" id="search_mapped_id" name="search_mapped_id" value="{{$data['mapped_id']}}" readonly="readonly">
        </div>
        <div class="col-sm-2">
          <button type="button" class="btn btn-outline-info btn-md btn-block disabled" disabled="disabled" style="line-height: 0.8rem;" onclick=" javascript:getSubscriptionDetails();"> <em class="fe fe-search"></em> &nbsp; Search</button>
        </div>
        <div class="col-sm-1">
          &nbsp;
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card py-5 px-3">
        <table id="LogTable" class="table card-table table-vcenter text-nowrap table-hover table-sm">
          <caption></caption>
            <thead>
                <tr>
                    <th scope="col">Event Id</th>
                    <th scope="col">Event Category</th>
                    <th scope="col">Event</th>
                    <th scope="col">IP</th>
                    <th scope="col">User</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Data</th>
                </tr>
            </thead>
            <tbody>
                @if($data['audit_log']->count() > 0)
                    @foreach ($data['audit_log'] as $log)
                        <tr>
                            <td>{{ $log->id }}</td>
                            <td>{{ $log->event_category }}</td>
                            <td>{{ $log->event }}</td>
                            <td>{{ $log->ip }}</td>
                            <td>{{ strtoupper($log->user->first_name.' '.substr($log->user->last_name,0,1)) }}</td>
                            <td>{{ $log->created_at->format('d-M-Y H:i:s') }}</td>
                            <td>

                              @if($log->event_category != 'B2B_ONBOARDING_REQUEST')
                                @if(\App\Helpers\JsonHelper::isJson($log->data) === TRUE)
                                  <?php $decoded = json_decode($log->data); ?>
                                  <table class="table table-sm small my-0">
                                    <caption></caption>
                                    <tr>
                                      <th scope="col" class="small">Field</th><th scope="col">Old</th><th scope="col">New</th>
                                    </tr>
                                    @foreach($decoded as $decoded_item)
                                      
                                      <tr class="small">
                                        <td>{{strtoupper($decoded_item->field)}}</td><td>{{$decoded_item->old}}</td><td>{{$decoded_item->new}}</td>
                                      </tr>
                                    @endforeach
                                  </table>
                                @else
                                  {{ $log->data }}
                                @endif
                              @else 

                                {{ $log->data }}

                              @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        @if($data['audit_log']->count() == 0)
            <div class="alert alert-info">No log found.</div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
