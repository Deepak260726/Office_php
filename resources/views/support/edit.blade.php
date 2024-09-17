@extends('layouts.app')

@section('content')
<script>
  $(document).ready(function() {

    //Select2
    $('.select2').select2({
        minimumResultsForSearch: 10,
        dropdownParent: $("#support-edit-form")
    });


    // Date Picker
    $('.date-picker').datetimepicker({
            icons: {
                    time: "fas fa-clock",
                    date: "fas fa-calendar",
                    up: "fas fa-arrow-up",
                    down: "fas fa-arrow-down"
            },
            format: "DD-MMM-YYYY HH:mm:ss",
            useCurrent: false,
            showClear: true,
            viewMode: 'months'
        });

     // Initialize Quill
     var toolbarOptions = ['bold', 'italic', 'underline', 'strike', 'clean'];

      var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
          toolbar: toolbarOptions
        }
      });

      // Disabling Editor to avoid auto focus
      quill.enable(false);

      // Enable the editor now
      quill.enable();

      // Set Existing HTML Content
      //var existingHtmlContent = '';
      //quill.clipboard.dangerouslyPasteHTML(0, existingHtmlContent);

      quill.clipboard.addMatcher(Node.ELEMENT_NODE, (node, delta) => {
        let ops = []
        delta.ops.forEach(op => {
          if (op.insert && typeof op.insert === 'string') {
            ops.push({
              insert: op.insert
            })
          }
        })
        delta.ops = ops
        return delta
      })


    // Form Validation
    $("#support-edit-form").validate({
      errorClass: "is-invalid",
      errorPlacement: function(error,element) {
        var elementName = element.attr("name");
        elementName = ucwords(elementName.replace("_id", ""));
        elementName = ucwords(elementName.replace(/_/g, " "));

        toastr.error(elementName +": "+ error.text(), '', {preventDuplicates: true, progressBar: true, timeOut: 10000, extendedTimeOut: 5000})
        return true;
      },
      rules: {
        case_number: {
          required: true
        },
        channel_id: {
          required: true
        },
        priority_id: {
          required: true
        },
        impact_id: {
          required: true
        },
        topic_id: {
          required: true
        },
        subtopic_id: {
          required: true
        },
        case_opened_at: {
          required: true
        },
        title: {
          required: true
        },
        description: {
          required: true
        },
        type_id: {
          required: true
        },
        source_id: {
          required: true
        }
      }
    });

    $('#support-edit-form #source_id').on('change', function() {
      switch ($(this).val()) {
        case '60':
          $('#support-edit-form #case_number').prop('disabled', false);
          break;
        default:
          $('#support-edit-form #case_number').prop('disabled', true);
      }
    });
    $('#support-edit-form #source_id').trigger('change');


    //Filter Sub Topics
    $('#support-edit-form').ready(function() {
      if ($('#support-edit-form #topic_id').data('options') === undefined) {
        //Taking an array of all options-2 and kind of embedding it on the select1
        $('#support-edit-form #topic_id').data('options', $('#subtopic_id option').clone());
      }
      var id = $('#support-edit-form #topic_id').val();
      var options = $('#support-edit-form #topic_id').data('options').filter('[parent_topic_id=' + id + ']');
      $('#subtopic_id').html(options);
    });

    //Filter Sub Topics on Topic change
    $('#support-edit-form #topic_id').on('change', function() {

      if ($(this).data('options') === undefined) {
        //Taking an array of all options-2 and kind of embedding it on the select1
        $(this).data('options', $('#subtopic_id option').clone());
      }
      var id = $(this).val();
      var options = $(this).data('options').filter('[parent_topic_id=' + id + ']');
      $('#subtopic_id').html(options);
      $("#subtopic_id").prepend("<option value=''>--Select Sub Topic--</option>").val('');
    });

    $("#case-update-btn").on("click",function(e) {

      var description = quill.root.innerHTML
          .replace(/<p><\/p>/ig, "")
          .replace(/<p><br><\/p>/ig, "")
          .replace(/<p><br\/><\/p>/ig, "")
          .replace(/<p>&nbsp;<\/p>/ig, "");

      $("#case-description-hidden").val(description);

      $("#support-edit-form").submit();

    });

  });
</script>

