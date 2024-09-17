<script>
$(document).ready(function() {
  $('#SubscriptionTable').DataTable( {
    dom: 'Blfrtip',
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    buttons: ['copyHtml5', 'csvHtml5']
  });

  $(function () {
    $('[data-toggle="popover"]').popover()
  })
});
</script>

<div class="col-12">
  <div class="card py-2 px-3">
    <div class="card-header">
      <h3 class="card-title"><em class="fa fa-bell"></em> Subscription Details</h3>
    </div>
    <div class="table-responsive py-2">
      <table id="SubscriptionTable" class="table card-table table-vcenter text-nowrap table-hover table-sm ">
        <caption></caption>
        <thead>
          <tr>
            <th scope="col" class="text-center">Brand</th>
            <th scope="col" class="text-center">Lang.</th>
            <th scope="col" class="text-center">Lang. News</th>
            <th scope="col" class="text-center">Agency</th>
            <th scope="col" class="text-center">URL_EN</th>
            <th scope="col" class="text-center">Pending</th>
            <th scope="col" class="text-center">Subscribed at</th>
            <th scope="col" class="text-center">Validated at</th>
            <th scope="col" class="text-center">Last News Sent at</th>
            <th scope="col" class="text-center">Last News Id</th>
            <th scope="col" class="text-center">Sent Counter</th>
            <th scope="col" class="text-center">&nbsp;</th>
          </tr>
        </thead>
        @if($subscription->count() > 0)
          <tbody>
            @foreach ($subscription as $item)
              <tr>
                <td class="text-center">{{ $item->brand }}</td>
                <td class="text-center">{{ $item->language }}</td>
                <td class="text-center">{{ $item->language_news }}</td>
                <td class="text-center">{{ $item->agency }}</td>
                <td class="text-center">{{ $item->url_en }}</td>
                <td class="text-center"><span class="badge {{ ($item->pendingvalidation  == 'n') ? 'badge badge-pill badge-success' : 'badge badge-pill badge-danger'}} px-2 py-1">{{ strtoupper($item->pendingvalidation)}}</span></td>
                <td class="text-right">{{ ($item->subscribe_date != null ? Carbon::parse($item->subscribe_date)->format('d-M-Y H:i:s') : '-') }}</td>
                <td class="text-right">{{ ($item->validation_date != null ? Carbon::parse($item->validation_date)->format('d-M-Y H:i:s') : '-') }}</td>
                <td class="text-right">{{ ($item->last_send_date != null ?  Carbon::parse($item->last_send_date)->format('d-M-Y H:i:s') : '-') }}</td>
                <td class="text-center">{{ $item->last_send_news }}</td>
                <td class="text-center">{{ $item->sent_counter }}</td>
                <td class="text-center">
                  <button type="button" class="btn btn-secondary btn-sm o-button" data-container="body" data-toggle="popover" data-placement="left" data-content="{{ $item->subscription_token }}">Token</button>
                </td>
              </tr>
            @endforeach
          </tbody>
        @endif
      </table>
    </div>
  </div>
</div>
