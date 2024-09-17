@extends('layouts.app')

@section('content')
<script  language="javascript" type="text/javascript">
$(document).ready(function() {
  <!-- DataTable -->
  var table = $('#UserDepartmentsTable').DataTable( {
    "lengthMenu": [[25, 50, -1], [25, 50, "All"]],
    "pageLength": 25
  });
  <!-- END :: DataTable -->
});

function removeUserDepartment(deptCode) {
  var userId = {{ $data['user']->id }};

  // Start Event to show loader
  removeUserDepartmentEventStart(deptCode);

  var postData = {
    "_token": "{{ csrf_token() }}",
    'dept_code' : deptCode
  };

  $.ajax({
      url: "{{ url('users/delete/departments/'.$data['user']->id) }}",
      headers: {
              'X-Requested-With': 'XMLHttpRequest',
              "X-CSRF-TOKEN" : '{{ csrf_token() }}',
      },
      type: 'POST',
      dataType: 'json',
      data: postData,
  })
  .done(function(response) {
    if(response.status == 'SUCCESS') {
      toastr.remove(); // Remove existing Toaster
      toastr.success('Department Code '+deptCode+' Removed Successfully from User Profile', '', {preventDuplicates: true, progressBar: true, timeOut: 10000, extendedTimeOut: 5000});
      $('#UserDepartmentsTable tbody').find("#dept-"+deptCode).first().remove();
    }
  })
  .fail(function(response) {
    if (typeof response.responseJSON.errors !== 'undefined') {
      var message = response.responseJSON.errors;
    }else {
      var message = 'Sorry there was an Error while removing Department Code '+deptCode+'. Please retry or contact support desk';
    }
    toastr.error(message, '', {preventDuplicates: true, progressBar: true, timeOut: 10000, extendedTimeOut: 5000});
    removeUserDepartmentEventError(deptCode);
  });
}

function removeUserDepartmentEventStart(deptCode) {
  var divId = 'dept-'+ deptCode;

  $('#UserDepartmentsTable tbody tr#dept-'+deptCode+' td span#icon-holder').html('<em class="fa fa-spinner fa-spin"></em>');
  $('#UserDepartmentsTable tbody tr#dept-'+deptCode+' td a').bind('click', false);
}

function removeUserDepartmentEventError(deptCode) {
  var divId = 'dept-'+ deptCode;

  $('#UserDepartmentsTable tbody tr#dept-'+deptCode+' td span#icon-holder').html('<em class="fa fa-times-circle"></em>');
  $('#UserDepartmentsTable tbody tr#dept-'+deptCode+' td a').unbind('click', false);
}
</script>

