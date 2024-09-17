<div class="row px-5">
  <div class="card">
    <table class="table table-bordered table-sm table-hover card-table" style="vertical-align: top;">
      <caption></caption>
      <thead>
          <tr>
          <th scope="col">Carrier</th>
          <th scope="col">Status</th>
          <th scope="col">Creation Date</th>
          <th scope="col">Activation Date</th>
          <th scope="col">Last Login Date</th>
          <th scope="col">&nbsp;</th>
        </tr>
      </thead>
     <tbody>
        @foreach($customer_profile->unique('carrier')->sortBy('shipcomp_code') as $item)
          <tr>
            <td>{{ $item->carrier }}</td>
            <td>{{ $item->status_name }}</td>
            <td>{{ $item->sys_created_date }}</td>
            <td>{{ $item->activation_date }}</td>
            <td>{{ $item->last_login_date }}</td>
            <td>
            <?php $carrier = App\Helpers\Carriers::getCarrierFromShipCompCodes($item->shipcomp_code); ?>
              <a class="btn btn-link btn-sm" target="_blank" rel="noopener" href="{{$carrier->website_url}}actas?ccgid={{$item->ccgid}}">Act As</a>
            </td>
          </tr>
        @endforeach
      </tbody>
     </table>
  </div>
</div>
