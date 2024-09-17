<?php

namespace App\Features\Batch\Repositories;

use Illuminate\Support\Facades\DB;

use App\Features\Batch\Constants\BatchConstant;
use App\Features\Batch\Repositories\Interfaces\IBatchRepository;
use App\Models\Batch\BatchHeader;
use App\Models\Batch\BatchSchedule;
use App\Models\Batch\BatchRunLog;
use App\Models\Batch\BatchCategory;

class BatchRepository implements IBatchRepository
{

    /**
     * Get List of Batch Scheduled for Specific Time
     *
     * @return Illuminate\Support\Collection
     */
    public function getBatchListByScheduleAndCategory($category, $batch_schedule_type, $week_day, $hour, $minutes, $active = null)
    {
        $query = BatchHeader::FilterCategory($category);

        if ($active === BatchConstant::ACTIVE) {
            $query->ActiveBatch();
        }

        $query->whereHas('BatchSchedule', function ($q) use ($batch_schedule_type, $week_day, $hour, $minutes) {
            $q->FilterHour($hour);
            $q->FilterMinutes($minutes);
            $q->FilterScheduleDays($week_day);
            $q->FilterScheduleType($batch_schedule_type);
            $q->FilterWeek();
            $q->ActiveBatchSchedule();
        });

        return $query->get();
    }


    /**
     * Get Batch Schedule Details for Specific Time of a Batch
     *
     * @return bool Illuminate\Support\Collection
     */
    public function getActiveScheduleByBatchIdAndHourMinutes($batch_id, $week_day, $hour, $minutes)
    {
        return BatchSchedule::ActiveBatchSchedule()
            ->FilterBatch($batch_id)
            ->FilterScheduleDays($week_day)
            ->FilterHour($hour)
            ->FilterMinutes($minutes)
            ->first();
    }


    /**
     * Get Batch Schedule Details
     *
     * @return bool Illuminate\Support\Collection
     */
    public function getSchedulesByBatchId($batch_id)
    {
        return BatchSchedule::with('BatchScheduleUpdatedUser')
            ->FilterBatch($batch_id)
            ->get();
    }


    /**
     * Update Batch Schedule
     *
     * @return bool true|false
     */
    public function updateBatchSchedule($schedule)
    {
        return $schedule->save();
    }


    /**
     * Add Batch Run Log
     *
     * @return bool true|false
     */
    public function addBatchRunLog($batch_id, $schedule_id, $status, $pid)
    {
        $log = new BatchRunLog();
        $log->batch_id = $batch_id;
        $log->schedule_id = $schedule_id;
        $log->status = $status;
        $log->pid = $pid;

        $log->save();

        return $log;
    }


    /**
     * Update Batch Run Log
     *
     * @return bool true|false
     */
    public function updateBatchRunLogStatus($batch_id, $schedule_id, $status, $pid)
    {
        $log = BatchRunLog::FilterBatch($batch_id)
            ->where('schedule_id', $schedule_id)
            ->where('pid', $pid)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($log != null) {
            $log->status = $status;
            $log->peak_memory = round((memory_get_peak_usage(false) / 1024 / 1024), 2);
            return $log->save();
        }

        return;
    }


    /**
     * Get Latest Batch Run Log for a Batch
     *
     * @return Illuminate\Support\Collection
     */
    public function getLatestLogByBatchId($batch_id, $status = null)
    {
        return BatchRunLog::FilterStatus($status)->FilterBatch($batch_id)->where('created_at', '>', date('Y-m-d H:i:s', strtotime('-3 days')))->OrderBy('created_at', 'desc')->get();
    }


    /**
     * Get List of Batch Categories
     *
     * @return Illuminate\Support\Collection
     */
    public function getBatchCategoriesList()
    {
        return BatchCategory::all();
    }


    /**
     * Update Log - Batch Killed
     *
     * @return Illuminate\Support\Collection
     */
    public function updateLogBatchKilled($logid)
    {
        $log = BatchRunLog::where('id', $logid)->first();
        
        if (is_object($log) && $log->count() > 0) {

            $log->status = 'KILLED';
            
            try {
                if($log->save()) {
                    return true;
                } 
            } catch (\Exception $e) {  

                AuditLogActivity::addLog(BatchConstant::AUDIT_LOG_CATEGORY, BatchConstant::AUDIT_LOG_EVENT_KILLED, $e->getMessage(),  $logid);
                report($e);
            }

        }
        return false;
    }
}
