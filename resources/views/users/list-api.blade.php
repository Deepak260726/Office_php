<div class="container-fluid px-0">
  <div class="container">
    <div class="row page-header">
      @include('modules.page-title')
      <span class="float-right page-controller" style="margin-left: auto;">
        <a class="btn btn-outline-success btn-md" href="#"><em class="fa fa-plus-circle"></em> New User</a>
      </span>
    </div>
  </div>

  <div class="col-12 px-0">
    <div class="card py-5 px-3">
      <div class="table-responsive">
        <table id="UserTable" class="table card-table table-vcenter text-nowrap table-hover table-sm ">
          <caption></caption>
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">User Name</th>
              <th scope="col">Email</th>
              <th scope="col">Auth Mode</th>
              <th scope="col">Domain</th>
              <th scope="col">Company</th>
              <th scope="col">Location</th>
              <th scope="col" class="text-center">Active</th>
              <th scope="col">Updated at</th>
              <th scope="col">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data['users'] as $user)
              <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->first_name.' '.$user->last_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->authentication_mode }}</td>
                <td>{{ $user->domain }}</td>
                <td>{{ $user->company }}</td>
                <td>{{ $user->location }}</td>
                <td class="text-center"><span class="badge {{ ($user->active  == 'N') ? 'badge badge-pill badge-danger' : 'badge badge-pill badge-success'}} px-2 py-1">{{ $user->active }}</span></td>
                <td>{{ $user->updated_at->format('d-M-Y H:i:s') }}</td>
                <td>
                    <a class="btn btn-outline-info btn-md o-button" href="{{ url('users/show/'.$user->id) }}"><span class="icon-holder"><em class="ti-eye"></em></span> View</a>
                </td>
              </tr>
            @endforeach

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
