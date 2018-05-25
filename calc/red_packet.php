<?php
$red_count = 10;       //红包个数
$red_amount = 100;   //红包金额

function handOut($red_amount, $red_count)
{
    $base_amount = 1;    //红包最低金额
    $red_amount *= 100;     //放大一百倍
    $surplus = $red_amount - $red_count * $base_amount; //剩余的金额
    $red_packet_list = [];
    for ($i = 0; $i < $red_count - 1; ++$i) {
        $rand_amount = mt_rand(0, $surplus);
        $surplus -= $rand_amount;
        $red_packet_list[] = $base_amount + $rand_amount;
    }
    $red_packet_list[] = $base_amount + $surplus;
    return $red_packet_list;
}

function handOut2($red_amount, $red_count)
{
    $base_amount = 1;    //红包最低金额
    $red_amount *= 100;     //放大一百倍
    $surplus = $red_amount - $red_count * $base_amount; //剩余的金额
    $red_packet_list = array_fill(0,$red_count,$base_amount);
    for ($i = 1; $i <= $surplus; ++$i) {
        $rand = floor(mt_rand(0,$surplus - $i) / 3);
        $i += $rand;
        $red_packet_list[mt_rand(0, $red_count - 1)] += $rand + 1;
    }
    return $red_packet_list;
}

$handOutRed = handOut($red_amount, $red_count);
var_dump($handOutRed);
var_dump(array_sum($handOutRed));

$handOutRed2 = handOut2($red_amount, $red_count);
var_dump($handOutRed2);
var_dump(array_sum($handOutRed2));
