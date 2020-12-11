<?php

$input = trim(file_get_contents('input'));

$adapters = explode("\n", $input);

$adapters[] = max($adapters) + 3;
$adapters[] = 0;

sort($adapters);

$counts = [];
$counts[0] = 1;

for ($i = 0; $i < count($adapters); $i++) {
    for ($j = 1; $j < 4; $j++) {
        if (in_array($adapters[$i] + $j, $adapters)) {
            $counts[$adapters[$i] + $j] = ($counts[$adapters[$i] +$j] ?? 0) + ($counts[$adapters[$i]] ?? 0);
        }
    }
}

var_dump($counts[max($adapters)]);
