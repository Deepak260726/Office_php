<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Yajra\Pdo\Oci8\Statement;

use App\Helpers\HeartbeatHelper;

class LaraController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        HeartbeatHelper::checkHeartbeat('LARA-DOCUMENTS-PUBLISHED-TABLE');
        /**$list = DB::connection('lara_qua')->table('sales_inv_headers')->select('*');
        $list->where('inv_number', 'NZEX0207762');
        dd($list->get());**/
        
        // Data Bag
        $data = array();
        //dd(\App::environment('production'));
        // Page Title
        $data['page_title'] = 'Invoice Receipts';
        $data['page_title_icon'] = 'fa-file-invoice-dollar';
        
        return view('dashboard')->with('data', $data);
    }
}
