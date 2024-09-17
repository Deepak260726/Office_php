<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

use App\Models\Projects\Project;
use App\Models\Projects\Milestone;
use App\Models\Projects\MilestoneEvents;
use App\Constants\ProjectConstant;
use App\Models\Projects\Comment;
use DB;

use Illuminate\Support\Facades\Log;

class DataFix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'datafix:updatemilestone';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For data Fixes';

    private $batch_run_id;
    

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->batch_run_id = uniqid();
    }
    

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info(Carbon::now()->format('Y-m-d H:i:s.v') . ' - ' . $this->batch_run_id . ' - Launching batch...');

        try {

            Log::info('DATA FIX - START');
            
            $this->updateProjects();
            
        }
        catch(\Exception $e) {
            report($e);
        }
        
        $this->info(Carbon::now()->format('Y-m-d H:i:s.v') . ' - ' . $this->batch_run_id . ' - Batch end');
        
        return 1;
    }



    private function updateProjects()
    {
        //get all API New deployment projects
        $query = Project::where('project_type_id', 'ND')
                ->where('channel_id', 'API');
                    
        $query->where(function ($q)  {
                $q->WhereRaw('(select count(b2b_onboarding_request_products.id)
                    from b2b_onboarding_request_products
                    where b2b_onboarding_request_products.project_id = projects.id) = 0');
            });
 
        $projects = $query->get();

        Log::info('DATA FIX - API PROJECTS COUNT : '. $projects->count());

        $project_updated_count = 0;


        foreach ($projects as $key => $project) {

            DB::beginTransaction();

            Log::info('DATA FIX - PROJECTS : '. $project->id);

            try {

                $data['project_details'] = Project::find($project->id);

                //check & update API products
                switch ($data['project_details']->product_id) {

                    // BILLS OF LADING - BLPDF - COPY
                    case "CBL":
                        if($data['project_details']->message_type_id != 'PDF') {
                            $data['project_details']->message_type_id = 'PDF';
                        }
                        break;

                    // BILLS OF LADING - DATA
                    case "BLD":
                        if($data['project_details']->message_type_id != 'JSON') {
                            $data['project_details']->message_type_id = 'JSON';
                        }
                        break;

                    // BILLS OF LADING - EVENTS
                    case "BLE":
                        if($data['project_details']->message_type_id != 'JSONH') {
                            $data['project_details']->message_type_id = 'JSONH';
                        }
                        break;

                    // BILLS OF LADING - ORIGINAL
                    case "OBL":
                        if($data['project_details']->message_type_id != 'JSON_PDF') {
                            $data['project_details']->message_type_id = 'JSON_PDF';
                        }
                        break;

                    // BOOKING
                    case "BKG":
                        $data['project_details']->product_id = 'BKR';
                        if($data['project_details']->message_type_id != 'JSONP') {
                            $data['project_details']->message_type_id = 'JSONP';
                        }
                        break;

                    // BOOKING - SHIPPING ORDER
                    case "BKS":
                        
                        if($data['project_details']->message_type_id == 'JSON') {
                            $data['project_details']->product_id = 'SHIP';
                        } else if($data['project_details']->message_type_id == 'JSONH') {
                            $data['project_details']->product_id = 'SHEV';
                        } else {
                            $data['project_details']->product_id = 'SHIP';
                            $data['project_details']->message_type_id = 'JSON';
                        }
                        break;

                    // BOOKING CONFIRMATION
                    case "BKC":
                        $data['project_details']->product_id = 'BKCP';
                        if($data['project_details']->message_type_id != 'PDF') {
                            $data['project_details']->message_type_id = 'PDF';
                        }
                        break;

                    // BOOKING REQUEST
                    case "BKR":
                        if($data['project_details']->message_type_id != 'JSONP') {
                            $data['project_details']->message_type_id = 'JSONP';
                        }
                        break;

                    // CUSTOMER SCHEDULES
                    case "SCC":
                        $data['project_details']->product_id = 'ROUT';
                        if($data['project_details']->message_type_id != 'JSON') {
                            $data['project_details']->message_type_id = 'JSON';
                        }
                        break;

                    // INVOICES
                    case "INV":
                        $data['project_details']->product_id = 'INC';
                        if($data['project_details']->message_type_id != 'JSON') {
                            $data['project_details']->message_type_id = 'JSON';
                        }
                        break;

                    // PRICING - CONTRACTS - QUOTATIONS
                    case "PRN":
                        $data['project_details']->product_id = 'PRC';
                        if($data['project_details']->message_type_id != 'JSON') {
                            $data['project_details']->message_type_id = 'JSON';
                        }
                        break;

                    // PRICING - INSTANT QUOTE & CONTRACTS
                    case "PRQ":
                        $data['project_details']->product_id = 'PRC';
                        if($data['project_details']->message_type_id != 'JSON') {
                            $data['project_details']->message_type_id = 'JSON';
                        }
                        break;

                    // SHIPPING INSTRUCTIONS
                    case "SI":
                        $data['project_details']->product_id = 'SIR';
                        if($data['project_details']->message_type_id != 'JSONP') {
                            $data['project_details']->message_type_id = 'JSONP';
                        }
                        break;

                    // SHIPPING INSTRUCTIONS - REQUEST
                    case "SIR":
                        if($data['project_details']->message_type_id != 'JSONP') {
                            $data['project_details']->message_type_id = 'JSONP';
                        }
                        break;

                    // TRACKING
                    case "TRK":
                        if($data['project_details']->message_type_id == 'JSONH') {
                            $data['project_details']->product_id = 'TRKEV';
                        }
                        break;
                }


                //update the product & message details
                if($data['project_details']->isDirty()) {

                    $data['project_details']->attention_points = $data['project_details']->attention_points." ".Carbon::now()->format('Y-m-d')." : Product/Message type updated by system, as part of datafix";
                    $data['project_details']->save();
                    Log::info('DATA FIX - PROJECTS PRODUCT/MESSAGE TYPE UPDATED : '. $data['project_details']->id);

                }

                //get list of project milstones events
                $project_milestones_events =  MilestoneEvents::where('project_id', $data['project_details']->id)->get();
                
                if($project_milestones_events != NULL) {

                    foreach($project_milestones_events as $milestones_events) {
                        
                        if($milestones_events->milestone_id == ProjectConstant::MILESTONE_NEW_DEMAND_VALIDATED) {

                            //update MILESTONE_NEW_DEMAND_VALIDATED
                            MilestoneEvents::where('project_id', $data['project_details']->id)
                                ->where('milestone_id', ProjectConstant::MILESTONE_NEW_DEMAND_VALIDATED)
                                ->update(['milestone_id' => ProjectConstant::MILESTONE_API_NEW_REQUEST]);

                        }

                        if($milestones_events->milestone_id == ProjectConstant::MILESTONE_UAT_TO_START) {

                            if($data['project_details']->product_id == 'BKR' || $data['project_details']->product_id == 'OBL' || $data['project_details']->product_id == 'SIR' ) {
                            
                                $uat_milestones = [ProjectConstant::MILESTONE_API_UAT_MSGSETUP, ProjectConstant::MILESTONE_API_UAT_PARTNER_GROUPING, ProjectConstant::MILESTONE_API_UAT_SCOPE_REQUEST, ProjectConstant::MILESTONE_API_UAT_SCOPE_COMPLETED];
        
                                foreach($uat_milestones as $new_milestone) {

                                    $this->createMilestones($new_milestone, $milestones_events, $data['project_details']);
                                
                                }
        
                            }

                        }

                        if($milestones_events->milestone_id == ProjectConstant::MILESTONE_UAT_IN_PROGRESS) {

                            if($data['project_details']->product_id == 'BKR' || $data['project_details']->product_id == 'OBL' || $data['project_details']->product_id == 'SIR' ) {
                            
                                $uat_milestones = [ProjectConstant::MILESTONE_API_UAT_INPROGRESS];
        
                                foreach($uat_milestones as $new_milestone) {
        
                                    $this->createMilestones($new_milestone, $milestones_events, $data['project_details']);
                                
                                }
        
                            }

                        }

                        if($milestones_events->milestone_id == ProjectConstant::MILESTONE_UAT_READY) {

                            if($data['project_details']->product_id == 'BKR' || $data['project_details']->product_id == 'OBL' || $data['project_details']->product_id == 'SIR' ) {
                            
                                $uat_milestones = [ProjectConstant::MILESTONE_API_UAT_COMPLETED];
        
                                foreach($uat_milestones as $new_milestone) {
        
                                    $this->createMilestones($new_milestone, $milestones_events, $data['project_details']);
                                
                                }
        
                            }

                        }

                        if($milestones_events->milestone_id == ProjectConstant::MILESTONE_GO_LIVE) {

                            $prod_milestones = [ProjectConstant::MILESTONE_API_PRD_MSGSETUP, ProjectConstant::MILESTONE_API_PRD_PARTNER_GROUPING, ProjectConstant::MILESTONE_API_PRD_SCOPE_REQUEST, ProjectConstant::MILESTONE_API_PRD_SCOPE_COMPLETED, ProjectConstant::MILESTONE_API_GOLIVE];

                            foreach($prod_milestones as $new_milestone) {
        
                                $this->createMilestones($new_milestone, $milestones_events, $data['project_details']);
                                
                            }

                        }
                        

                    }

                    $data['project_details']->attention_points = $data['project_details']->attention_points." ".Carbon::now()->format('Y-m-d')." : Project milestones updated by system, as part of datafix";
                    $data['project_details']->save();

                    Log::info('DATA FIX - PROJECTS MILESTONES UPDATED : '. $data['project_details']->id);

                }

                DB::commit();

                $project_updated_count++;

            } catch (\Throwable $e) {
                DB::rollback();
                Log::error($e);
            }

        }

        Log::info('DATA FIX - Total Projects Updated : '.$project_updated_count);
        Log::info('DATA FIX - COMPLETED');

    }

    //create milestones
    private function createMilestones($new_milestone, $milestones_events, $project_details)
    {
        $data['new_milestone'] = new MilestoneEvents;
        $data['new_milestone']->project_id = $project_details->id;
        $data['new_milestone']->milestone_id = $new_milestone;
        $data['new_milestone']->started_date = $milestones_events->started_date;
        $data['new_milestone']->completed  = 'Y';
        $data['new_milestone']->completed_date = $milestones_events->completed_date;
        $data['new_milestone']->skipped  = 'N';
        $data['new_milestone']->created_by = $milestones_events->created_by;
        $data['new_milestone']->updated_by = $milestones_events->updated_by;
        $data['new_milestone']->created_at = $milestones_events->created_at;
        $data['new_milestone']->updated_at = $milestones_events->updated_at;

        $data['new_milestone']->save();
    }

}
