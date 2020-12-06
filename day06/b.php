<?php

$input = trim(file_get_contents('input'));
$groups = explode("\n\n", $input);

$count = 0;
foreach ($groups as $group) {
    $lines = explode("\n", trim($group));
    $lines = array_map(function($line) {
        return array_unique(str_split($line));
    }, $lines);

    if (count($lines) === 1) {
        $count += count($lines[0]);
    } else {
        $count += count(call_user_func_array('array_intersect', $lines));
    }
}

var_dump($count);
