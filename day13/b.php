<?php

$input = trim(file_get_contents('input'));
list( , $busses) = explode("\n", $input);

$busses = explode(',', $busses);
$busses = array_combine(array_values($busses), array_keys($busses));

$busses = array_filter($busses, function($bus) {
    return $bus !== 'x';
}, ARRAY_FILTER_USE_KEY);

$incr = 1;
$timestamp = 0;

while (count($busses) > 0) {
    $timestamp += $incr;

    foreach ($busses as $bus => $offset) {
        if ((($timestamp + $offset) % $bus) === 0) {
            $incr *= $bus;
            unset($busses[$bus]);
            if (count($busses) === 0) {
                break;
            }
        }
    }
}

var_dump($timestamp);
