<?php

$input = trim(file_get_contents('input'));
$lines = explode("\n", $input);

$lines = array_map(function ($line) {
    return bindec(str_replace(['F','B', 'L', 'R'], ['0', '1', '0', '1'], $line));
}, $lines);

var_dump(max($lines));
