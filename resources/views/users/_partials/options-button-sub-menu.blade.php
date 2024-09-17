      <button class="btn btn-outline-primary btn-md dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options</button>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="{{ action('Users\UserDepartmentsController@manageDepartments', ['user_id' => $data['user']->id]) }}">Manage Departments</a>
          <a class="dropdown-item" href="{{ action('Users\UserRolesController@index', ['user_id' => $data['user']->id]) }}">Manage Roles</a>
        </div>