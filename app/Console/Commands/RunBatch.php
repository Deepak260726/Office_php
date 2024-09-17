<?php

namespace App\Console\Commands;

use App\Features\Batch\Constants\BatchConstant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

use App\Helpers\AuditLogActivity;
use App\Helpers\Schedules;

use App\Features\Batch\Services\Interfaces\IBatchService;
use App\Features\Batch\Helpers\BatchHelper;
use Exception;

class RunBatch extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'batch:run {batch_category} {batch_schedule_type} {batch_id?}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Run the Batch';

  private $BatchService;

  private $batch_run_id;


  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct(IBatchService $BatchService)
  {
    parent::__construct();

    ini_set( 'memory_limit', '2048M' );

    $this->BatchService = $BatchService;

    $this->batch_run_id = uniqid();
  }


  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    $data['batch_category'] = strtoupper($this->argument('batch_category'));
    $data['batch_schedule_type'] = strtoupper($this->argument('batch_schedule_type'));
    $data['batch_id'] = strtoupper($this->argument('batch_id'));

    $this->info(Carbon::now()->format('Y-m-d H:i:s.v') . ' - ' . $this->batch_run_id . ' - Launching batch...');
    $this->info(Carbon::now()->format('Y-m-d H:i:s.v') . ' - ' . $this->batch_run_id . ' - Batch Category - ' . $this->argument('batch_category'));
    $this->info(Carbon::now()->format('Y-m-d H:i:s.v') . ' - ' . $this->batch_run_id . ' - Schedule Type - ' . $this->argument('batch_schedule_type'));
    $this->info(Carbon::now()->format('Y-m-d H:i:s.v') . ' - ' . $this->batch_run_id . ' - Batch Id - ' . $this->argument('batch_id'));

    switch($data['batch_schedule_type']) {
      case 'DAILY-BY-HOUR-MINUTE':
        $hour = Schedules::getCurrentHour();
        $minutes = Schedules::getCurrentMinutes();
        $week_day = Schedules::getCurrentScheduleDay();
      break;

      case 'MONTHLY-FIRST-DAY':
        $hour = Schedules::getCurrentHour();
        $minutes = Schedules::getCurrentMinutes();
        $week_day = '*';
      break;

      case 'DAILY-EVERY-X-MINS':
        $hour = '*';
        $minutes = Schedules::getCurrentMinutes();
        $week_day = Schedules::getCurrentScheduleDay();
      break;

      default:
        Log::error('Unknown Batch Schedule Type - Batch Category: ' . $data['batch_category'] . ' / Schedule Type: ' . $data['batch_schedule_type']);
        throw new Exception('Unknown Batch Schedule Type - Batch Category: ' . $data['batch_category'] . ' / Schedule Type: ' . $data['batch_schedule_type']);
    }

    $batch_to_run = $this->BatchService->getActiveBatchListByScheduleAndCategory($data['batch_category'], $data['batch_schedule_type'], $week_day, $hour, $minutes);

    Log::info('Batch - Week Day: ' . $week_day . ' / Hour: ' . $hour . ' / Minutes: ' . $minutes . ' - Number of Batches to Launch: ' . ($batch_to_run->count() ?? 0));
    $this->info(Carbon::now()->format('Y-m-d H:i:s.v') . ' - ' . $this->batch_run_id . ' - Batch - Week Day: ' . $week_day . ' / Hour: ' . $hour . ' / Minutes: ' . $minutes . ' - Number of Batches to Launch: ' . ($batch_to_run->count() ?? 0));

    foreach ($batch_to_run as $batch) {
      AuditLogActivity::addLog(BatchConstant::AUDIT_LOG_CATEGORY, BatchConstant::AUDIT_LOG_EVENT_STARTED, NULL,  $batch->id);

      try {
        $schedule = $this->BatchService->getActiveScheduleByBatchIdAndHourMinutes($batch->id, $week_day, $hour, $minutes);

        if ($batch->allow_overlapping == BatchConstant::ALLOW_OVERLAPPING_NO) {
          if ($this->BatchService->isRunning($batch->id)) {
            Log::info('Batch is already running - Batch id: ' . $batch->id . ' / ' . $batch->batch_name);
            throw new Exception('Batch is already running - Batch id: ' . $batch->id . ' - '. $batch->batch_name);
          }
        }

        $this->BatchService->updateBatchScheduleStatusAsRunning($schedule);

        $job = app()->make($batch->class);
        $job->{$batch->method}($batch);

        $this->BatchService->updateBatchScheduleStatusAsCompleted($schedule);
      } catch (\Exception $e) {
        AuditLogActivity::addLog(BatchConstant::AUDIT_LOG_CATEGORY, BatchConstant::AUDIT_LOG_EVENT_EXCEPTION, $e->getMessage(),  $batch->id);

        if (isset($schedule) && $schedule != null && $schedule !== false) {
          $this->BatchService->updateBatchScheduleStatusAsError($schedule);
        }

        $this->error(Carbon::now()->format('Y-m-d H:i:s.v') . ' - ' . $this->batch_run_id . ' - ' . $e->getMessage());
        report($e);
      }

      AuditLogActivity::addLog(BatchConstant::AUDIT_LOG_CATEGORY, BatchConstant::AUDIT_LOG_EVENT_ENDED, NULL,  $batch->id);
    }

    $this->info(Carbon::now()->format('Y-m-d H:i:s.v') . ' - ' . $this->batch_run_id . ' - Batch end');

    return 1;
  }
}
