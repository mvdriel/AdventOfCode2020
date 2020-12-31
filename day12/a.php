<?php

$input = trim(file_get_contents('input'));
$lines = explode("\n", $input);

$directions = [
    'E' => [1, 0],
    'S' => [0, -1],
    'W' => [-1, 0],
    'N' => [0, 1]
];

$ship = [0, 0];
$heading = 'E';

foreach ($lines as $line) {
    $action = $line[0];
    $value = (int) substr($line, 1);

    if ($action === 'F') {
        $action = $heading;
    }
    if ($action === 'L') {
        $value = -$value;
    }
    if (in_array($action, array_keys($directions), true)) {
        $ship = array_map(function($ship, $delta) use ($value) {
            return $ship + $delta * $value;
        }, $ship, $directions[$action]);
    } else {
        $index = (array_search($heading, array_keys($directions)) + ($value / 90)) % count($directions);
        $heading = array_keys($directions)[$index < 0 ? $index + count($directions) : $index];
    }
}

var_dump(array_sum(array_map('abs', $ship)));
