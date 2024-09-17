<?php

namespace App\Http\Controllers\Support;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Support\SupportCase;
use App\Models\Support\BarCodeDetails;
use App\Models\Support\SupportCaseChannel;
use App\Models\Support\SupportCasePriority;
use App\Models\Support\SupportCaseImpact;
use App\Models\Support\SupportCaseTopic;
use App\Models\Support\SupportCaseSubTopic;
use App\Models\Support\SupportCaseSource;
use App\Models\Support\SupportCaseType;
use App\Models\Support\SupportCaseResolutionType;
use App\Models\Support\SupportCaseStatus;
use App\Models\Support\SupportCaseRequester;
use App\Exports\Support\SupportReport;

use App\Constants\SupportConstant;

use Validator;
use App\Helpers\AuditLogActivity;
use Illuminate\Support\Facades\Log;

class SupportController extends Controller
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
   * Redirect to Dashboard
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('support.list');
  }

  public function search(Request $request)
  {
        $barcode = $request->input('barcode');
        
        // Perform the search query
        $results = BarCodeDetails::where('barCodeNumber', $barcode)->get(); // Adjust based on your model and field
        
         
        // Return results as a view or JSON
        if ($results === null || $results->isEmpty()) {
          // Handle the case where no results are found
          return back()->withInput()->with('error', 'No results found.');
      }
        
        return response()->json(['results' => $results]);
  }

}