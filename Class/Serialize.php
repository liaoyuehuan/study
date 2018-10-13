<?php
$use1 = 'uu';
$clo = function ($param1, $param2) use ($use1) {
    return '八嘎' . $param1 . ':' . $param2;
};

//serialize($clo); //这样做时不行的

$reflection_f = new ReflectionFunction($clo);
serialize($reflection_f);
var_dump($reflection_f->getParameters());   //获取 $param1, $param2
$g_clo = $reflection_f->getClosure();       //获取 closure
var_dump(call_user_func_array($g_clo,[1,2])); //执行closure
