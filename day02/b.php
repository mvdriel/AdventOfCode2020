<?php

$data = file_get_contents('input');
$data = trim($data);
$data = explode("\n", $data);

$count = 0;

foreach ($data as $line) {
    list($line, $password) = explode(': ', $line);
    list($line, $char) = explode(' ', $line);
    list($min, $max) = explode('-', $line);

    if (
        ($password[$min-1] === $char && $password[$max-1] !== $char) ||
        ($password[$min-1] !== $char && $password[$max-1] === $char)
    ) {
        $count++;
    }
}

var_dump($count);
