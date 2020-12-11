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

var_dump($lines[$i]);
