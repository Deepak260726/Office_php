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

class DataFixReplicate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'datafix:replicate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For replicate api products';

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
            
            $this->replicateProjects();
            
        }
        catch(\Exception $e) {
            report($e);
        }
        
        $this->info(Carbon::now()->format('Y-m-d H:i:s.v') . ' - ' . $this->batch_run_id . ' - Batch end');
        
        return 1;
    }



    private function replicateProjects()
    {
        //get all API New deployment projects
        $query = Project::where('project_type_id', 'ND')
                ->where('channel_id', 'API')
                ->whereIn('projects.product_id', ['PRC', 'ROUT'])
                ->whereNotIn('projects.id', ['101249','101166','101171','100940','101082','101052','101039','101116','100947','101173','101240','101083','100903','100904','100866','101045','100941','101250','100961','101622','101137','101241','101071','101080','101621','101239','100946','101157','100896','101062','101033','100875','101118','101136','100888','100905','100886','101122']);
                    
        $query->where(function ($q)  {
                $q->WhereRaw('(select count(b2b_onboarding_request_products.id)
                    from b2b_onboarding_request_products
                    where b2b_onboarding_request_products.project_id = projects.id) = 0');
            });
 
        $projects = $query->get();

        Log::info('DATA FIX - REPLICATE API PROJECTS COUNT : '. $projects->count());

        $project_updated_count = 0;


        foreach ($projects as $key => $project) {

            DB::beginTransaction();

            Log::info('DATA FIX - REPLICATE PROJECTS : '. $project->id);

            try {

                $data['project_details'] = Project::find($project->id);

                // Replicate projects with correct API products (Pricing & Schedules)
                if($data['project_details']->product_id == 'PRC' ||  $data['project_details']->product_id == 'ROUT') {

                    $pricing_product = ['DDSM'];
                    $schedule_products = ['VOYA','PROF'];

                    //create project
                    if( $data['project_details']->product_id == 'PRC' ) {

                        foreach($pricing_product as $project_product) {
        
                            $project_id = $this->createNewProject($project_product, $data['project_details']);
                            Log::info('DATA FIX - NEW PROJECT CREATED : From ('. $data['project_details']->id. ') -> To ('.$project_id.')');
                            
                        }
                    }

                    if( $data['project_details']->product_id == 'ROUT' ) {

                        foreach($schedule_products as $project_product) {
        
                            $project_id = $this->createNewProject($project_product, $data['project_details']);
                            Log::info('DATA FIX - NEW PROJECT CREATED : From ('. $data['project_details']->id. ') -> To ('.$project_id.')');
                            
                        }
                    }

                }

                DB::commit();

                $project_updated_count++;

            } catch (\Throwable $e) {
                DB::rollback();
                Log::error($e);
            }

        }

        Log::info('DATA FIX - Total Projects replicated : '.$project_updated_count);
        Log::info('DATA FIX - COMPLETED');

    }


    //create new project
    private function createNewProject($project_product, $project_details)
    {

        //Create Project
        $data['project'] = new Project;
        $data['project']->template_id = $project_details->template_id;
        $data['project']->project_type_id = $project_details->project_type_id;
        $data['project']->roadmap_id = $project_details->roadmap_id;
        $data['project']->title = $project_details->title;
        $data['project']->partner_id = $project_details->partner_id;
        $data['project']->product_id = $project_product; //new product;
        $data['project']->message_type_id = $project_details->message_type_id;
        $data['project']->integration_type_id = $project_details->integration_type_id;
        $data['project']->channel_id = $project_details->channel_id;
        $data['project']->channel_type_id = $project_details->channel_type_id;
        $data['project']->platform_id = $project_details->platform_id;
        $data['project']->shipcomp_code = $project_details->shipcomp_code;
        $data['project']->region = $project_details->region;
        $data['project']->priority_id = $project_details->priority_id;
        $data['project']->status_id = $project_details->status_id;
        $data['project']->milestone_id = $project_details->milestone_id;
        $data['project']->requested_date = $project_details->requested_date;
        $data['project']->validated_date = $project_details->validated_date;
        $data['project']->estimated_start_date = $project_details->estimated_start_date;
        $data['project']->estimated_end_date = $project_details->estimated_end_date;
        $data['project']->actual_start_date = $project_details->actual_start_date;
        $data['project']->actual_end_date = $project_details->actual_end_date;
        $data['project']->last_status_at = $project_details->last_status_at;
        $data['project']->weather = $project_details->weather;
        $data['project']->descriptions = $project_details->descriptions;
        $data['project']->customer_contact = $project_details->customer_contact;
        $data['project']->highlights = $project_details->highlights;
        $data['project']->attention_points = $project_details->attention_points." ".Carbon::now()->format('Y-m-d')." : Project created by system, as part of datafix";
        $data['project']->management_followup = $project_details->management_followup;
        $data['project']->it_request_reference = $project_details->it_request_reference;
        $data['project']->workload_id = $project_details->workload_id;
        $data['project']->blocked_reason_party = $project_details->blocked_reason_party;
        $data['project']->delayed = $project_details->delayed;
        $data['project']->delay_reason_party = $project_details->delay_reason_party;
        $data['project']->delay_reason = $project_details->delay_reason;
        $data['project']->delay_updated_at = $project_details->delay_updated_at;
        $data['project']->cancelled_reason_party = $project_details->cancelled_reason_party;
        $data['project']->cancelled_reason = $project_details->cancelled_reason;
        $data['project']->cancelled_at = $project_details->cancelled_at;
        $data['project']->project_lead = $project_details->project_lead;
        $data['project']->team_id = $project_details->team_id;
        $data['project']->backdated_project = $project_details->backdated_project;
        $data['project']->deleted_at = $project_details->deleted_at;
        $data['project']->created_by = $project_details->created_by;
        $data['project']->updated_by = $project_details->updated_by;
        $data['project']->created_at = $project_details->created_at;
        $data['project']->updated_at = $project_details->updated_at;

        if($data['project']->save()) {

            //get list of project milstones events
            $new_project_milestones_events =  MilestoneEvents::where('project_id', $project_details->id)->where('milestone_id', '>=', '100')->get();

            //Create milestones
            foreach($new_project_milestones_events as $project_milestone) {

                $data['new_milestone'] = new MilestoneEvents;
                $data['new_milestone']->project_id = $data['project']->id;
                $data['new_milestone']->milestone_id = $project_milestone->milestone_id;
                $data['new_milestone']->started_date = $project_milestone->started_date;
                $data['new_milestone']->completed  = $project_milestone->completed;
                $data['new_milestone']->completed_date = $project_milestone->completed_date;
                $data['new_milestone']->skipped  = $project_milestone->skipped;
                $data['new_milestone']->created_by = $project_milestone->created_by;
                $data['new_milestone']->updated_by = $project_milestone->updated_by;
                $data['new_milestone']->created_at = $project_milestone->created_at;
                $data['new_milestone']->updated_at = $project_milestone->updated_at;

                $data['new_milestone']->save();

            }

            
            //add projects comments
            $project_comments =  Comment::where('project_id', $project_details->id)->where('type', '!=', 'MIL')->get();

            //Create milestones
            foreach($project_comments as $new_project_comments) {

                $data['new_comment'] = new Comment;
                $data['new_comment']->project_id = $data['project']->id;
                $data['new_comment']->type = $new_project_comments->type;
                $data['new_comment']->comment = $new_project_comments->comment;
                $data['new_comment']->effective_date  = $new_project_comments->effective_date;
                $data['new_comment']->display = $new_project_comments->display;
                $data['new_comment']->milestone_id  = $new_project_comments->milestone_id;
                $data['new_comment']->deleted_at  = $new_project_comments->deleted_at;
                $data['new_comment']->created_by = $new_project_comments->created_by;
                $data['new_comment']->updated_by = $new_project_comments->updated_by;
                $data['new_comment']->created_at = $new_project_comments->created_at;
                $data['new_comment']->updated_at = $new_project_comments->updated_at;

                $data['new_comment']->save();

            }

            return $data['project']->id;

        }


    }
}
