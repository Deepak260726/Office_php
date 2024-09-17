@extends('layouts.app')

@section('content')
<script  language="javascript" type="text/javascript">
$(document).ready(function() {
  <!-- DataTable -->
  var table = $('#DataTable').DataTable( {
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    "pageLength": 10
  });
  var table = $('#DataTablePermission').DataTable( {
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    "pageLength": 10
  });
  <!-- END :: DataTable -->
});
</script>

<div class="container-fluid px-0">
  <div class="px-5 mx-5">
    <div class="row page-header">
      @include('modules.page-title')
      <span class="float-right page-controller" style="margin-left: auto;">
        <a href="{{ url('users/show/'.$data['user']->id) }}" class="btn btn-outline-primary btn-md">Back</a>
        @include('users._partials.options-button-sub-menu')

        <button type="button" class="btn btn-outline-success btn-md" data-toggle="modal" data-target="#modalAddRoles"><em class="fa fa-plus-circle"></em> Add</button>
        <!-- Modal - Add Roles -->
        <div class="modal fade" id="modalAddRoles" tabindex="-1" role="dialog" aria-labelledby="modalAddRolesLabel" aria-hidden="true">
           <div class="modal-dialog" role="document">
              <div class="modal-content">
                 <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="modalAddRolesLabel">Add Role</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                    <form id="add-roles-form" action="{{ action('Users\UserRolesController@addRoles', ['user_id' => $data['user']->id]) }}" method="POST">
                       @csrf
                     <div class="form-group row">
                      <label for="role_name" class="col-md-3 col-form-label">Role</label>
                        <div class="col-md-9">
                          <Select name="role_name" id="role_name" class="form-control">
                            <option value="">-Select Role-</option>
                            @foreach($data['roles'] as $item)
                              <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                          </select>
                        </div>
                     </div>
                    </form>
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-md" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-outline-danger btn-md" onclick="event.preventDefault(); document.getElementById('add-roles-form').submit();">Confirm</button></div>
              </div>
           </div>
        </div>
        <!-- / Modal - Add Roles -->

        <button type="button" class="btn btn-outline-success btn-md" data-toggle="modal" data-target="#modalAddAllRoles"><em class="fa fa-retweet"></em> Add All</button>
        <!-- Modal - Add All Roles -->
        <div class="modal fade" id="modalAddAllRoles" tabindex="-1" role="dialog" aria-labelledby="modalAddAllRolesLabel" aria-hidden="true">
           <div class="modal-dialog" role="document">
              <div class="modal-content">
                 <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="modalAddAllRolesLabel">Confirm to add all roles</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"></button>
                    <form id="add-all-roles-form" action="{{ action('Users\UserRolesController@addAllRoles', ['user_id' => $data['user']->id]) }}" method="POST">
                       @csrf
                    </form>
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-md" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-outline-danger btn-md" onclick="event.preventDefault(); document.getElementById('add-all-roles-form').submit();">Confirm</button></div>
              </div>
           </div>
        </div>
        <!-- / Modal - Add All Roles -->

        <button type="button" class="btn btn-outline-success btn-md" data-toggle="modal" data-target="#modalCopyRoles"><em class="fa fa-clone"></em> Copy</button>
        <!-- Modal - Copy Roles -->
        <div class="modal fade" id="modalCopyRoles" tabindex="-1" role="dialog" aria-labelledby="modalCopyRolesLabel" aria-hidden="true">
           <div class="modal-dialog" role="document">
              <div class="modal-content">
                 <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="modalCopyRolesLabel">Copy roles</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                    <form id="copy-roles-form" action="{{ action('Users\UserRolesController@copyRoles', ['user_id' => $data['user']->id]) }}" method="POST">
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
                    <button type="button" class="btn btn-outline-danger btn-md" onclick="event.preventDefault(); document.getElementById('copy-roles-form').submit();">Confirm</button></div>
              </div>
           </div>
        </div>
        <!-- / Modal - Copy Roles -->

        @if($data['user_roles']->count() > 0)
          <button type="button" class="btn btn-outline-danger btn-md" data-toggle="modal" data-target="#modalDeleteAllRoles"><em class="fa fa-times-circle"></em> Delete All</button>
          <!-- Modal - Delete All Roles -->
          <div class="modal fade" id="modalDeleteAllRoles" tabindex="-1" role="dialog" aria-labelledby="modalDeleteAllRolesLabel" aria-hidden="true">
             <div class="modal-dialog" role="document">
                <div class="modal-content">
                   <div class="modal-header bg-danger">
                      <h5 class="modal-title text-white" id="modalDeleteAllRolesLabel">Confirm to delete all roles</h5>
                      <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"></button>
                   </div>
                   <div class="modal-footer">
                      <form id="delete-all-roles-form" action="{{ action('Users\UserRolesController@deleteAllRoles', ['user_id' => $data['user']->id]) }}" method="POST">
                         @csrf
                      </form>
                      <button type="button" class="btn btn-outline-secondary btn-md" data-dismiss="modal">Cancel</button>
                      <button type="button" class="btn btn-outline-danger btn-md" onclick="event.preventDefault(); document.getElementById('delete-all-roles-form').submit();">Confirm</button></div>
                </div>
             </div>
          </div>
          <!-- / Modal - Delete All Roles -->
        @endif



      </span>
    </div>
  </div>

  @include('users._partials.user-profile-module')

  <div class="row px-3">
    <div class="col-12">
      <div class="">
        <h5 class="c-grey-900 mt-5 mb-5"><em class="fa fa-user-secret"></em> User Roles</h5>
        <table id="DataTable" class="table table-vcenter thead-light table-bordered table-hover table-sm bg-white">
          <caption></caption>
            <thead>
                <tr>
                    <th scope="col" width="20%">Role Id</th>
                    <th scope="col" width="30%">Role Name</th>
                    <th scope="col" width="30%">Guard</th>
                    <th scope="col" width="20%">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @if($data['user_roles']->count() > 0)
                    @foreach ($data['user_roles'] as $item)
                        <tr id="role-{{$item->name}}">
                            <td class="text-center">{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->guard_name }}</td>
                            <td class="text-center">
                              <form id="delete-roles-form-{{$item->id}}" action="{{ action('Users\UserRolesController@deleteRoles', ['user_id' => $data['user']->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="role_name" value="{{ $item->name }}">
                              </form>
                              <button type="button" class="btn btn-outline-danger btn-sm o-button" onclick="event.preventDefault(); document.getElementById('delete-roles-form-{{$item->id}}').submit();"><span id="icon-holder" class="icon-holder"><em class="fa fa-times-circle"></em></button>
                           </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        @if($data['user_roles']->count() == 0)
            <div class="alert alert-info">No roles found.</div>
        @endif
      </div>
    </div>
  </div>
  <br/>
  <div class="row px-3">
    <div class="col-12">
      <div class="">
        <h5 class="c-grey-900 mt-5 mb-5"><em class="fa fa-user-secret"></em> User Permission</h5>
        <table id="DataTablePermission" class="table table-vcenter thead-light table-bordered table-hover table-sm bg-white">
          <caption></caption>
            <thead>
                <tr>
                    <th scope="col" width="20%">Permission Id</th>
                    <th scope="col" width="30%">Permission Name</th>
                    <th scope="col" width="30%">Guard</th>
                    <th scope="col" width="20%">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @if($data['user_permissions']->count() > 0)
                    @foreach ($data['user_permissions'] as $item)
                        <tr id="permission-{{$item->name}}">
                            <td class="text-center">{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->guard_name }}</td>
                            <td class="text-center">
                              &nbsp;
                           </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        @if($data['user_permissions']->count() == 0)
            <div class="alert alert-info">No permission found.</div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