<div class="container-fluid px-0">
  <div class="px-5 mx-5">
    <div class="row page-header">
      @include('modules.page-title')
      <span class="float-right page-controller" style="margin-left: auto;">
        <a href="{{ url('users/show/'.$data['user']->id) }}" class="btn btn-outline-primary btn-md">Back</a>
        @include('users._partials.options-button-sub-menu')

        <button type="button" class="btn btn-outline-success btn-md" data-toggle="modal" data-target="#modalAddDepartments"><em class="fa fa-plus-circle"></em> Add</button>
        <!-- Modal - Add Departments -->
        <div class="modal fade" id="modalAddDepartments" tabindex="-1" role="dialog" aria-labelledby="modalAddDepartmentsLabel" aria-hidden="true">
           <div class="modal-dialog" role="document">
              <div class="modal-content">
                 <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="modalAddDepartmentsLabel">Add departments</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                    <form id="add-departments-form" action="{{ action('Users\UserDepartmentsController@addDepartments', ['user_id' => $data['user']->id]) }}" method="POST">
                       @csrf
                     <div class="form-group row">
                      <label for="department_code" class="col-md-3 col-form-label">Department Code</label>
                        <div class="col-md-9">
                          <Select name="department_code" id="department_code" class="form-control">
                            <option value="">-Select Dept Code-</option>
                            @foreach($data['departments'] as $item)
                              <option value="{{ $item->department_code }}">{{ $item->point_name.' ('.$item->shipcomp_name.' - '.$item->department_code.')' }}</option>
                            @endforeach
                          </select>
                        </div>
                     </div>
                    </form>
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-md" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-outline-danger btn-md" onclick="event.preventDefault(); document.getElementById('add-departments-form').submit();">Confirm</button></div>
              </div>
           </div>
        </div>
        <!-- / Modal - Add Departments -->

        <button type="button" class="btn btn-outline-success btn-md" data-toggle="modal" data-target="#modalAddAllDepartments"><em class="fa fa-retweet"></em> Add All</button>
        <!-- Modal - Add All Departments -->
        <div class="modal fade" id="modalAddAllDepartments" tabindex="-1" role="dialog" aria-labelledby="modalAddAllDepartmentsLabel" aria-hidden="true">
           <div class="modal-dialog" role="document">
              <div class="modal-content">
                 <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="modalAddAllDepartmentsLabel">Confirm to add all departments</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                    <form id="add-all-departments-form" action="{{ action('Users\UserDepartmentsController@addAllDepartments', ['user_id' => $data['user']->id]) }}" method="POST">
                       @csrf
                     <div class="form-group row">
                      <label for="shipcomp_code" class="col-md-3 col-form-label">Carrier</label>
                        <div class="col-md-9">
                          <Select name="shipcomp_code" id="shipcomp_code" class="form-control">
                            <option value="">-All-</option>
                            @foreach($data['carriers'] as $item)
                              <option value="{{ $item->shipcomp_code }}">{{ $item->shipcomp_name }}</option>
                            @endforeach
                          </select>
                        </div>
                     </div>
                    </form>
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-md" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-outline-danger btn-md" onclick="event.preventDefault(); document.getElementById('add-all-departments-form').submit();">Confirm</button></div>
              </div>
           </div>
        </div>
        <!-- / Modal - Add All Departments -->

        <button type="button" class="btn btn-outline-success btn-md" data-toggle="modal" data-target="#modalCopyDepartments"><em class="fa fa-clone"></em> Copy</button>
        <!-- Modal - Copy Departments -->
        <div class="modal fade" id="modalCopyDepartments" tabindex="-1" role="dialog" aria-labelledby="modalCopyDepartmentsLabel" aria-hidden="true">
           <div class="modal-dialog" role="document">
              <div class="modal-content">
                 <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="modalCopyDepartmentsLabel">Copy departments</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                    <form id="copy-departments-form" action="{{ action('Users\UserDepartmentsController@copyDepartments', ['user_id' => $data['user']->id]) }}" method="POST">
                       @csrf
                     <div class="form-group row">
                      <label for="from_user_id" class="col-md-3 col-form-label">User</label>
                        <div class="col-md-9">
                          <Select name="from_user_id" id="from_user_id" class="form-control">
                            <option value="">-Select Username-</option>
                            @foreach($data['users'] as $item)
                              <option value="{{ $item->id }}">{{ $item->first_name.' '.$item->last_name.' ('.$item->location.') - '.$item->id }}</option>
                            @endforeach
                          </select>
                        </div>
                     </div>
                    </form>
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-md" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-outline-danger btn-md" onclick="event.preventDefault(); document.getElementById('copy-departments-form').submit();">Confirm</button></div>
              </div>
           </div>
        </div>
        <!-- / Modal - Copy Departments -->

        @if($data['user_departments']->count() > 0)
          <button type="button" class="btn btn-outline-danger btn-md" data-toggle="modal" data-target="#modalDeleteAllDepartments"><em class="fa fa-times-circle"></em> Delete All</button>
          <!-- Modal - Delete All Departments -->
          <div class="modal fade" id="modalDeleteAllDepartments" tabindex="-1" role="dialog" aria-labelledby="modalDeleteAllDepartmentsLabel" aria-hidden="true">
             <div class="modal-dialog" role="document">
                <div class="modal-content">
                   <div class="modal-header bg-danger">
                      <h5 class="modal-title text-white" id="modalDeleteAllDepartmentsLabel">Confirm to delete all departments</h5>
                      <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"></button>
                   </div>
                   <div class="modal-footer">
                      <form id="delete-all-departments-form" action="{{ action('Users\UserDepartmentsController@deleteAllDepartments', ['user_id' => $data['user']->id]) }}" method="POST">
                         @csrf
                      </form>
                      <button type="button" class="btn btn-outline-secondary btn-md" data-dismiss="modal">Cancel</button>
                      <button type="button" class="btn btn-outline-danger btn-md" onclick="event.preventDefault(); document.getElementById('delete-all-departments-form').submit();">Confirm</button></div>
                </div>
             </div>
          </div>
          <!-- / Modal - Delete All Departments -->
        @endif



      </span>
    </div>
  </div>

  @include('users._partials.user-profile-module')


  <div class="row px-3">
    <div class="col-12">
      <div class="">
        <table id="UserDepartmentsTable" class="table table-vcenter thead-light table-bordered table-hover table-sm bg-white">
          <caption></caption>
            <thead>
                <tr>
                    <th scope="col">Department Code</th>
                    <th scope="col">Point Code</th>
                    <th scope="col">Location</th>
                    <th scope="col">Zone</th>
                    <th scope="col">Country</th>
                    <th scope="col">&nbsp;</th>
                    <th scope="col">Carrier</th>
                    <th scope="col">Blank Forms</th>
                    <th scope="col">Updated at</th>
                    <th scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @if($data['user_departments']->count() > 0)
                    @foreach ($data['user_departments'] as $item)
                        <tr id="dept-{{$item->department_code}}">
                            <td class="text-center">{{ $item->department_code }}</td>
                            <td>{{ $item->point_code }}</td>
                            <td>{{ $item->point_name }}</td>
                            <td>{{ $item->zone }}</td>
                            <td class="text-center">{{ $item->base_country }}</td>
                            <td class="text-center"><img alt="" src="{{ asset('/images/flags/'.strtolower($item->base_country).'.svg') }}" height="15" ></td>
                            <td class="text-center">{{ $item->shipcomp_name }} <span class="float-right"><img alt="" src="{{ asset('/images/logo/carrier-logo/icons/h25/'.$item->shipcomp_code.'.png') }}"></span></td>
                            <td class="text-center"> <span class="{{ ($item->blank_forms_dispatch  == 'N') ? 'badge badge-pill badge-danger' : 'badge badge-pill badge-success' }}">{{ $item->blank_forms_dispatch }}</span></td>
                            <td class="text-right">{{ $item->updated_at }}</td>
                            <td class="text-center"><a class="btn btn-outline-danger btn-sm o-button" href="javascript:removeUserDepartment({{$item->department_code}});"><span id="icon-holder" class="icon-holder"><em class="fa fa-times-circle"></em></a></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        @if($data['user_departments']->count() == 0)
            <div class="alert alert-info">No departments found.</div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
