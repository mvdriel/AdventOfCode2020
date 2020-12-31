<?php

$input = trim(file_get_contents('input'));
$lines = explode("\n", $input);

$mask = null;
$memory = [];

foreach ($lines as $line) {
    list($lhs, $rhs) = explode(' = ', $line);
    if ($lhs === 'mask') {
        $mask = $rhs;
    } else {
        $address = (int)substr($lhs, strlen('mem['), -strlen(']'));

        $address = $address | bindec(str_replace('X', '0', $mask));

        $bits = str_pad(decbin($address), 36, '0', STR_PAD_LEFT);
        // for ($i = 0; $i < strlen($mask); $i++) {
        //     if ($mask[$i] === '1') {
        //         $bits[$i] = $mask[$i];
        //     }
        // }


        $mask = bindec(str_replace('X', '1', str_replace('1', '0', $mask)));

        while ($mask > 0) {
            $mask = ($mask - 1) & $mask;
        }



        $positions = [];
        for ($i = 0; $i < strlen($mask); $i++) {
            if ($mask[$i] === 'X') {
                $positions[] = $i;
            }
        }

        $addresses = [];
        if (count($positions) === 0) {
            $addresses[] = bindec($bits);
        } else {
            for($i = 0; $i < pow(2, count($positions)); $i++) {
                foreach ($positions as $j => $position) {
                    $bits[$position] = str_pad(decbin($i), count($positions), '0', STR_PAD_LEFT)[$j];
                }
                $addresses[] = bindec($bits);
            }
        }

        foreach($addresses as $address) {
            $memory[$address] = $rhs;
        }
    }
}

var_dump(array_sum($memory));
