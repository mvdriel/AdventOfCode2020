<?php

$input = trim(file_get_contents('input'));
$adapters = array_map('intval', explode("\n", $input));

$first = 0;
$last = max($adapters) + 3;
$adapters = array_merge($adapters, [$first, $last]);

sort($adapters);

$counts = [];
$counts[$first] = 1;

foreach ($adapters as $adapter) {
    for ($i = 1; $i < 4; $i++) {
        $target = $adapter + $i;
        if (in_array($target, $adapters, true)) {
            $counts[$target] = ($counts[$target] ?? 0) + ($counts[$adapter] ?? 0);
        }
    }
}

var_dump($counts[$last]);
