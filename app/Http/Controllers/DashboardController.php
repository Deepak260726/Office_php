<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
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
        // Data Bag
        $data = array();
        //dd(\App::environment('production'));
        // Page Title
        $data['page_title'] = 'Dashboard';
        
        return view('welcome2')->with('data', $data);
    }
}
