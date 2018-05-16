<?php
function a(){
    b();
}
function b(){
    c();
}

function c(){
    debug_print_backtrace();
}
//a();


function s_a(){
    s_b('hi','aaa');
}

function s_b($name,$ok = 'ok',...$args){
    s_c();
}

function s_c(){
    /**
     * DEBUG_BACKTRACE_PROVIDE_OBJECT   : .3.6 之前 -> true
     * DEBUG_BACKTRACE_IGNORE_ARGS      : .3.6 之前 -> false   #数组少了 args
     *  array(4) {
            ["file"]=>
                string(65) "D:\webtools\Apache24\htdocs\study\error\debug_print_backtrace.php"
            ["line"]=>
                int(28)
            ["function"]=>
                string(3) "s_a"
            ["args"]=>
                array(0) {
            }
        }
     */

    $rs = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);

    var_dump($rs);
}

s_a();