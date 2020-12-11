<?php

$input = trim(file_get_contents('input'));
$adapters = explode("\n", $input);

$adapters[] = max($adapters) + 3;
$adapters[] = 0;

sort($adapters);

$counts = [];
for ($i = 1; $i < count($adapters); $i++) {
    $counts[$adapters[$i] - $adapters[$i-1]] = ($counts[$adapters[$i] - $adapters[$i-1]] ?? 0) + 1;
}

var_dump($counts[1] * $counts[3]);
