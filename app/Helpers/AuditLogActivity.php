<?php

namespace App\Helpers;
use Request;
use App\Models\AuditLogActivity as AuditLogActivityModel;

class AuditLogActivity
{
    
    /**
     * Create a new aduit log entry.
     *
     * @param  string  $event, array $data
     * @return void
     */
    public static function addLog($event_category, $event, $data=null, $mapped_id=null)
    {
    	$log = [];
      $log['event_category'] = $event_category;
    	$log['event'] = $event;
    	$log['data'] = (is_array($data) ? json_encode($data) : $data);
    	$log['ip'] = Request::ip();
    	$log['agent'] = Request::header('user-agent');
      $log['mapped_id'] = $mapped_id;
    	$log['created_by'] = auth()->check() ? auth()->user()->id : 1001;

    	AuditLogActivityModel::create($log);
    }

    
    /**
     * Get Latest Audit Log Entries
     *
     * @param  none
     * @return Illuminate\Database\Eloquent\Collection
     */
    public static function logActivityLists()
    {
    	return AuditLogActivityModel::latest()->get();
    }
    
    
    
    /**
     * Get Latest Audit Log Entries (USER-LOGIN) of a User
     *
     * @param  int $user_id
     * @return array Illuminate\Database\Eloquent\Collection
     */
    public static function userLoginAuditLogActivityLists($user_id)
    {
    	return AuditLogActivityModel::latest()->UserLoginAuditLog($user_id)->take(5)->get();
    }
    
    
    
    /**
     * Get Latest Audit Log Entries (USER*) of a User
     *
     * @param  int $user_id
     * @return array Illuminate\Database\Eloquent\Collection
     */
    public static function userAuditLogActivityLists($user_id)
    {
    	return AuditLogActivityModel::latest()->UserAuditLog($user_id)->take(5)->get();
    }
    
    
    /**
     * Get Latest Audit Log Entries
     *
     * @param  int $mapped_id
     * @return array Illuminate\Database\Eloquent\Collection
     */
    public static function getAuditLogActivityLists($mapped_id, $event_category, $include=null, $exclude=null)
    {
    	return AuditLogActivityModel::with('user')
                    ->latest()
                    ->where('mapped_id', $mapped_id)
                    ->where('event_category', $event_category)
                    ->IncludeEvents($include)
                    ->ExcludeEvents($exclude)
                    ->orderBy('id', 'desc')
                    ->take(10)
                    ->get();
    }
    
    
    /**
     * Get Latest Audit Log Entries of REPORT
     *
     * @param  int $report_id
     * @return array Illuminate\Database\Eloquent\Collection
     */
    public static function reportAuditLogActivityLists($report_id)
    {
    	return AuditLogActivityModel::with('user')->latest()->ReportAuditLog($report_id)->take(10)->get();
    }
    
    
    /**
     * Get Latest Audit Log Entries of REPORT-RUN
     *
     * @param  int $report_id
     * @return array Illuminate\Database\Eloquent\Collection
     */
    public static function reportRunAuditLogActivityLists($report_id)
    {
    	return AuditLogActivityModel::with('user')->latest('id')->ReportRunAuditLog($report_id)->take(10)->get();
    }
    
    
    
    
    /**
     * Get Changed Values in JSON
     *
     * @param  original_data, changed_data
     * @return JSON | Null
     */
    public static function getChangedValues($original_data, $changed_data)
    {
    	$fields_not_checked = ['created_at', 'updated_at', 'created_by', 'updated_by'];
      $json = array();
      
      foreach(array_keys($changed_data) as $changed_data_key){
        if(!in_array($changed_data_key, $fields_not_checked)) {
          
          $json[] = ['field' => $changed_data_key, 'old' => $original_data[$changed_data_key], 'new' => $changed_data[$changed_data_key]];
        }
      }
      
      if(count($json) > 0)
        return json_encode($json);
      else
        return NULL;
    }

}