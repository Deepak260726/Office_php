@extends('layouts.app')

@section('content')
<script>
  $(document).ready(function() {

    window.case_id = '<?php echo $data['case_details']->id; ?>';

    $('#case_list_preloader').hide();
    $('#project_info_preloader').hide();

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

    /** Add Project Comment */

    $("#add-comment-form").submit(function(e) {
      e.preventDefault();


      var comment_type = $('#add-comment-form #comment_type').val();

      var comment = quill.root.innerHTML
          .replace(/<p><\/p>/ig, "")
          .replace(/<p><br><\/p>/ig, "")
          .replace(/<p><br\/><\/p>/ig, "")
          .replace(/<p>&nbsp;<\/p>/ig, "");
      
      if(comment_type == '' || comment == '') {

        toastr.error('Comment type & Commet are Mandatory!', {
              preventDuplicates: true,
              progressBar: true,
              timeOut: 5000,
              extendedTimeOut: 3000
        });

      } else {

        $('#comment-submit-btn').prop('disabled', true);
        $('#comment-submit-btn').html('Adding...');

          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });

        $.ajax({  
            type:'POST',
            url:"{{ url('/api/support/addComment') }}",
            data:{
              'case_id' : case_id,
              'comment_type': comment_type,
              'Comment': comment
            },
            attemptCount : 1,
            retryLimit : 3,
            success:function(result) {
              toastr.success('New Comment Added Successfully', {
                  preventDuplicates: true,
                  progressBar: true,
                  timeOut: 5000,
                  extendedTimeOut: 3000
              });
              $("#modalAddComment").modal('hide');
              $("#add-comment-form")[0].reset();
              $('#comment-submit-btn').prop('disabled', false);
              $('#comment-submit-btn').html('Add');
              getComments();
            },
            error: function() {
              this.attemptCount++;

              if(this.attemptCount <= this.retryLimit) {
                
                toastr.warning('An error has occured while saving the comment. Retrying... ' + this.attemptCount, {
                  preventDuplicates: true,
                  progressBar: true,
                  timeOut: 5000,
                  extendedTimeOut: 3000
                });

                // Try again after 5 sec
                sleep(5000);
                $.ajax(this);  

                return;
              }else {
                // Retry Limit Reached
                toastr.error('An error has occured while saving the comment. Max retry attempt reached.', {
                  preventDuplicates: true,
                  progressBar: true,
                  timeOut: 5000,
                  extendedTimeOut: 3000
                });
              }
            }
          });
        }

    });


    function getComments() {

      $.ajax({  
          type:'get',
          url:"{{ url('/api/support/getComments') }}",
          data:{
            'case_id' : case_id
          },
          attemptCount : 1,
          retryLimit : 3,
          success:function(result){
            $('#case_comments_list').html(result);
            $('#case_comments_list_preloader').hide();
          },
          error: function() {
            this.attemptCount++;

            if(this.attemptCount <= this.retryLimit) {
              
              toastr.warning('An error has occured while fetching the comments. Retrying... ' + this.attemptCount, {
                preventDuplicates: true,
                progressBar: true,
                timeOut: 5000,
                extendedTimeOut: 3000
              });

              // Try again after 5 sec
              sleep(5000);
              $.ajax(this);  

              return;
            }else {
              // Retry Limit Reached
              toastr.error('An error has occured while fetching the comments. Max retry attempt reached.', {
                preventDuplicates: true,
                progressBar: true,
                timeOut: 5000,
                extendedTimeOut: 3000
              });
            }
          }
        });
    }

    var quillClosure = new Quill('#closure-comment-editor', {
      theme: 'snow',
      modules: {
        toolbar: toolbarOptions
      }
    });

    // Disabling Editor to avoid auto focus
    quillClosure.enable(false);

    // Enable the editor now
    quillClosure.enable();

    // Set Existing HTML Content
    //var existingHtmlContent = '';
    //quill.clipboard.dangerouslyPasteHTML(0, existingHtmlContent);

    quillClosure.clipboard.addMatcher(Node.ELEMENT_NODE, (node, delta) => {
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

    $('#update-status-form').submit(function(e) {
      e.preventDefault();

      var resolution_type = $('#update-status-form #resolution_type').val();

      if(resolution_type == '') {

        toastr.error('Choose Resolution Type is Mandatory', {
              preventDuplicates: true,
              progressBar: true,
              timeOut: 5000,
              extendedTimeOut: 3000
            });

      } else {
        $("#modalAddClosureComment").modal('show');
      }
    });


    $("#add-closure-comment-form").submit(function(e) {
      e.preventDefault();

      var resolution_type = $('#update-status-form #resolution_type').val();

      var closure_comment = quillClosure.root.innerHTML
          .replace(/<p><\/p>/ig, "")
          .replace(/<p><br><\/p>/ig, "")
          .replace(/<p><br\/><\/p>/ig, "")
          .replace(/<p>&nbsp;<\/p>/ig, "");

      if(closure_comment == '') {
        toastr.error('Please enter closure comment!', {
              preventDuplicates: true,
              progressBar: true,
              timeOut: 5000,
              extendedTimeOut: 3000
            });
      } else {

      $('#closure-comment-submit-btn').prop('disabled', true);
      $('#closure-comment-submit-btn').html('updating...');

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({  
          type:'POST',
          url:"{{ url('/api/support/updateCaseStatus') }}",
          data:{
            'case_id' : case_id,
            'resolution_type': resolution_type,
            'closure_comment': closure_comment
          },
          attemptCount : 1,
          retryLimit : 3,
          success:function(result) {
            $("#modalAddClosureComment").modal("hide");
            $("#update-status-form :input").prop('disabled', true);
            $('#closure-comment-submit-btn').prop('disabled', false);
            $('#closure-comment-submit-btn').html('Update');
            toastr.success('Case status Updated Successfully', {
                preventDuplicates: true,
                progressBar: true,
                timeOut: 5000,
                extendedTimeOut: 3000
            });
            getComments();
          },
          error: function() {
            this.attemptCount++;

            if(this.attemptCount <= this.retryLimit) {
              
              toastr.warning('An error has occured while updating the status. Retrying... ' + this.attemptCount, {
                preventDuplicates: true,
                progressBar: true,
                timeOut: 5000,
                extendedTimeOut: 3000
              });

              // Try again after 5 sec
              sleep(5000);
              $.ajax(this);  

              return;
            }else {
              // Retry Limit Reached
              toastr.error('An error has occured while updating the status. Max retry attempt reached.', {
                preventDuplicates: true,
                progressBar: true,
                timeOut: 5000,
                extendedTimeOut: 3000
              });
            }
          }
        });
      }
      
    });

    getComments();

  });
