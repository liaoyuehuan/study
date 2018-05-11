<?php
    $str = 'sad,sadsa';
    $row = preg_match('/[\w\d,]*/',$str,$rs);
    var_dump($rs);