<?php
#说明
#format后面数字:
#    无     ：1
#    数字   ：几个字符
#    *      ：所有字符
#无符号有符号
# pack 时不区分，unpack区分
#a和A
$string = pack('a5', "ab");  //后面三位由 NULL 补齐
echo "pack a5: ";
var_dump($string);
$string = pack("A5", "ab"); //后面三位由空格"space" 补齐
echo "pack A5: ";
var_dump($string);

#h和H
$string = pack("H", "4142"); //输出AB 高位在前
echo "pack H4:";
var_dump($string);
$string = pack("h4", "1424"); //输出AB 低位在前
echo "pack h4: ";
var_dump($string);

#c和C
$string = pack("c*",65,66); //输出AB 有符号字符
echo "pack c*: ";var_dump($string);
$string = pack("C*",65,66); //输出AB 无符号字符
echo "pack C*: ";var_dump($string);

#l和L
$string = pack("l",12345678);
echo "pack l :";var_dump($string);
$string = pack("L",12345678);
echo "pack l :";var_dump($string);
