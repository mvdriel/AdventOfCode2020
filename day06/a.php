<?php

$input = trim(file_get_contents('input'));
$groups = explode("\n\n", $input);

$count = 0;
foreach ($groups as $group) {
    $group = str_replace("\n", '', trim($group));
    $group = str_split($group);
    $count += count(array_unique($group));
}

var_dump($count);
