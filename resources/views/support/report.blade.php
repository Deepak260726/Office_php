@extends('layouts.app')

@section('content')
<script>

  $(document).ready(function() {

    //Select2
        $('.select2').select2({
            minimumResultsForSearch: 10,
            dropdownParent: $("#report-form")
        });


        // Date Picker
        $('.date-picker').datetimepicker({
                icons: {
                        time: "fas fa-clock",
                        date: "fas fa-calendar",
                        up: "fas fa-arrow-up",
                        down: "fas fa-arrow-down"
                },
                format: "DD-MMM-YYYY",
                useCurrent: true,
                showClear: true,
                viewMode: 'months'
        });


        // Form Validation
    $("#report-form").validate({
      errorClass: "is-invalid",
      errorPlacement: function(error,element) {
        var elementName = element.attr("name");
        elementName = ucwords(elementName.replace("_id", ""));
        elementName = ucwords(elementName.replace(/_/g, " "));
        
        toastr.error(elementName +": "+ error.text(), '', {preventDuplicates: true, progressBar: true, timeOut: 10000, extendedTimeOut: 5000})
        return true;
      },
      rules: {
        from_date: {
          required: true
        },
        to_date: {
          required: true
        },
        status: {
          required: true
        }
      }
    });

  });

</script>

<div class="container-fluid px-0">
  <div class="px-5 mx-5">
    <div class="row page-header">
      @include('modules.page-title')
      <span class="float-right page-controller" style="margin-left: auto;">
        <a class="btn btn-outline-success btn-md" href="{{ action('Support\SupportController@create') }}"><em class="fa fa-plus-circle"></em> New Case</a>
      </span>
    </div>
  </div>

  <div class="col-12 px-0">
    <div class="card py-5 px-5">
        <div class="container">
            <section class="border rounded m-3">
          <div class="row">
            <div class="col-md-12 col-lg-12">
              <div class="card card-header-actions h-100 card-new">
                <div class="card-body p-3">
                  <section class="border rounded bg-light-blue m-3">
                    <div class="card card-header-actions h-100 border-0 bg-light-blue mb-2">
                      <div class="card-body p-3">
                        
                        <form name="report-form" id="report-form" method="post" action="{{ action('Support\SupportController@generateReport') }}" autocomplete="off">
                          @method('post')
                          @csrf
                          
                          <div class="row col-md-12">

                          <div class="col-md-3">
                                <div class="form-group row col-md" id="report_type-area">
                                    <label for="status" class="col-form-label required">Type</label>
                                    <select name="report_type" class="form-control custom-select select2" id="report_type">
                                        <option selected="selected" value="CASE_OPENED_AT">Case Open at</option>
                                        <option value="CASE_UPDATED_AT">Case Update at</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-group row col-md">
                                <label for="from_date" class="col-form-label required">From Date</label>
                                <input type="text" class="form-control date-picker custom-select" id="from_date" name="from_date"  value="{{ old('from_date') }}">
                              </div>
                            </div>


                            <div class="col-md-3">
                              <div class="form-group row col-md">
                                <label for="to_date" class="col-form-label required">To Date</label>
                                <input type="text" class="form-control date-picker custom-select" id="to_date" name="to_date"  value="{{ old('to_date') }}">
                              </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group row col-md" id="channel-area">
                                    <label for="status" class="col-form-label required">Status</label>
                                    <select name="status" class="form-control custom-select select2" id="status">
                                        <option value="ALL">All Cases</option>
                                        @foreach($data['status'] as $item)
                                        <option value="{{ $item->id }}" {{ (old('status') == $item->id) ?  'selected="selected"' : ''}}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="text-center px-0" style="margin-top: 25px;">
                                    <button type="submit" id="report-generate-btn" class="btn btn-outline-info o-button btn-md">Generate Report</button>
                                </div>
                            </div>


                          </div>

                        
                        </form>
                      </div>
                    </div>
                  </section>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>

    </div>
  </div>


  
</div>
@endsection