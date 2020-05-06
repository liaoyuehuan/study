<?php
$datetime1 = new DateTime();
$datetime2 = new DateTime('2020-03-10');
$dateInterval = $datetime1->diff($datetime2);
var_dump($dateInterval);