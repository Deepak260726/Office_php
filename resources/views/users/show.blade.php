@extends('layouts.app')

@section('content')
<script language="javascript" type="text/javascript">
$(document).ready(function() {
  // Secondary Email - Copy from Email
  $("#email").on('keyup change', function(){
    $('#secondary_email').val($('#email').val());
    });
  $('#email').trigger('change');

  // Company
  $('#company').val('CMA CGM Group');

  // Designation
  $('#designation').val('eCommerce');

  // Timezone
  $("#country").on('keyup change', function(){
      if(this.value == 'IN') {
        $('#timezone').val('Asia/Kolkata');
      }else if(this.value == 'HK') {
        $('#timezone').val('Asia/Hong_Kong');
      }else if(this.value == 'AU') {
        $('#timezone').val('Australia/Sydney');
      }else if(this.value == 'SG') {
        $('#timezone').val('Asia/Singapore');
      }else if(this.value == 'FR') {
        $('#timezone').val('Europe/Paris');
      }else if(this.value == 'NL') {
        $('#timezone').val('Europe/Amsterdam');
      }else if(this.value == 'US') {
        $('#timezone').val('America/New_York');
      }else if(this.value == 'BR') {
        $('#timezone').val('America/Sao_Paulo');
      }else if(this.value == 'SN') {
        $('#timezone').val('Africa/Dakar');
      }else {
        $('#timezone').val('');
      }
    });
  $('#country').trigger('change');

  $("#form_user_profile_submit").click(function() {
    // Remove existing Toaster
    toastr.remove();

    // Form Validation
    $("#form_user_profile").validate({
      errorClass: "is-invalid",
      errorPlacement: function(error,element) {
        var elementName = element.attr("name");
        elementName = ucwords(elementName.replace("_", " "));

        toastr.error(elementName +": "+ error.text(), '', {preventDuplicates: true, progressBar: true, timeOut: 10000, extendedTimeOut: 5000})
        return true;
      },
      rules: {
        authentication_mode: {
          required: true
        },
        first_name: {
          required: true,
          minlength: 3,
          maxlength: 50
        },
        last_name: {
          required: true,
          minlength: 3,
          maxlength: 50
        },
        email: {
          required: true,
          email: true,
          maxlength: 100
        },
        secondary_email: {
          required: true,
          email: true,
          maxlength: 100
        },
        phone: {
          required: false,
          minlength: 3,
          maxlength: 25
        },
        company: {
          required: true
        },
        designation: {
          required: true,
          minlength: 3,
          maxlength: 50
        },
        location: {
          required: true,
          minlength: 3,
          maxlength: 50
        },
        country: {
          required: true
        },
        timezone: {
          required: true
        },
      }
    });



    // Form Submit
    $("#form_user_profile").submit();
  });
});
</script>

