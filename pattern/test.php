<?php
$object = 'MtClassName';
$after_object = preg_replace('/(?<=[a-z])(?=[A-Z])/','_',$object);
echo $after_object;