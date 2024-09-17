<?php

namespace App\Features\Batch\Repositories\Interfaces;

interface IBatchRepository
{
    public function getBatchListByScheduleAndCategory($category, $batch_schedule_type, $week_day, $hour, $minutes, $active = null);

    public function getActiveScheduleByBatchIdAndHourMinutes($batch_id, $week_day, $hour, $minutes);

    public function getSchedulesByBatchId($batch_id);

    public function updateBatchSchedule($schedule_id);

    public function addBatchRunLog($batch_id, $schedule_id, $status, $pid);

    public function updateBatchRunLogStatus($batch_id, $schedule_id, $status, $pid);

    public function getLatestLogByBatchId($batch_id, $status = null);

    public function getBatchCategoriesList();

    public function updateLogBatchKilled($logid);
}