<div class="container-fluid px-0">
  <div class="px-5 mx-5">
    <div class="row page-header">
      @include('modules.page-title')
      <span class="float-right page-controller" style="margin-left: auto;">
        <a href="{{ url('users') }}" class="btn btn-outline-primary btn-md">Back</a>
        @include('users._partials.options-button-sub-menu')

        @if($data['user']->active == 'Y')
          <button type="button" class="btn btn-outline-danger btn-md" data-toggle="modal" data-target="#modalDeactivateUser"><em class="fa fa-times-circle"></em> Deactivate</button>
          <!-- Modal - User Deactivate -->
          <div class="modal fade" id="modalDeactivateUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
             <div class="modal-dialog" role="document">
                <div class="modal-content">
                   <div class="modal-header bg-danger">
                      <h5 class="modal-title text-white" id="exampleModalLabel">Confirm to deactivate User</h5>
                      <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"></button>
                   </div>
                   <div class="modal-footer">
                      <form id="user-deactivate-form" action="{{ action('Users\UserController@deactivate', ['user_id' => $data['user']->id]) }}" method="POST">
                         @csrf
                      </form>
                      <button type="button" class="btn btn-outline-secondary btn-md" data-dismiss="modal">Cancel</button>
                      <button type="button" class="btn btn-outline-danger btn-md" onclick="event.preventDefault(); document.getElementById('user-deactivate-form').submit();">Confirm</button></div>
                </div>
             </div>
          </div>
          <!-- / Modal - User Deactivate -->
        @else
          <button type="button" class="btn btn-outline-success btn-md" data-toggle="modal" data-target="#modalActivateUser"><em class="fa fa-check"></em> Activate</button>
            <!-- Modal - User Activate -->
            <div class="modal fade" id="modalActivateUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog" role="document">
                  <div class="modal-content">
                     <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white" id="exampleModalLabel">Confirm to Activate User</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-footer">
                        <form id="user-activate-form" action="{{ action('Users\UserController@activate', ['user_id' => $data['user']->id]) }}" method="POST">
                           @csrf
                        </form>
                        <button type="button" class="btn btn-outline-secondary btn-md" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-outline-danger btn-md" onclick="event.preventDefault(); document.getElementById('user-activate-form').submit();">Confirm</button></div>
                  </div>
               </div>
            </div>
            <!-- / Modal - User Activate -->
        @endif
        <button type="button" class="btn btn-outline-success btn-md" id="form_user_profile_submit"><em class="fa fa-save"></em> Save</button>
      </span>
    </div>
  </div>


  <form id="form_user_profile" name="form_user_profile" method="POST" action="{{ action('Users\UserController@updateUser', ['user_id' => $data['user']->id]) }}">
    @method('post')
    @csrf
    <div class="row px-5">
      <div class="col-6">
        <div class="card py-5 px-3">
          <div class="form-group row">
            <label for="id" class="col-sm-3 col-form-label">Id</label>
            <div class="col-sm-9"><input type="text" class="form-control" id="id" placeholder="id" readonly="readonly" value="{{$data['user']->id}}"></div>
          </div>
          <div class="form-group row">
            <label for="authentication_mode" class="col-sm-3 col-form-label">Auth Mode</label>
            <div class="col-sm-9">
              <Select name="authentication_mode" id="authentication_mode" class="form-control {{ ($errors->has('authentication_mode') == TRUE ? 'is-invalid' : null) }}">
                <option value="">-</option>
                <option value="APP" {{(old('authentication_mode', $data['user']->authentication_mode) == 'APP' ? 'selected="selected"' : '')}}>APP</option>
                <option value="LDAP" {{(old('authentication_mode', $data['user']->authentication_mode) == 'LDAP' ? 'selected="selected"' : '')}}>LDAP</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="domain" class="col-sm-3 col-form-label">Domain</label>
            <div class="col-sm-9">
            <Select name="domain" id="domain" class="form-control {{ ($errors->has('domain') == TRUE ? 'is-invalid' : null) }}">
                <option value="">-</option>
                @foreach($data['domain_list'] as $domain)
                  <option value="{{$domain[0]}}"  {{(old('domain', $data['user']->domain) == $domain[0]) ? 'selected="selected"' : ''}} >{{$domain[1]}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="first_name" class="col-sm-3 col-form-label">First Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="{{ old('first_name', request('first_name') ?? $data['user']->first_name ?? null)}}">
            </div>
          </div>
          <div class="form-group row">
            <label for="last_name" class="col-sm-3 col-form-label">Last Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="{{ old('last_name', request('last_name') ?? $data['user']->last_name ?? null)}}">
            </div>
          </div>
          <div class="form-group row">
            <label for="email" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-9">
              <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email', request('email') ?? $data['user']->email ?? null)}}">
            </div>
          </div>
          <div class="form-group row">
            <label for="secondary_email" class="col-sm-3 col-form-label">Secondary Email</label>
            <div class="col-sm-9">
              <input type="email" class="form-control" id="secondary_email" name="secondary_email" placeholder="Secondary Email" value="{{ old('secondary_email', request('secondary_email') ?? $data['user']->secondary_email ?? null)}}">
            </div>
          </div>
          <div class="form-group row">
            <label for="company" class="col-sm-3 col-form-label">Company</label>
            <div class="col-sm-9">
              <Select name="company" id="company" class="form-control {{ ($errors->has('company') == TRUE ? 'is-invalid' : null) }}">
                <option value="">-</option>
                @foreach($data['company_list'] as $company)
                  <option value="{{$company[0]}}"  {{((old('company', $data['user']->company ?? null) == $company[0]) ? 'selected="selected"' : '')}} >{{$company[1]}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="team" class="col-sm-3 col-form-label">Team</label>
            <div class="col-sm-9">
              <Select name="team" id="team" class="form-control {{ ($errors->has('team') == TRUE ? 'is-invalid' : null) }}">
                <option value="">-</option>
                @foreach($data['team_list'] as $item)
                  <option value="{{ $item->id }}" {{ (old('team', $data['user']->team ?? null) == $item->id) ?  'selected="selected"' : ''}}>{{ $item->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </div>


      <div class="col-6">
        <div class="card py-5 px-3">

          <div class="form-group row">
            <label for="designation" class="col-sm-3 col-form-label">Designation</label>
            <div class="col-sm-9"><input type="text" class="form-control" id="designation" name="designation" placeholder="Designation" value="{{ old('designation', request('designation') ?? $data['user']->designation ?? null)}}"></div>
          </div>
          <div class="form-group row">
            <label for="location" class="col-sm-3 col-form-label">Location</label>
            <div class="col-sm-9"><input type="text" class="form-control" id="location" name="location" placeholder="Location" value="{{ old('location', request('location') ?? $data['user']->location ?? null)}}"></div>
          </div>
          <div class="form-group row">
            <label for="country" class="col-sm-3 col-form-label">Country</label>
            <div class="col-sm-9">
              <Select name="country" id="country" class="form-control {{ ($errors->has('country') == TRUE ? 'is-invalid' : null) }}">
                <option value="">-</option>
                @foreach($data['country_list'] as $item)
                  <option value="{{ $item->country_code }}" {{ (old('country', $data['user']->country ?? null) == $item->country_code) ?  'selected="selected"' : ''}}>{{ $item->country_name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="timezone" class="col-sm-3 col-form-label">TimeZone</label>
            <div class="col-sm-9">
              <Select name="timezone" id="timezone" class="form-control {{ ($errors->has('timezone') == TRUE ? 'is-invalid' : null) }}">
                <option value="">-</option>
                @foreach($data['timezone_list'] as $item)
                  <option value="{{ $item->id }}" {{ (old('timezone', $data['user']->timezone ?? null) == $item->id) ?  'selected="selected"' : ''}}>{{ $item->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="phone" class="col-sm-3 col-form-label">Phone</label>
            <div class="col-sm-9"><input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="{{ old('phone', request('phone') ?? $data['user']->phone ?? null)}}"></div>
          </div>
          <div class="form-group row">
            <label for="active" class="col-sm-3 col-form-label">Active</label>
            <div class="col-sm-9"><input type="text" class="form-control" id="active" name="active" placeholder="active" readonly="readonly" value="{{$data['user']->active}}"></div>
          </div>
          <div class="form-group row">
            <label for="email_verified" class="col-sm-3 col-form-label">Email Verification</label>
            <div class="col-sm-9"><input type="text" class="form-control" id="email_verified" name="email_verified" readonly="readonly" value="{{$data['user']->email_verified ?? 'N'}}"></div>
          </div>
          <div class="form-group row">
            <label for="email_verified_at" class="col-sm-3 col-form-label">Email Verified On</label>
            <div class="col-sm-9"><input type="text" class="form-control" id="email_verified_at" name="email_verified_at" placeholder="email_verified_at" readonly="readonly" value="{{ $data['user']->email_verified_at ?? '-'}}"></div>
          </div>
          <div class="form-group row">
            <label for="created_at" class="col-sm-3 col-form-label">Created at</label>
            <div class="col-sm-9"><input type="text" class="form-control" id="created_at" name="created_at" placeholder="created_at" readonly="readonly" value="{{$data['user']->created_at->format('d-M-Y H:i:s') ?? '-'}}"></div>
          </div>
          <div class="form-group row">
            <label for="updated_at" class="col-sm-3 col-form-label">Updated at</label>
            <div class="col-sm-9"><input type="text" class="form-control" id="updated_at" name="updated_at" placeholder="updated_at" readonly="readonly" value="{{$data['user']->updated_at->format('d-M-Y H:i:s') ?? '-'}}"></div>
          </div>
        </div>
      </div>
    </div>
  </form>

  <div class="row px-5">
    <div class="col-12">
      <div class="py-5 px-3">
        <div class="clearfix">
          <div class="float-left">
            <h5 class="c-grey-900 mb-0"><em class="fa fa-user-secret"></em> Audit Log - User Events</h5>
          </div>
          <div class="float-right">
            <a href="{{ url('auditlogs/?event_category=USER&mapped_id='.$data['user']->id) }}" class="btn cur-p btn-outline-primary btn-sm">View All</a>
          </div>
        </div>
      </div>
      <div class="">
        <table class="table thead-light table-bordered table-hover table-sm bg-white">
          <caption></caption>
            <thead>
                <tr>
                    <th scope="col" style="width:200px;">Event</th>
                    <th scope="col" style="width:200px;">Created at</th>
                    <th scope="col" style="width:150px;">User</th>
                    <th scope="col">Data</th>
                </tr>
            </thead>
            <tbody>
                @if($data['audit_log']->count() > 0)
                    @foreach ($data['audit_log'] as $log)
                        <tr>
                            <td>{{ $log->event }}</td>
                            <td>{{ $log->created_at->format('d-M-Y H:i:s') }}</td>
                            <td>{{ strtoupper($log->user->first_name.' '.substr($log->user->last_name,0,1)) }}</td>
                            <td>
                              @if(\App\Helpers\JsonHelper::isJson($log->data) === TRUE)
                                <?php $decoded = json_decode($log->data); ?>
                                <table class="table table-sm small">
                                  <caption></caption>
                                  <tr>
                                    <th scope="col" class="small">Field</th><th scope="col">Old</th><th scope="col">New</th>
                                  </tr>
                                  @foreach($decoded as $decoded_item)
                                    <tr class="small">
                                      <td>{{strtoupper($decoded_item->field)}}</td><td>{{$decoded_item->old}}</td><td>{{$decoded_item->new}}</td>
                                    </tr>
                                  @endforeach
                                </table>
                              @else
                                {{ $log->data }}
                              @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        @if($data['audit_log']->count() == 0)
            <div class="alert alert-info">No login history found.</div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
