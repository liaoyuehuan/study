<?php
function quick_sort(array $arr){
    if(isset($arr[1]) === false) return $arr;
    $left_arr = [];
    $right_arr = [];
    $mid = array_pop($arr);
    foreach ($arr as $value) {
        if($mid > $value) {
            $left_arr[] = $value;
        }else{
            $right_arr[] = $value;
        }
    }
    unset($value);
    return array_merge(quick_sort($left_arr),[$mid],quick_sort($right_arr));
}

function bubble_sort(array $arr){
    $len = count($arr);
    for ($i = $len  - 1;$i > 0;--$i){
        for ($j = 0;$j  < $i; ++$j) {
            if($arr[$j + 1] < $arr[$j]) {
                $temp = $arr[$j];
                $arr[$j] = $arr[$j + 1];
                $arr[$j + 1] = $temp;
            }
        }
    }
    return $arr;
}

function hash_sort(array $arr){
    $len = count($arr);
    $hash_len = (int)$len * 2;
    $hash_arr = [];
    foreach ($arr as $value){
        $pos = $value % $hash_len;
        if(isset($hash_arr[$pos]) ){
            $hash_arr[$pos][] = $value;
        } else {
            $hash_arr[$pos] = [];
            $hash_arr[$pos][] = $value;
        }
    }
    return $hash_arr;
}
function mill_time(){
    $mic = microtime();
    $mic_arr = explode(' ',$mic);
    return array_sum($mic_arr) * 1000;
}

$origin_arr= [];
for ($i = 1;$i < 100;++$i){
    $origin_arr[] = mt_rand(1,10000);
}

#quick
$start = mill_time();
$sort_arr = quick_sort($origin_arr);
$end = mill_time();
echo 'quick time is :'.($end - $start).'ms'.PHP_EOL;

#bubble
$start = mill_time();
$sort_arr = bubble_sort($origin_arr);
$end = mill_time();
echo 'bubble time is :'.($end - $start).'ms'.PHP_EOL;;


$start = mill_time();
$sort_arr = hash_sort($origin_arr);
$end = mill_time();
echo 'bubble time is :'.($end - $start).'ms'.PHP_EOL;
echo count($sort_arr);

