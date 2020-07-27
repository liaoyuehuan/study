<?php
require_once realpath(dirname(__FILE__) . '/../Log_Autoload.php');

function putLogs(Aliyun_Log_Client $client, $project, $logstore) {
    $topic = '100';

    $contents = array( // key-value pair
        'service'=>'recieves',
        'method'=>'send',
        'param' => json_encode(['order_id']),
        'spend_time' => mt_rand(1,1000),
    );
    $logItem = new Aliyun_Log_Models_LogItem();
    $logItem->setTime(time());
    $logItem->setContents($contents);
    $logitems = array($logItem);
    $request = new Aliyun_Log_Models_PutLogsRequest($project, $logstore,
        $topic, null, $logitems);

    try {
        $response = $client->putLogs($request);
        logVarDump($response);
    } catch (Aliyun_Log_Exception $ex) {
        logVarDump($ex);
    } catch (Exception $ex) {
        logVarDump($ex);
    }
}

function logVarDump($expression){
    print "<br>loginfo begin = ".get_class($expression)."<br>";
    var_dump($expression);
    print "<br>loginfo end<br>";
}


$endpoint = 'http://cn-shenzhen.log.aliyuncs.com';
$accessKeyId = '';
$accessKey = '';
$project = 'esb-log';
$logstore = 'swoole-log';
$token = "";

$client = new Aliyun_Log_Client($endpoint, $accessKeyId, $accessKey,$token);

putLogs($client,$project,$logstore);