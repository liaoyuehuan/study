<?php
$ip = '183.14.82.86';
$record = geoip_record_by_name($ip);
print_r($record);