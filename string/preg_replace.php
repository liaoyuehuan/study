<?php
$name = "HelloWorld";
echo  preg_replace("/[A-Z]/", "_\\0", $name).PHP_EOL;

echo  preg_replace("/(?<=[a-z])(?=[A-Z])/", "_", $name).PHP_EOL;