<div class="container-fluid px-0">
  <div class="px-5 mx-5">
    <div class="row page-header">
      @include('modules.page-title')
      <span class="float-right page-controller" style="margin-left: auto;">
      <a class="btn btn-outline-primary btn-md" href="{{ action('Support\SupportController@index') }}"><em class="fa fa-list"></em> Manage Support Case</a>
      </span>
    </div>
  </div>
</div>

<div class="container-fluid card">
  <div class="row">
    <div class="col-md-12 col-lg-12">
      <div class="container">
        <section class="border rounded m-3">
          <div class="row">
            <div class="col-md-12 col-lg-12">
              <div class="card card-header-actions h-100 card-new">
                <div class="card-body p-3">
                  <section class="border rounded bg-light-blue m-3">
                    <div class="card card-header-actions h-100 border-0 bg-light-blue mb-2">
                      <div class="card-body p-3">
                        <!-- <div class="preloader" id="support_form_preloader"><div class="lds-ripple"><div></div><div></div></div></div> -->
                        <form name="support-edit-form" id="support-edit-form" method="post" action="{{ action('Support\SupportController@update') }}">
                          @method('post')
                          @csrf

                          <input type="hidden" class="" id="case_id" name="case_id" value="{{ $data['case_details']->id }}">

                          <div class="row col-md-12">

                          <div class="col-md-4">
                              <div class="form-group row col-md" id="source-area">
                                <label for="sub_topic" class="col-form-label required">Source</label>
                                <select name="source_id" class="form-control custom-select select2" id="source_id">
                                  <option value="">--Select Source--</option>
                                  @foreach($data['source'] as $item)
                                      <option value="{{ $item->id }}" {{ (old('source_id', $data['case_details']->support_source_id) == $item->id) ?  'selected="selected"' : ''}}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-group row col-md" id="type-area">
                                <label for="sub_topic" class="col-form-label required">Case Type</label>
                                <select name="type_id" class="form-control custom-select select2" id="type_id">
                                  <option value="">--Select Source--</option>
                                  @foreach($data['types'] as $item)
                                      <option value="{{ $item->id }}" {{ (old('type_id', $data['case_details']->type_id) == $item->id) ?  'selected="selected"' : ''}}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                              </div>
                            </div>


                            <div class="col-md-4">
                              <div class="form-group row col-md" id="channel-area">
                                <label for="channel_id" class="col-form-label required">Channel</label>
                                  <select name="channel_id" class="form-control custom-select select2" id="channel_id">
                                    <option value="">--Select Channel--</option>
                                    @foreach($data['channels'] as $item)
                                      <option value="{{ $item->id }}" {{ (old('channel_id', $data['case_details']->source_channel_id) == $item->id) ?  'selected="selected"' : ''}}>{{ $item->name }}</option>
                                    @endforeach
                                  </select>
                              </div>
                            </div>

                          </div>

                            <div class="row col-md-12">

                              <div class="col-md-4">
                                <div class="form-group row col-md" id="impact-area">
                                  <label for="impact" class="col-form-label required">Impact</label>
                                  <select name="impact_id" class="form-control custom-select select2" id="impact_id">
                                    <option value="">--Select Impact--</option>
                                    @foreach($data['impact'] as $item)
                                        <option value="{{ $item->id }}" {{ (old('impact_id', $data['case_details']->impact_id) == $item->id) ?  'selected="selected"' : ''}}>{{ $item->name }}</option>
                                      @endforeach
                                  </select>
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-group row col-md" id="topic-area">
                                  <label for="topic" class="col-form-label required">Topic</label>
                                  <select name="topic_id" class="form-control custom-select select2" id="topic_id">
                                    <option value="">--Select Topic--</option>
                                    @foreach($data['topic'] as $item)
                                        <option value="{{ $item->id }}" {{ (old('topic_id', $data['case_details']->topic_id) == $item->id) ?  'selected="selected"' : ''}}>{{ $item->name }}</option>
                                      @endforeach
                                  </select>
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-group row col-md" id="subtopic-area">
                                  <label for="sub_topic" class="col-form-label required">Sub Topic</label>
                                  <select name="subtopic_id" class="form-control custom-select select2" id="subtopic_id">
                                    <option value="">--Select Sub Topic--</option>
                                      @foreach($data['subtopic'] as $item)
                                        <option parent_topic_id="{{ $item->topic_id }}" value="{{ $item->id }}" {{ (old('subtopic_id', $data['case_details']->sub_topic_id) == $item->id) ?  'selected="selected"' : ''}} >{{ $item->name }}</option>
                                      @endforeach
                                  </select>
                                </div>
                              </div>

                            </div>

                          <div class="row col-md-12">

                            <div class="col-md-4">

                              <div class="form-group row col-md" id="priority-area">
                                <label for="priority" class="col-form-label required">Priority</label>
                                <select name="priority_id" class="form-control custom-select select2" id="priority_id">
                                  <option value="">--Select Priority--</option>
                                    @foreach($data['priority'] as $item)
                                      <option value="{{ $item->id }}" {{ (old('priority_id', $data['case_details']->priority_id) == $item->id) ?  'selected="selected"' : ''}}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-group row col-md" id="case_number-area">
                                <label for="case_number" class="col-form-label required">Case Number</label>
                                <input type="text" class="form-control custom-select" id="case_number" name="case_number" placeholder="1233245" value="{{ old('case_number', $data['case_details']->case_number) }}">
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-group row col-md" id="requester-area">
                                <label for="requester" class="col-form-label required">Requester Category</label>
                                <select name="requester" class="form-control custom-select select2" id="requester">
                                  <option value="">--Select Requester--</option>
                                    @foreach($data['requester'] as $item)
                                      <option value="{{ $item->id }}" {{ (old('requester', $data['case_details']->requester_type) == $item->id) ?  'selected="selected"' : ''}}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                              </div>
                            </div>

                          </div>

                          <div class="row col-md-12">

                            <div class="col-md-4">
                              <div class="form-group row col-md" id="snow_reference-area">
                                <label for="snow_reference" class="col-form-label">SNOW Reference</label>
                                <input type="text" class="form-control custom-select" id="snow_reference" name="snow_reference" placeholder="INC9987656" value="{{ old('snow_reference', $data['case_details']->snow_reference) }}">
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-group row col-md" id="jira_reference-area">
                                <label for="jira_reference" class="col-form-label">IT Release Reference</label>
                                <input type="text" class="form-control custom-select" id="jira_reference" name="jira_reference" placeholder="RTC 6543" value="{{ old('jira_reference', $data['case_details']->jira_reference) }}">
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-group row col-md" id="jira_created_at-area">
                                <label for="jira_created_at" class="col-form-label">IT Release Ref Created At</label>
                                <input type="text" class="form-control date-picker custom-select" id="jira_created_at" name="jira_created_at" value="{{ old('jira_created_at', ($data['case_details']->jira_creation_date != null) ? date('d-M-Y H:i:s', strtotime($data['case_details']->jira_creation_date)) : null)}}">
                              </div>
                            </div>


                            </div>


                          <div class="row col-md-12">

                            <div class="col-md-3">
                              <div class="form-group row col-md">
                                <label for="partner_id" class="col-form-label required">Case Opened At</label>
                                <input type="text" class="form-control date-picker custom-select" onpaste="return false;" ondrop="return false;" autocomplete="off" id="case_opened_at" name="case_opened_at"  value="{{ date('d-M-Y H:i:s', strtotime($data['case_details']->case_opened_at)) }}" >
                              </div>
                            </div>

                            <div class="col-md-9">
                              <div class="form-group row col-md" id="title-area">
                                <label for="title" class="col-form-label required">Title</label>
                                <input type="text" class="form-control custom-select" id="title" name="title" placeholder="Title" value="{{ $data['case_details']->title }}">
                              </div>
                            </div>

                          </div>


                          <div class="row col-md">
                            <div class="form-group col-md col-md-12" id="description-area">
                                  <label for="title" class="col-form-label required">Description</label>
                            </div><br>
                            <div class="pb-0 col-md">
                              <div class="Case-description-box" id="Case-description-box">
                                <div id="editor">
                                <?=$data['case_details']->description ?>
                                </div>
                                <input type="hidden" name="description" id="case-description-hidden">
                            </div>
                          </div>

                          </div>

                          <hr class="border">

                          <div class="text-center px-0">
                            <button id="case-update-btn" class="btn btn-outline-info o-button btn-md">Update</button>
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
    <div>
  </div>
</div>

@endsection
