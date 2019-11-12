<?php
$fp = fopen(__DIR__ . '/file.csv', 'r');
while ($data = fgetcsv($fp, 1000, '|')) {
    var_dump($data);
}