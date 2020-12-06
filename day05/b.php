<?php

$input = trim(file_get_contents('input'));
$lines = explode("\n", $input);

$lines = array_map(function ($line) {
    return bindec(str_replace(['F','B', 'L', 'R'], ['0', '1', '0', '1'], $line));
}, $lines);

for ($i = 1; true; $i++) {
    if (!in_array($i, $lines) && in_array($i + 1, $lines) && in_array($i - 1, $lines)) {
        var_dump($i);
        exit;
    }
}
