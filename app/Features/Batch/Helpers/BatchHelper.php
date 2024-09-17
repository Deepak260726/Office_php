<?php

namespace App\Features\Batch\Helpers;

use Illuminate\Support\Facades\DB;

class BatchHelper
{

    /**
     * Chec if a PID is running
     *
     * @param  string  $pid
     * @return bool true|false
     */
    public static function check_if_pid_is_running(string $pid)
    {
        if(config('app.deploy_target') == 'cloud'){

            if (file_exists( "/proc/$pid" )){
                return true;
            } else {
                return false;
            }

        } else {

            exec('TASKLIST /NH /FO "CSV" /FI "PID eq ' . $pid . '"', $outputA);
            $outputB = explode('","', $outputA[0]);
            
            return (isset($outputB[1]) && (strpos($outputB[0], 'php') !== false)) ? true : false;
            
        }
    }


    /**
     * Kill a PID
     *
     * @param  string  $pid
     * @return bool true|false
     */
    public static function kill_pid(string $pid)
    {
        if(config('app.deploy_target') == 'cloud') {

            if (exec("kill -9 $pid")) {
                return true;
            } else {
                return false;
            }

        } else {

            exec("taskkill /pid $pid /f", $output);
            
            return (isset($output[0]) && (strpos($output[0], 'SUCCESS') !== false)) ? true : false;
            
        }
    }
}
