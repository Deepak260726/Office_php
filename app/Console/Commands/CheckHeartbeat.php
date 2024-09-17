<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class CheckHeartbeat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'heartbeat:check {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Heartbeat Check';

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
        $data['type'] = $this->argument('type');
        
        if($data['type'] == null | $data['type'] == '') {
          Log::error(Carbon::now()->format('Y-m-d H:i:s.v') . ' - ' . $this->batch_run_id . ' - Invalid Type Passed - App\Console\Commands@RunHeartbeat');
          $this->error('Invalid Type Passed - App\Console\Commands@RunHeartbeat');
          return 1; 
        }
        
        $this->info(Carbon::now()->format('Y-m-d H:i:s.v') . ' - ' . $this->batch_run_id . ' - Launching Heartbeat Check - '.$data['type']);
        
        switch($data['type']) {
          
          case 'LARA-DOCUMENTS-PUBLISHED-TABLE':
            $campaign = new \App\Heartbeat\LARA\DocumentPublication();
            $campaign->check();
          break;
          
          case 'LARA-INVOICE-TABLE':
            $campaign = new \App\Heartbeat\LARA\Invoice();
            $campaign->check();
          break;
          
          default:
            Log::error('Invalid Type Passed '.$data['type'].' - App\Console\Commands@RunHeartbeat');
            $this->error(Carbon::now()->format('Y-m-d H:i:s.v') . ' - ' . $this->batch_run_id . ' - Invalid Type Passed - App\Console\Commands@RunHeartbeat');
        }
        
        $this->info(Carbon::now()->format('Y-m-d H:i:s.v') . ' - ' . $this->batch_run_id . ' - Batch end');

      return 1; 
    }
}
