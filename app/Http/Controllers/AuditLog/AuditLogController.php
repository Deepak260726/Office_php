<?php

namespace App\Http\Controllers\AuditLog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Auth;

use App\Models\AuditLogActivity as AuditLogActivityModel;
use App\Helpers\AuditLogActivity;

use View;
use Carbon;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Log;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class AuditLogController extends Controller
{
    public $message_bag;
    
    
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->message_bag = new MessageBag();
    }
    
    
    /**
     * Search Page
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Search Parameters
        $data = array();
        $data['event_category'] = strtoupper($request->event_category);
        $data['event'] = strtoupper($request->event);
        $data['mapped_id'] = $request->mapped_id;
        
        // Validation
        if($data['event_category'] == '' && $data['event'] == '') {
          $request->session()->flash('error', 'AuditLog - No Event or Event Category Selected');
          return redirect('dashboard');
        }
        
        // Get Audit Log
        $data['audit_log'] = AuditLogActivityModel::where('mapped_id', $data['mapped_id']);
        if($data['event_category'] != '')
          $data['audit_log']->where('event_category', $data['event_category']);
        if($data['event'] != '')
          $data['audit_log']->where('event', $data['event']);
        $data['audit_log'] = $data['audit_log']->latest()->limit(500)->get();
        
        
        // Set Page  Title
        $data['page_title'] = 'Audit Log';
        $data['page_title_icon'] = 'fa-cogs';
        //dd($data);
        return view('audit-log.list')->with('data', $data);
    }
    
}