<script>
$(document).ready(function() {

  $('#CaseTable').DataTable( {
    "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
    "ordering": true,
    "order": [[ 9, "desc" ]],
    "language": {
        "zeroRecords":  "There is no support cases matching with the filters.",
        "emptyTable": "There is no support cases available in this view"
    },
    initComplete: function () {
          this.api().columns([0,1,2,3,4,5,6,7,8,9]).every( function () {
              var column = this;

              var dropDown = [6];
              var yesNoDropdown = [];
              var carrierDropdown = [];

              if((dropDown.includes(column[0][0])) == true) {
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
                } else {
                  column.data().unique().sort().each( function ( d, j ) {
                      select.append( '<option value="'+d+'">'+d+'</option>' )
                  } );
                }
              }else if((column[0][0]) == 2) {
                var select = $('<select class="form-control form-control-sm"><option value="">-</option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column
                            .search( val ? ''+val+'*' : '', true, false )
                            .draw();
                    } );

                    var listitems = '';
                    $.each((JSON.parse(window.priorities)), function(key, data){
                        listitems += '<option value=' + data.name + '>' + data.name + '</option>';

                    });
                    select.append(listitems);

              }else if((column[0][0]) == 3) {
                var select = $('<select class="form-control form-control-sm"><option value="">-</option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column
                            .search( val ? ''+val+'' : '', true, false )
                            .draw();
                    } );

                    var listitems = '';
                    $.each((JSON.parse(window.impacts)), function(key, data){
                        listitems += '<option value=' + data.id + '>' + data.name + '</option>';

                    });
                    select.append(listitems);

              }else if((column[0][0]) == 4) {
                var select = $('<select class="form-control form-control-sm"><option value="">-</option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column
                            .search( val ? ''+val+'*' : '', true, false )
                            .draw();
                    } );

                    var listitems = '';
                    $.each((JSON.parse(window.channels)), function(key, data){
                        listitems += '<option value=' + data.name + '>' + data.name + '</option>';

                    });
                    select.append(listitems);

              }else if((column[0][0]) == 5) {
                var select = $('<select class="form-control form-control-sm"><option value="">-</option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column
                            .search( val ? ''+val+'' : '', true, false )
                            .draw();
                    } );

                    var listitems = '';
                    $.each((JSON.parse(window.topics)), function(key, data){
                        listitems += '<option value=' + data.name + '>' + data.name + '</option>';

                    });
                    select.append(listitems);

              }else if((column[0][0]) == 8) {
                var select = $('<select class="form-control form-control-sm"><option value="">-</option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column
                            .search( val ? ''+val+'' : '', true, false )
                            .draw();
                    } );

                    var listitems = '';
                    $.each((JSON.parse(window.status)), function(key, data){
                        listitems += '<option value=' + data.id + '>' + data.name + '</option>';

                    });
                    select.append(listitems);

              }else {
                var textBox = $('<input type="text" class="form-control form-control-sm">')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'keyup', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column
                            .search( val ? val+'' : '', true, false )
                            .draw();
                    } );
              }




          } );
      }
  });

  // Enable all Tooltip
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });

  // Enable all Popover
  $(function () {
    $('[data-toggle="popover"]').popover();
  });

  // 2020-11-15 :: Fix issue with Tooltip on 2nd Page of DataTable
  $('#CaseTable').on('draw.dt', function() {
     $('[data-toggle="tooltip"]').tooltip();
     $('[data-toggle="popover"]').popover();
});
});
</script>

<table id="CaseTable" class="table card-table table-vcenter table-hover table-sm">
  <caption></caption>
  <thead>
    <tr>
      <th scope="col">User</th>
      <th scope="col">Id</th>
      <th scope="col">Priority</th>
      <th scope="col">Impact</th>
      <th scope="col">Channel</th>
      <th scope="col">Topic</th>
      <th scope="col">Sub Topic</th>
      <th scope="col">Title</th>
      <th scope="col">Status</th>
      <th scope="col">Updated At</th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
    </tr>
  </tfoot>
  <tbody>
    @foreach ($data['cases'] as $item)
      <tr onclick="window.location.href = '{{ url('support/show/'.$item->id) }}';" class="pointer-cursor">

        <td class="text-center" data-sort="{{ $item->User->first_name.' '.$item->User->last_name }}" data-search="{{ $item->User->first_name.' '.$item->User->last_name }}">
          {!! App\Helpers\UserHelper::getUserAvatar($item->User->first_name, $item->User->last_name) !!}
        </td>

        <td class="text-center" data-sort="{{ ($item->case_number == '') ? $item->id : $item->case_number }}" data-search="{{ ($item->case_number == '') ? $item->id : $item->case_number }}">
        <a class="" href="{{ url('support/show/'.$item->id) }}" > {{ ($item->case_number == '') ? $item->id : $item->case_number }} </a>
        </td>

        <td data-sort="{{ $item->priority_id }}">
          {!! App\Helpers\SupportHelper::getPriorityHtml($item->priority_id, $item->SupportCasePriority->name) !!}
        </td>

        <td class="text-center" data-sort="{{ $item->impact_id }}" data-search="{{ $item->impact_id }}"><a class="text-{{ $item->SupportCaseImpact->color_category }}" data-toggle="tooltip" data-placement="top" title="{{ $item->SupportCaseImpact->name }}" href="#"><em class="fas {{ $item->SupportCaseImpact->icon }}"></em></a></td>

        <td>{{ $item->SupportCaseChannel->name }}</td>
        <td data-sort="{{ $item->SupportCaseTopic->name }}" data-search="{{ $item->SupportCaseTopic->name }}">{{ $item->SupportCaseTopic->name }}</td>
        <td>{{ $item->SupportCaseSubTopic->name}}</td>
        <td>{{ $item->title }}</td>
        <td data-sort="{{ $item->status_id }}" data-search="{{ $item->status_id }}">
          {!! App\Helpers\SupportHelper::getStatusHtml($item->status_id, $item->SupportCaseStatus->name) !!}
        </td>
        <td>{{ date('d-m-y H:m:s', strtotime($item->updated_at)) }}</td>
      </tr>
    @endforeach

  </tbody>
</table>
