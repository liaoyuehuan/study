<?php
$resource = fopen(__FILE__,'rw'); //如果另一个进程获取了锁，那么这里会阻塞的哦
echo 'open handle success'.PHP_EOL;
flock($resource,LOCK_EX); //如果另一个进程获取了锁，那么这里会阻塞的哦
echo 'gain lock success'.PHP_EOL;
sleep(10);
flock($resource,LOCK_UN);
echo 'release lock success'.PHP_EOL;
fclose($resource);

//使用swoole时，建议使用swoole_lock
