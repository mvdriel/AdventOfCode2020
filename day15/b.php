<?php

$input = '5,2,8,16,18,0,1';
$input = trim($input);

$numbers = explode(',', $input);
$numbers = array_map('intval', $numbers);

$history = [];
$before = $last = false;

for ($i = 0; $i < 30000000; $i++) {
    if (false !== $last) {
        $before = $history[$last] ?? false;
        $history[$last] = $i - 1;
    }

    if ($i < count($numbers)) {
        $number = $numbers[$i];
    } elseif ($before === false) {
        $number = 0;
    } else {
        $number = $i - 1 - $before;
    }

    $last = $number;
}

var_dump($last);
