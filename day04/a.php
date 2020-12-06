<?php

$input = trim(file_get_contents('input'));
$passports = explode("\n\n", $input);

$required = ['byr', 'iyr', 'eyr', 'hgt', 'hcl', 'ecl', 'pid'];

$count = 0;
foreach ($passports as $passport) {
    $passport = explode(' ', str_replace("\n", ' ', trim($passport)));
    
    $values = [];
    foreach ($passport as $kvp) {
        list($key, $value) = explode(':', trim($kvp));
        $values[$key] = $value;
    }

    if (array_intersect($required, array_keys($values)) === $required) {
        $count++;
    }
}

var_dump($count);
