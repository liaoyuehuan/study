<?php
$url = 'a=1&b=2&c=3';
parse_str($url,$res);
var_dump($res);