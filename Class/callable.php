<?php
$func = function (){
    return 'hello';
};
var_dump(is_object($func));

echo date('Ymd',time());