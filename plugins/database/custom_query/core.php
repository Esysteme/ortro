<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * DB Custom Query.
 * 
 * Executes a custom query against the selected database
 * and compares the query result with an expected result 
 * using a logical operator.
 * On a true comparison result an error or success value is returned 
 * as defined in the field "If test is true then return" flag.
 *
 * PHP version 5
 *
 * LICENSE: This file is part of Ortro.
 * Ortro is published under the terms of the GNU GPL License v2 
 * Please see LICENSE and COPYRIGHT files for details.
 *
 * @category Plugins
 * @package  Ortro
 * @author   Luca Corbo <lucor@ortro.net>
 * @license  GNU/GPL v2
 * @link     http://www.ortro.net
 */

//###### Required core code ######

require_once realpath(dirname($argv[0])) . '/../../init.inc.php';
require_once 'cronUtil.php';

$plugin_name  = basename(dirname($argv[0]), DIRECTORY_SEPARATOR);
$id_job       = $argv[1];// Get the job id
$request_type = $argv[2];// Get the type of request
 
$cronUtil   = new CronUtil($request_type);
$job_infos  = $cronUtil->startJobEvent($plugin_name, $id_job);
$parameters = $job_infos['parameters'];
set_error_handler("errorHandler");

//###### End required core code ######

try {

    //---- Start plugin code -----
    include_once 'dbUtil.php';
    
    $loggerPlugin = new LogUtil($plugin_name, ORTRO_LOG_PLUGINS . $plugin_name);
    $loggerPlugin->trace('INFO', 'Executing job ' . $plugin_name . 
                                 ' with id=' . $id_job);
    
    $result = 0;

    //---- Start plugin code -----
    
    //Get the params required by plugin from argv
    $user      = $job_infos['identity']['username'];
    $pwd       = $job_infos['identity']['password'];
    $query     = $parameters['db_custom_query_query'];
    $operator  = $parameters['db_custom_query_operator'];
    $threshold = $parameters['db_custom_query_threshold'];
    $is_error  = $parameters['db_custom_query_is_error'];
    
    $ip   = $job_infos['ip'];
    $dbms = $job_infos['dbms'];
    $sid  = $job_infos['sid'];
    $port = $job_infos['port'];
    
    try {
        $dbUtil = new DbUtil();
        $dbh    = $dbUtil->dbOpenConn($dbms, $ip, $port, $sid, $user, $pwd);
        $rows   = $dbUtil->dbQuery($dbh, $query);
        $dbh    = $dbUtil->dbCloseConn($dbh);
        unset($dbh);
        
        $testValue = $rows[0][0];
        $loggerPlugin->trace('DEBUG', 'id=' . $id_job . ' result:' . $testValue);
        
        $result   = notifyUtil::test($testValue, $threshold, $operator, $is_error);
        $msg_exec = $testValue;
        
        $attachments['txt']  = $testValue;            
        $attachments['html'] = $testValue;
    } catch (Exception $e) {
        $result   = 0;
        $msg_exec = $e->getMessage();
        
        $attachments['txt']  = $msg_exec;
        $attachments['html'] = $msg_exec;    
        $loggerPlugin->trace('ERROR', $msg_exec);
    }
    
    //---- Archive job result ----
    $retention_data['archive_mode'] = 'DB';
    $retention_data['retention']    = $parameters['db_custom_query_retention'];
    
    
    //---- End plugin code -----

} catch (Exception $e) {
    $cronUtil->traceError($plugin_name, $e);
    $msg_exec = "Plugin exception occourred: " . $e->getMessage() . "\n" .
                "Please contact system administrator";
    
}

//###### Required core code ######
restore_error_handler();
$cronUtil->endJobEvent($plugin_name, $id_job, $result, $msg_exec, $attachments);
if ($retention_data['retention'] > 0 && is_numeric($retention_data['retention'])) {
    //apply retention policy
    $cronUtil->archiveJobResult($id_job, $retention_data);
}
//###### End required core code ######
?>