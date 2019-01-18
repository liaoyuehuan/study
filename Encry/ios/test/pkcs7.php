<?php
$url = 'https://www.eimoney.com/diamonds/api/auth/';
$ch = curl_init($url);
$data = file_get_contents(__DIR__ . '/Auth.p7c');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => false,
    CURLOPT_HEADER =>  true,
    CURLOPT_POST => true,
    CURLOPT_TCP_KEEPALIVE => true,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_USERAGENT => 'Profile/1.0',
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/pkcs7-signature'
    ],
    CURLOPT_POSTFIELDS => $data
]);
$response = curl_exec($ch);
if (curl_errno($ch)){
    var_dump(curl_error($ch));

}
var_dump(curl_getinfo($ch));
