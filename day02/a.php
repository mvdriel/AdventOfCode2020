<?php

$data = file_get_contents('input');
$data = trim($data);
$data = explode("\n", $data);

$count = 0;

foreach ($data as $line) {
    list($line, $password) = explode(': ', $line);
    list($line, $char) = explode(' ', $line);
    list($min, $max) = explode('-', $line);
    $cnt = substr_count($password, $char);
    if ($cnt >= $min && $cnt <= $max) {
        $count++;
    }
}

var_dump($count);
