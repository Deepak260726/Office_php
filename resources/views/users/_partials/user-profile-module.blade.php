  <div class="row px-5">
    <div class="card py-2 px-3">
      <!-- col 1 -->
      <table class="table table-borderless table-hover table-sm bg-white mb-0">
        <caption></caption>
        <tr>
          <th scope="col"></th>
          <th scope="col"></th>
          <th scope="col"></th>
          <th scope="col"></th>
        </tr>
        <tr>
          <td class="col-1">Id:</td>
          <td class="col-3 font-weight-bold">{{ $data['user']->id }}</td>

          <td class="col-1">Auth Mode:</td>
          <td class="col-1 font-weight-bold">{{ $data['user']->authentication_mode }}</td>

          <td class="col-1">First Name:</td>
          <td class="col-2 font-weight-bold">{{ $data['user']->first_name }}</td>

          <td class="col-1">Last Name:</td>
          <td class="col-2 font-weight-bold">{{ $data['user']->last_name }}</td>
        </tr>
        <tr>
          <td>Email:</td>
          <td class="font-weight-bold">{{ $data['user']->email }}</td>

          <td>Active:</td>
          <td class="font-weight-bold">{{ $data['user']->active }}</td>

          <td>Location:</td>
          <td class="font-weight-bold">{{ $data['user']->location }}</td>

          <td>Updated at:</td>
          <td class="font-weight-bold">{{ $data['user']->updated_at->format('d-M-Y H:i:s') ?? '-' }}</td>
        </tr>
      </table>
    </div>
  </div>
