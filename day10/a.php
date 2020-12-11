<?php

$input = trim(file_get_contents('input'));
$adapters = array_map('intval', explode("\n", $input));

$adapters = array_merge($adapters, [0, max($adapters) + 3]);

sort($adapters);

$counts = [];
for ($i = 1; $i < count($adapters); $i++) {
    $diff = $adapters[$i] - $adapters[$i - 1];
    $counts[$diff] = ($counts[$diff] ?? 0) + 1;
}

var_dump($counts[1] * $counts[3]);
