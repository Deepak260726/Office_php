  <div class="row px-5">
    <div class="col-12">
      <div class="py-5 px-3">
        <div class="clearfix">
          <div class="float-left">
            <h5 class="c-grey-900 mb-0"><em class="fa fa-envelope"></em> Email Log</h5>
          </div>
          <div class="float-right">
            <a href="{{ url('maillogs/?module='.$data['email_log_module'].'&mapped_id='.$data['email_log_mapped_id']) }}" class="btn cur-p btn-outline-primary btn-sm">View All</a>
          </div>
        </div>
      </div>
      <div class="">
        <table class="table thead-light table-bordered table-hover table-sm bg-white">
          <caption></caption>
            <thead>
                <tr>
                    <th scope="col" style="width:50px;">ID</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Email TO</th>
                    <th scope="col">Sent</th>
                    <th scope="col">Updated At</th>
                    <th scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @if($data['email_log']->count() > 0)
                    @foreach ($data['email_log'] as $log)
                        <tr>
                            <td>{{ $log->id }}</td>
                            <td>{{ $log->subject }}</td>
                            <td>{{ str_replace(',', ', ', $log->email_to) }}</td>
                            <td class="text-center"><span class="badge {{ ($log->sent  == 'N') ? 'badge badge-pill badge-danger' : 'badge badge-pill badge-success'}} px-2 py-1">{{ $log->sent }}</span></td>
                            <td>{{ $log->updated_at->format('d-M-Y H:i:s') }}</td>
                            <td>
                              <button type="button"  class="btn btn-outline-info btn-sm o-button" data-toggle="modal" data-target="#modalEmailLog{{$log->id}}"><em class="fa fa-envelope"></em></button>
                              <div class="modal fade" id="modalEmailLog{{$log->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                 <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                       <div class="modal-header bg-primary">
                                          <h5 class="modal-title text-white" id="modalNewReportLabel{{$log->id}}">Email Log - {{ $log->id }}</h5>
                                          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"></button>
                                       </div>
                                       <div class="modal-body">
                                         <div class="form-group row">
                                            <label for="email_to{{$log->id}}" class="col-sm-2 col-form-label">To</label>
                                            <div class="col-sm-10">
                                              <input type="text" class="form-control" id="email_to{{$log->id}}" name="email_to{{$log->id}}" value="{{$log->email_to}}" readonly="readonly">
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <label for="email_cc{{$log->id}}" class="col-sm-2 col-form-label">CC</label>
                                            <div class="col-sm-10">
                                              <input type="text" class="form-control" id="email_cc{{$log->id}}" name="email_cc{{$log->id}}" value="{{$log->email_cc}}" readonly="readonly">
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <label for="email_bcc{{$log->id}}" class="col-sm-2 col-form-label">BCC</label>
                                            <div class="col-sm-10">
                                              <input type="text" class="form-control" id="email_bcc{{$log->id}}" name="email_bcc{{$log->id}}" value="{{$log->email_bcc}}" readonly="readonly">
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <label for="subject{{$log->id}}" class="col-sm-2 col-form-label">Subject</label>
                                            <div class="col-sm-10">
                                              <input type="text" class="form-control" id="subject{{$log->id}}" name="subject{{$log->id}}" value="{{$log->subject}}" readonly="readonly">
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <label for="updated_at{{$log->id}}" class="col-sm-2 col-form-label">Updated At</label>
                                            <div class="col-sm-6">
                                              <input type="text" class="form-control" id="updated_at{{$log->id}}" name="updated_at{{$log->id}}" value="{{$log->updated_at->format('d-M-Y H:i:s')}}" readonly="readonly">
                                            </div>
                                            <label for="sent{{$log->id}}" class="col-sm-1 col-form-label">Sent</label>
                                            <div class="col-sm-3">
                                              <span class="badge {{ ($log->sent  == 'N') ? 'badge badge-pill badge-danger' : 'badge badge-pill badge-success'}} px-4 py-2">{{ $log->sent }}</span>
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Attachment</label>
                                            <div class="col-sm-10">
                                              <?php
                                               $attachements = App\Helpers\MailMan::getAttachmentsList($log->attachments);
                                              ?>
                                              @foreach($attachements as $attachement)
                                                <?php
                                                  $file = explode('niya/storage/', str_replace('\\', '/', $attachement['file']));
                                                  if(isset($file[1])) {
                                                    echo '<a target="_blank" rel="noopener" href="'.action('FileSystem\DownloadController@index').'?file='.$file[1].'">'.$attachement['file_name'].'</a>';
                                                  }else {
                                                    echo '<a href="#">'.$attachement['file_name'].'</a>';
                                                  }
                                                ?>

                                              @endforeach
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <div class="col-sm-12">
                                              <iframe title="" width="765px"; height="250px" src="{{ htmlspecialchars('data:text/html,' . rawurlencode($log->body_html)) }}" style="border:1px solid #d4d4d4;"></iframe>
                                            </div>
                                          </div>
                                       </div>
                                       <div class="modal-footer">
                                          <button type="button" class="btn btn-outline-secondary btn-md" data-dismiss="modal">Close</button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        @if($data['email_log']->count() == 0)
            <div class="alert alert-info">No email logs found.</div>
        @endif
      </div>
    </div>
  </div>
