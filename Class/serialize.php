<?php
$use1 = 'uu';
$clo = function ($param1, $param2) use ($use1) {
    return '八嘎' . $param1 . ':' . $param2;
};

//serialize($clo); //这样做时不行的

$reflection_f = new ReflectionFunction($clo->bindTo(new stdClass()));
$serialize_reflection = serialize($reflection_f);

$aa = (object)unserialize($serialize_reflection);
var_dump($aa->invoke(1));   //获取 $param1, $param2
$g_clo = $reflection_f->getClosure();       //获取 closure
var_dump(call_user_func_array($g_clo,[1,2])); //执行closure
