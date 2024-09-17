<?php

namespace App\Features\Batch\Services\Interfaces;

interface IBatchService
{
    public function getActiveBatchListByScheduleAndCategory($category, $batch_schedule_type, $week_day = null, $hour = null, $minutes = null);

    public function getActiveScheduleByBatchIdAndHourMinutes($batch_id, $week_day = null, $hour = null, $minutes = null);

    public function getSchedulesByBatchId($batch_id);

    public function updateBatchScheduleStatusAsRunning($schedule);

    public function updateBatchScheduleStatusAsCompleted($schedule);

    public function updateBatchScheduleStatusAsError($schedule);

    public function addBatchRunLog($batch_id, $schedule_id);

    public function getLatestRunningLogByBatchId($batch_id);

    public function getLatestBathRunLogs($batch_id);

    public function getLatestAuditLog($batch_id);

    public function getLatestAuditLogBatchRun($batch_id);

    public function isRunning($batch_id);

    public function getBatchCategoriesList();

    public function updateLogBatchKilled($logid);
}
