<?php

$data = file_get_contents('input');
$data = trim($data);
$data = explode("\n", $data);

$rights = [1,3,5,7,1];
$downs  = [1,1,1,1,2];

$mul = 1;
for ($x = 0; $x < count($rights); $x++) {
    $right = $rights[$x];
    $down = $downs[$x];

    $count = 0;
    for ($i = $j = 0; $i < count($data); $i += $down, $j += $right) {
        if ($data[$i][$j % count(str_split($data[$i]))] === '#') {
            $count++;
        }
    }

    $mul *= $count;

}


var_dump($mul);
