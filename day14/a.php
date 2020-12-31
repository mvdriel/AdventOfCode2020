<?php

$input = trim(file_get_contents('input'));
$lines = explode("\n", $input);

$mask = null;
$memory = [];

foreach ($lines as $line) {
    list($lhs, $rhs) = explode(' = ', $line);
    switch ($lhs) {
        case 'mask':
            $mask = $rhs;
            break;
        default:
            $address = (int) substr($lhs, strlen('mem['), -strlen(']'));
            $memory[$address] = $rhs & bindec(str_replace('X', '1', $mask)) | bindec(str_replace('X', '0', $mask));
            break;
    }
}

var_dump(array_sum($memory));
