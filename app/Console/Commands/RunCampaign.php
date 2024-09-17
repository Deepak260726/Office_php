<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RunCampaign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:run {campaign_type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Specific Campaign';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data['campaign_type'] = $this->argument('campaign_type');
        
        if($data['campaign_type'] == null | $data['campaign_type'] == '') {
          Log::error('Invalid Campaign Type Passed - App\Console\Commands@RunCampaign');
          $this->error('Invalid Campaign Type Passed - App\Console\Commands@RunCampaign');
        }
        
        $this->info('Launching Campaign - '.$data['campaign_type']);
        
        switch($data['campaign_type']) {
          
          case 'EBUSINESS-ACCOUNT-ACTIVATION':
            $campaign = new \App\Campaigns\eBusinessAccountActivation\ActivationEmail();
            $campaign->run();
          break;
          
          default:
            Log::error('Invalid Campaign Type Passed '.$data['campaign_type'].' - App\Console\Commands@RunCampaign');
            $this->error('Invalid Campaign Type Passed - App\Console\Commands@RunCampaign');
        }        
      return 1;
    }
}
