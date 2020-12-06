<?php

$data = file_get_contents('input');
$data = trim($data);
$data = explode("\n", $data);

$count = 0;
for ($i = $j = 0; $i < count($data); $i++, $j += 3) {
    if ($data[$i][$j % count(str_split($data[$i]))] === '#') {
        $count++;
    }
}

var_dump($count);
