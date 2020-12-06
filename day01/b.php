<?php

$data = file_get_contents('input');
$data = trim($data);
$data = explode("\n", $data);

for ($i = 0; $i < count($data); $i++) {
    for ($j = 0; $j < count($data); $j++) {
        for ($k = 0; $k < count($data); $k++) {
            if($data[$i] + $data[$j] + $data[$k] === 2020) {
                var_dump($data[$i] * $data[$j] * $data[$k]);
                exit;
            }
        }
    }
}
