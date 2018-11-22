<?php
function temp()
{
    file_put_contents('php://temp', 'hi');
    $data = file_get_contents('php://temp'); //啥也没有

    $fp = fopen('php://temp', 'w+');
    fwrite($fp, "hi");
    fwrite($fp, " xiaoliao");
    fseek($fp, 0);
    $data = fread($fp, 10);
    var_dump($data);
}

