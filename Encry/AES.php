<?php
$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');

function hexToStr($hex)
{
    $str = '';
    $len = strlen($hex);
    for ($i = 0; $i < $len; $i += 2) {
        $str .= chr($hex{$i} . $hex{$i + 1});
    }
    return $str;
}

