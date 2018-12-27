<?php
$string = exec("dir", $output, $return_var);
//echo 'exec : ';var_dump($string,$return_var,$output);

#passthru("dir",$return_var);
//echo 'passthru : ';var_dump($return_var);

$string = shell_exec('dir');
//echo 'shell_exec : ';var_dump($string);

//$string = system('dir', $return_var);
//echo 'system : ';var_dump($return_var . $string);

echo 'escapeshellarg : '.(escapeshellarg('a "sds" ad')).PHP_EOL;
echo 'escapeshellcmd : '.(escapeshellcmd('as"ds"ad')).PHP_EOL;
