  <div class="row px-5">
    <div class="card py-2 px-3">
      <div class="card-header">
        <h3 class="card-title"><em class="fa fa-user"></em> Customer Profile</h3>
      </div>
      <!-- col 1 -->
      <table class="table table-borderless table-hover table-sm bg-white mb-0">
        <caption></caption>
          <th scope="col"></th>
          <th scope="col"></th>
          <th scope="col"></th>
        <tr>
          <td class="col-1">Company Name:</td>
          <td class="col-4 font-weight-bold">{{ $customer_profile->get(0)->company_name }}</td>

          <td class="col-1">City:</td>
          <td class="col-3 font-weight-bold">{{ $customer_profile->get(0)->city }}</td>

          <td class="col-1">Country:</td>
          <td class="col-2 font-weight-bold">{{ $customer_profile->get(0)->country }}</td>
        </tr>
        <tr>
          <td>Email:</td>
          <td class="font-weight-bold">{{ $customer_profile->get(0)->current_email }}</td>

          <td>Profile / Notification:</td>
          <td class="font-weight-bold">{{ $customer_profile->get(0)->language }} / {{ $customer_profile->get(0)->notificationlanguage }}</td>

          <td>CCGID / CLIENT_ID:</td>
          <td class="font-weight-bold">{{ $customer_profile->get(0)->ccgid }} / {{ $customer_profile->get(0)->client_id }}</td>
        </tr>
      </table>
    </div>
  </div>
