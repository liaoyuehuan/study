<?php

if(!isset($argv[1])) {
    echo 'filename : argument 1 is required';
}
$filename = $argv[1];

$content = file_get_contents($filename);
preg_match('`.*,',$content,$rs);
var_dump($rs);

var_dump(floor(time() / 2) * 2);

$password = '12345';
$salt = '3JL7z3zk';
$salt2 = 'nPCHs4fr3K1q4It0tVMr';
var_dump(DoEmpireCMSAdminPassword($password,$salt,$salt2));

function DoEmpireCMSAdminPassword($password,$salt,$salt2){
    $pw=md5($salt2.'E!m^p-i(r#e.C:M?S'.md5(md5($password).$salt).'d)i.g^o-d'.$salt);
    return $pw;
}

