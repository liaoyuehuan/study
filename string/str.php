<?php
$str = '尊敬的客户: {user} , 您的短信验证码是：{code}！';
# strtr  该方法会替换多次
$res = strtr($str,[
    '{user}' => '廖阅换',
    '{code}' => '107108'
]);
# wordwrap 按字节去切割
$res = wordwrap($str,3,'|',true);
var_dump($res);
