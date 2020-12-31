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
$waypoint = [10, 1];

foreach ($lines as $line) {
    $action = $line[0];
    $value = (int) substr($line, 1);

    if ($action === 'L') {
        $value = 360 - $value;
    }

    if (in_array($action, array_keys($directions), true)) {
        $waypoint = array_map(function($waypoint, $delta) use ($value) {
            return $waypoint + $delta * $value;
        }, $waypoint, $directions[$action]);
    } elseif ($action === 'F') {
        $ship = array_map(function($ship, $waypoint) use ($value) {
            return $ship + $waypoint * $value;
        }, $ship, $waypoint);
    } else {
        $qTurns = $value / 90;
        if ($qTurns % 2 === 1) {
            $waypoint = array_reverse($waypoint);
        }

        $multiplier = [
            $qTurns >= 2 ? -1 : 1,
            in_array($qTurns, [1, 2]) ? -1 : 1
        ];
        $waypoint = array_map(function($waypoint, $multiplier) {
            return $waypoint * $multiplier;
        }, $waypoint, $multiplier);
    }
}

var_dump(array_sum(array_map('abs', $ship)));
