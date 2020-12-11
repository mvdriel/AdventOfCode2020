<?php

$input = trim(file_get_contents('input'));
$lines = array_map('intval', explode("\n", $input));

$length = 25;
$last = array_slice($lines, 0, $length);

for ($i = $length; $i < count($lines); $i++) {
    $match = false;
    for ($j = 0; $j < $length; $j++) {
        for ($k = $j + 1; $k < $length; $k++) {
            if (($last[$j] !== $last[$k]) && ($last[$j] + $last[$k] === $lines[$i])) {
                $match = true;
                break 2;
            }
        }
    }
    if ($match === false) {
        break;
    }

    $last[$i % $length] = $lines[$i];
}

$result = $lines[$i];

$from = $until = 0;
do {
    $subset = array_slice($lines, $from, $until - $from);
    $sum = array_sum($subset);

    if ($sum < $result) {
        $until++;
    } else {
        $from++;
    }
} while ($sum !== $result);

var_dump(min($subset) + max($subset));
