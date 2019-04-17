<?php
function bankRound($number)
{
    if (false === is_numeric($number)) {
        throw new RuntimeException('param is not number');
    }
    $numberArr = explode('.', $number, 2);
    $numberInt = $numberArr[0];
    $numberFloat = isset($numberArr[1]) ? (float)('0.' . $numberArr[1]) : 0.0;

    if ($numberFloat >= 0.6) {
        $numberInt += 1;
    } elseif ($numberFloat > 0.5) {
        $numberInt += 1;
    } elseif ($numberFloat == 0.5 && $numberInt % 2 == 1) {
        $numberInt += 1;
    }
    return $numberInt;
}

var_dump(bankRound(2.520));