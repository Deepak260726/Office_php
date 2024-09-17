<?php

namespace App\Features\Batch\Services;

use Illuminate\Support\Facades\Cache;

use App\Helpers\AuditLogActivity;
use App\Helpers\Schedules;
use App\Infrastructure\Constants\CacheConstant;

use App\Features\Batch\Services\Interfaces\IBatchService;
use App\Features\Batch\Constants\BatchConstant;
use App\Features\Batch\Helpers\BatchHelper;
use App\Features\Batch\Repositories\Interfaces\IBatchRepository;
use Illuminate\Support\Carbon;

class BatchService implements IBatchService
{

    private $BatchRepository;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(IBatchRepository $BatchRepository)
    {
        $this->BatchRepository = $BatchRepository;
    }

    /**
     * Get List of Batch Scheduled for Specific Time
     *
     * @return Illuminate\Support\Collection
     */
    public function getActiveBatchListByScheduleAndCategory($category, $batch_schedule_type, $week_day = null, $hour = null, $minutes = null)
    {
        $hour = ($hour == null) ? Schedules::getCurrentHour() : $hour;
        $minutes = ($minutes == null) ? Schedules::getCurrentMinutes() : $minutes;
        $week_day = ($week_day == null) ? Schedules::getCurrentScheduleDay() : $week_day;

        return $this->BatchRepository->getBatchListByScheduleAndCategory($category, $batch_schedule_type, $week_day, $hour, $minutes, BatchConstant::ACTIVE);
    }


    /**
     * Get Batch Schedule Details for Specific Time of a Batch
     *
     * @return Illuminate\Support\Collection
     */
    public function getActiveScheduleByBatchIdAndHourMinutes($batch_id, $week_day = null, $hour = null, $minutes = null)
    {
        $hour = ($hour == null) ? date('H') : $hour;
        $minutes = ($minutes == null) ? date('i') : $minutes;
        $week_day = ($week_day == null) ? Schedules::getCurrentScheduleDay() : $week_day;

        return $this->BatchRepository->getActiveScheduleByBatchIdAndHourMinutes($batch_id, $week_day, $hour, $minutes);
    }


    /**
     * Get Batch Schedule Details
     *
     * @return Illuminate\Support\Collection
     */
    public function getSchedulesByBatchId($batch_id)
    {
        return $this->BatchRepository->getSchedulesByBatchId($batch_id);
    }


    /**
     * Update Batch Schedule Status to RUNNING
     *
     * @return bool true|false
     */
    public function updateBatchScheduleStatusAsRunning($schedule)
    {
        $schedule->status = BatchConstant::BATCH_SCHEDULE_STATUS_RUNNING;

        $this->BatchRepository->updateBatchSchedule($schedule);

        return $this->BatchRepository->addBatchRunLog($schedule->batch_id, $schedule->id, $schedule->status, getmypid());
    }


    /**
     * Update Batch Schedule Status to COMPLETED
     *
     * @return bool true|false
     */
    public function updateBatchScheduleStatusAsCompleted($schedule)
    {
        // Set Active flag to In Active for On Demand Schedule i.e. Run Once
        if ($schedule->on_demand == BatchConstant::ON_DEMAND_YES) {
            $schedule->active = BatchConstant::IN_ACTIVE;
        }

        $schedule->status = BatchConstant::BATCH_SCHEDULE_STATUS_COMPLETED;

        $this->BatchRepository->updateBatchSchedule($schedule);

        return $this->BatchRepository->updateBatchRunLogStatus($schedule->batch_id, $schedule->id, $schedule->status, getmypid());
    }


    /**
     * Update Batch Schedule Status to ERROR
     *
     * @return bool true|false
     */
    public function updateBatchScheduleStatusAsError($schedule)
    {
        $schedule->status = BatchConstant::BATCH_SCHEDULE_STATUS_ERROR;

        $this->BatchRepository->updateBatchSchedule($schedule);

        return $this->BatchRepository->updateBatchRunLogStatus($schedule->batch_id, $schedule->id, $schedule->status, getmypid());
    }


    /**
     * Add Batch Run Log
     *
     * @return bool true|false
     */
    public function addBatchRunLog($batch_id, $schedule_id)
    {
        return $this->BatchRepository->addBatchRunLog($batch_id, $schedule_id, BatchConstant::BATCH_SCHEDULE_STATUS_RUNNING, getmypid());
    }


    /**
     * Get Latest Batch Run Log for a Batch
     *
     * @return Illuminate\Support\Collection
     */
    public function getLatestRunningLogByBatchId($batch_id)
    {
        return $this->BatchRepository->getLatestLogByBatchId($batch_id, BatchConstant::BATCH_SCHEDULE_STATUS_RUNNING);
    }


    /**
     * Get Latest Batch Run Log for a Batch
     *
     * @return Illuminate\Support\Collection
     */
    public function getLatestBathRunLogs($batch_id)
    {
        return $this->BatchRepository->getLatestLogByBatchId($batch_id);
    }


    /**
     * Get Latest Audit Log for a Batch
     *
     * @return Illuminate\Support\Collection
     */
    public function getLatestAuditLog($batch_id)
    {
        return AuditLogActivity::getAuditLogActivityLists(
            $batch_id,
            BatchConstant::AUDIT_LOG_CATEGORY,
            [
                BatchConstant::AUDIT_LOG_EVENT_INSERT,
                BatchConstant::AUDIT_LOG_EVENT_UPDATE,
                BatchConstant::AUDIT_LOG_EVENT_DELETE
            ],
            null
        );
    }


    /**
     * Get Latest Batch Run Audit Log for a Batch
     *
     * @return Illuminate\Support\Collection
     */
    public function getLatestAuditLogBatchRun($batch_id)
    {
        return AuditLogActivity::getAuditLogActivityLists(
            $batch_id,
            BatchConstant::AUDIT_LOG_CATEGORY,
            null,
            [
                BatchConstant::AUDIT_LOG_EVENT_INSERT,
                BatchConstant::AUDIT_LOG_EVENT_UPDATE,
                BatchConstant::AUDIT_LOG_EVENT_DELETE
            ]
        );
    }


    /**
     * Check existing Running Instance
     *
     * @return bool true|false
     */
    public function isRunning($batch_id)
    {
        $logs = $this->getLatestRunningLogByBatchId($batch_id);

        if (is_object($logs) && $logs->count() > 0) {

            foreach ($logs as $log) {
                if (BatchHelper::check_if_pid_is_running($log->pid)) {
                    if(strtotime($log->created_at) > strtotime(Carbon::now()->subhour()->format('Y-m-d H:i:s')) ) {
                        return true;
                    } else {
                        BatchHelper::kill_pid($log->pid);
                        $this->updateLogBatchKilled($log->id);
                    }  
                } 
            }
        }

        return false;
    }


    /**
     * Get List of Batch Categories
     *
     * @return Illuminate\Support\Collection
     */
    public function getBatchCategoriesList()
    {
        return $this->BatchRepository->getBatchCategoriesList();
    }


    /**
     * Update Log - Batch Killed
     *
     * @return Illuminate\Support\Collection
     */
    public function updateLogBatchKilled($logid)
    {
        return $this->BatchRepository->updateLogBatchKilled($logid);
    }
}
