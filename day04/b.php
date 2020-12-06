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

    list($byr, $iyr, $eyr, $hgt, $hcl, $ecl, $pid) = [$values['byr'] ?? '', $values['iyr'] ?? '', $values['eyr'] ?? '', $values['hgt'] ?? '', $values['hcl'] ?? '', $values['ecl'] ?? '', $values['pid'] ?? ''];

    if (
        (array_intersect($required, array_keys($values)) === $required) &&
        // byr (Birth Year) - four digits; at least 1920 and at most 2002.
        preg_match('/^[0-9]{4}$/', $byr) && (intval($byr) >= 1920) && (intval($byr) <= 2002) &&
        // iyr (Issue Year) - four digits; at least 2010 and at most 2020.
        preg_match('/^[0-9]{4}$/', $iyr) && (intval($iyr) >= 2010) && (intval($iyr) <= 2020) &&
        // eyr (Expiration Year) - four digits; at least 2020 and at most 2030.
        preg_match('/^[0-9]{4}$/', $eyr) && (intval($eyr) >= 2020) && (intval($eyr) <= 2030)  &&
        // hgt (Height) - a number followed by either cm or in:
        (
            // If cm, the number must be at least 150 and at most 193.
            (preg_match('/^[0-9]{3}cm$/', $hgt) && (intval($hgt) >= 150) && (intval($hgt) <= 193)) ||
            // If in, the number must be at least 59 and at most 76.
            (preg_match('/^[0-9]{2}in$/', $hgt) && (intval($hgt) >= 59) && (intval($hgt) <= 76))
        ) &&
        // hcl (Hair Color) - a # followed by exactly six characters 0-9 or a-f.
        preg_match('/^#[0-9a-f]{6}$/', $hcl) &&
        // ecl (Eye Color) - exactly one of: amb blu brn gry grn hzl oth.
        in_array($ecl, ['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth']) &&
        // pid (Passport ID) - a nine-digit number, including leading zeroes.
        preg_match('/^[0-9]{9}$/', $pid)
    ) {
        $count++;
    }
}

var_dump($count);
