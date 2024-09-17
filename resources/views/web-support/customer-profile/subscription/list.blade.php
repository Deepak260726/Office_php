@include('web-support.customer-profile._partials.customer-profile-module')

@include('web-support.customer-profile._partials.customer-carrier-access')

<script>
$(document).ready(function() {
  $('#SubscriptionTable').DataTable( {
    dom: 'Blfrtip',
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    buttons: ['copyHtml5', 'csvHtml5'],
    initComplete: function () {
            this.api().columns([1,2,3,4,5,6,7,8,9]).every( function () {
                var column = this;
                console.log(column[0][0]);
                var yesNoDropdown = [6,7,8,9];
                var select = $('<select class="form-control form-control-sm"><option value="">-</option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );

                if((yesNoDropdown.includes(column[0][0])) == true) {
                  select.append( '<option value="Y">Y</option>' );
                  select.append( '<option value="N">N</option>' );
                }else {
                  column.data().unique().sort().each( function ( d, j ) {
                      select.append( '<option value="'+d+'">'+d+'</option>' )
                  } );
                }

            } );
        }
  });
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
            <th scope="col" class="text-center">Order</th>
            <th scope="col" class="text-center">Carrier</th>
            <th scope="col" class="text-center">Category</th>
            <th scope="col" class="text-center">Event Name</th>
            <th scope="col" class="text-center">Module</th>
            <th scope="col" class="text-center">Type</th>
            <th scope="col" class="text-center">SMS</th>
            <th scope="col" class="text-center">Web</th>
            <th scope="col" class="text-center">Email</th>
            <th scope="col" class="text-center">Active</th>
            <th scope="col" class="text-center">Created At</th>
            <th scope="col" class="text-center">Update At</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th scope="col">Filter</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col" class="text-center">&nbsp;</th>
            <th scope="col" class="text-center">&nbsp;</th>
            <th scope="col" class="text-center">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
          </tr>
        </tfoot>
        @if($subscription->count() > 0)
          <tbody>
            @foreach ($subscription as $item)
              <tr>
                <td class="text-center">{{ $item->display_order }}</td>
                <td>{{ $item->carrier }}</td>
                <td>{{ $item->category }}</td>
                <td>{{ $item->event_name }}</td>
                <td>{{ $item->module }}</td>
                <td>{{ $item->type }}</td>
                <td class="text-center"><span class="badge {{ ($item->subscribetosms  == '0') ? 'badge badge-pill badge-warning' : 'badge badge-pill badge-success'}} px-2 py-1">{{ ($item->subscribetosms  == '0') ? 'N' : 'Y'}}</span></td>
                <td class="text-center"><span class="badge {{ ($item->subscribetoemail  == '0') ? 'badge badge-pill badge-warning' : 'badge badge-pill badge-success'}} px-2 py-1">{{ ($item->subscribetoemail  == '0') ? 'N' : 'Y'}}</span></td>
                <td class="text-center"><span class="badge {{ ($item->subscribetoweb  == '0') ? 'badge badge-pill badge-warning' : 'badge badge-pill badge-success'}} px-2 py-1">{{ ($item->subscribetoweb  == '0') ? 'N' : 'Y'}}</span></td>
                <td class="text-center"><span class="badge {{ ($item->active  == '0') ? 'badge badge-pill badge-danger' : 'badge badge-pill badge-success'}} px-2 py-1">{{ ($item->active  == '0') ? 'N' : 'Y'}}</span></td>
                <td class="text-right">{{ $item->creation_date }}</td>
                <td class="text-right">{{ $item->update_date }}</td>
              </tr>
            @endforeach
          </tbody>
        @endif
      </table>
    </div>
  </div>
</div>