</script>

<div class="container-fluid px-0">
  <div class="px-5 mx-5">
    <div class="row page-header">
      @include('modules.page-title')
      <span class="float-right page-controller" style="margin-left: auto;">
        <a class="btn btn-outline-primary btn-md" href="{{ action('Support\SupportController@index') }}"><em class="fa fa-list"></em> Manage Support Case</a>
        <a class="btn btn-outline-success btn-md" href="{{ action('Support\SupportController@create') }}"><em class="fa fa-plus-circle"></em> New Case</a>
      </span>
    </div>
  </div>

  <div class="px-0 mx-2 mb-5">
    <div class="row">

      <!-- LEFT MODULES -->
      <div class="col-3">
        <!-- Case Information -->
        <div class="card py-0 px-0 card-new">
          <div class="preloader dummy-preloader" id="project_info_preloader"><div class="lds-ripple"><div></div><div></div></div></div>
            <div class="card-header">
              Case Information
              <div class="text-right text-xs card-header-action button-options"><a class="btn btn-sm btn-link text-primary" href="{{ url('support/edit/'.$data['case_details']->id) }}"><em class="fas fa-edit"></em></a></div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-4">Case Id:</div>
                <div class="col-8 font-weight-bold">{{ $data['case_details']->case_number ?? $data['case_details']->id }}</div>
              </div>
              <div class="row pt-3">
                <div class="col-4">Channel:</div>
                <div class="col-8 font-weight-bold">{{ $data['case_details']->SupportCaseChannel->name }}</div>
              </div>
              <div class="row pt-3">
                <div class="col-4">Impact:</div>
                <div class="col-8 font-weight-bold"><em class="text-{{ $data['case_details']->SupportCaseImpact->color_category }} fas {{ $data['case_details']->SupportCaseImpact->icon }}"></em> {{ $data['case_details']->SupportCaseImpact->name }}</div>
              </div>
              <div class="row pt-3">
                <div class="col-4"> Priority: </div>
                <div class="col-8 font-weight-bold">{!! App\Helpers\SupportHelper::getPriorityHtml($data['case_details']->priority_id, $data['case_details']->SupportCasePriority->name) !!}</div>
              </div>
              <div class="row pt-3">
                <div class="col-4"> Source: </div>
                <div class="col-8 font-weight-bold">{{ $data['case_details']->SupportCaseSource->name }}</div>
              </div>
              <div class="row pt-3">
                <div class="col-4"> Topic: </div>
                <div class="col-8 font-weight-bold">{{ $data['case_details']->SupportCaseTopic->name }}</div>
              </div>

              <div class="row pt-3">
                <div class="col-4"> Sub Topic: </div>
                <div class="col-8 font-weight-bold">{{ $data['case_details']->SupportCaseSubTopic->name }}</div>
              </div>

              <div class="row pt-3">
                <div class="col-4"> Case Type: </div>
                <div class="col-8 font-weight-bold">{{ $data['case_details']->SupportCaseType->name }}</div>
              </div>

              <div class="row pt-3">
                <div class="col-4"> Opened At: </div>
                <div class="col-8 font-weight-bold"> {{ $data['case_details']->case_opened_at->format('d-M-Y H:i:s') }}</div>
              </div>

              <div class="row pt-3">
                <div class="col-4"> Requester Category: </div>
                <div class="col-8 font-weight-bold">{{ $data['case_details']->SupportCaseRequester->name }}</div>
              </div>

              <div class="row pt-3">
                <div class="col-4"> Snow Reference: </div>
                <div class="col-8 font-weight-bold">{{ $data['case_details']->snow_reference ?? '-' }}</div>
              </div>

              <div class="row pt-3">
                <div class="col-4"> IT Release Reference: </div>
                <div class="col-8 font-weight-bold">{{ $data['case_details']->jira_reference ?? '-' }}</div>
              </div>

              <div class="row pt-3">
                <div class="col-4"> IT Release Ref Created At: </div>
                <div class="col-8 font-weight-bold"> {{ ($data['case_details']->jira_creation_date) ? strtoupper($data['case_details']->jira_creation_date->format('d-M-Y H:i:s')) : '-' }} </div>
              </div>
              
            </div>
          </div>
      </div>

      <!-- CENTER MODULES -->
      <div class="col-md-7 col-lg-7">

        <div class="card py-0 px-0 card-new">
          <div class="card-header text-left d-block">
            <em class="page-title-icon fa fa-building"></em> Description
          </div>
          <div class="card-body">
            {!! App\Helpers\GlobalHelper::encode_html_excluding_allowed_tags($data['case_details']->description) !!}
          </div>
        </div>

        <div class="card py-0 px-0 card-new">
          <div class="card-header text-left">
            <span><em class="page-title-icon fa fa-comment"></em> Comments</span>
            <div class="text-right text-xs  button-options">
              <a class="btn btn-sm btn-link text-primary" id="add-comment" data-toggle="modal" data-target="#modalAddComment" href="#"><em class="fas fa-plus-square"></em> Add Comments</a>
            </div>
          </div>
          <div class="card-body">
            <div>
              <div class="preloader" id="case_comments_list_preloader">
              <div class="lds-ripple">
                    <div></div>
                    <div></div>
              </div>
              </div>
              <div class="case-activity-list" id="case_comments_list">
              </div>
            </div>
          </div>
        </div>
        
      </div>

      <!-- RIGHT MODULES -->
      <div class="col-2">
        <div class="card">
          <section class="border rounded bg-light-blue m-3">
              <div class="card card-header-actions h-100 border-0 bg-light-blue mb-2">
                <div class="card-header">
                  <h5 class="c-grey-900 p-2"><em class="page-title-icon fa fa-wrench"></em> Resolve Case </h5>
                </div>
                <div class="card-body p-3">
                  <form name="update-status-form" id="update-status-form" method="post" action="#">
                    @method('post')
                    @csrf
                    <div class="pb-3">
                      <label for="resolution_type" class="required">Resolution Type</label>
                      <select name="resolution_type" class="form-control custom-select" id="resolution_type" required {{ ($data['case_details']->status_id == App\Constants\SupportConstant::CASE_CLOSED) ?  'disabled' : ''}} >
                        <option value="">--Select Resolution Type--</option>
                        @foreach($data['case_resolution_type'] as $item)
                          <option value="{{ $item->id }}" {{ ($data['case_details']->resolution_type_id == $item->id) ?  'selected="selected"' : ''}}>{{ $item->name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <hr class="border">
                    <div class="text-center px-0">
                      <button type="submit" class="btn btn-outline-info o-button btn-md" href="#" {{ ($data['case_details']->status_id == App\Constants\SupportConstant::CASE_CLOSED) ?  'disabled' : ''}} >Update</button>
                    </div>
                  </form>
                </div>
              </div>
            </section>
        </div>
      </div>

    </div>
  </div>

</div>
    <!-- Modal - Add Comment -->
    <div class="modal fade" id="modalAddComment" tabindex="-1" role="dialog" aria-labelledby="modalAddCommentLabel" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-info">
            <h5 class="modal-title text-white" id="modalAddCommentLabel">Add Comment</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="add-comment-form" action="#" method="POST">
              @csrf
              @method('post')
              <input type="hidden" name="case_id" id="case_id" value="{{ $data['case_details']->id }}" />
              <div class="pb-3">
                <label for="name" class="required">Comment Type</label>
                <select name="comment_type" class="form-control custom-select select2" id="comment_type">
                  <option value="">--Select Comment Type--</option>
                  <option value="{{ App\Constants\SupportConstant::FIRST_ANALYSIS }}">{{ App\Constants\SupportConstant::FIRST_ANALYSIS }}</option>
                  <option value="{{ App\Constants\SupportConstant::COMMENT }}">{{ App\Constants\SupportConstant::COMMENT }}</option>
                </select>
              </div>

              <div class="pb-0">
              <label for="name" class="required">Comment</label>
                <div class="Case-add-comment-box" id="case_comment_box">
                  <div id="editor">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary btn-md" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-outline-info btn-md" id="comment-submit-btn">Add</button></div>
          </div>
        </form>
      </div>
    </div>
    <!-- / Modal - Add Comment -->

    <!-- Modal - Add Comment -->
    <div class="modal fade" id="modalAddClosureComment" tabindex="-1" role="dialog" aria-labelledby="modalAddClosureCommentLabel" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-info">
            <h5 class="modal-title text-white" id="modalAddClosureCommentLabel">Add Closure Comment</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="add-closure-comment-form" action="#" method="POST">
              @csrf
              @method('post')
              <input type="hidden" name="case_id" id="case_id" value="{{ $data['case_details']->id }}" />
              <div class="pb-3">
                <label for="name" class="required">Closure Comment</label>
              </div>

              <div class="pb-0">
                <div class="Case-add-comment-box" id="case_closure_comment_box">
                  <div id="closure-comment-editor">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary btn-md" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-outline-info btn-md" id="closure-comment-submit-btn" >Update</button></div>
          </div>
        </form>
      </div>
    </div>
    <!-- / Modal - Add Comment -->

    @endsection