<?php

error_log('this is 0 log',0); //发送到系统日志

error_log('this is email log',1,'1309893442@qq.com');

error_log('this is 3 log',3,__DIR__.'/3_error_log'); //以追加的方式记录错误信息


