<?php
$aa = [
    'asdadsa' => 'adsadsa'
];

var_dump($aap['aaaa']);
set_error_handler(function ($errno , string $errstr){
    var_dump($errstr);
});

echo '###### seaslog_get_author ######' . PHP_EOL;
echo seaslog_get_author() . PHP_EOL;

echo '###### seaslog_get_version ######' . PHP_EOL;
echo seaslog_get_version() . PHP_EOL;

echo '###### log ######' . PHP_EOL;
echo SeasLog::emergency('emergency log message');

echo SeasLog::alert('alter log message');

echo SeasLog::critical('critical log message');

echo SeasLog::error('error log message');

echo SeasLog::warning('warning log message');

echo SeasLog::notice('notice log message');

echo SeasLog::info('info log message');

echo SeasLog::debug('debug log message');

echo SeasLog::log('common log message');

echo SeasLog::alert('alter log message : {name}', ['name' => 'liao']);

# easlog.disting_folder = 1 时保存在default2的目录下
echo SeasLog::alert('alter log message : {name}', ['name' => 'liao'], 'default2');


echo PHP_EOL . '###### buffer is enable ######' . PHP_EOL;
var_dump(SeasLog::getBufferEnabled());

echo PHP_EOL . '######  buffer ######' . PHP_EOL;
var_dump(SeasLog::getBuffer());

echo PHP_EOL . '######  getRequestID ######' . PHP_EOL;
echo SeasLog::getRequestID() . PHP_EOL;


echo PHP_EOL . '######  getRequestVariable ######' . PHP_EOL;
echo SeasLog::getRequestVariable(EASLOG_REQUEST_VARIABLE_DOMAIN_PORT) . PHP_EOL;
echo SeasLog::getRequestVariable(SEASLOG_REQUEST_VARIABLE_REQUEST_URI) . PHP_EOL;
echo SeasLog::getRequestVariable(SEASLOG_REQUEST_VARIABLE_REQUEST_METHOD) . PHP_EOL;
echo SeasLog::getRequestVariable(SEASLOG_REQUEST_VARIABLE_CLIENT_IP) . PHP_EOL;
echo SeasLog::setRequestVariable(SEASLOG_REQUEST_VARIABLE_CLIENT_IP, '192.168.1.15') . PHP_EOL;
echo SeasLog::getRequestVariable(SEASLOG_REQUEST_VARIABLE_CLIENT_IP) . PHP_EOL;

