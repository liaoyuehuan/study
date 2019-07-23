<?php
# 获取file.txt 文件里的所有行
var_dump(array_map(function ($value){
    return trim($value);
},file(__DIR__.'/file.txt')));
