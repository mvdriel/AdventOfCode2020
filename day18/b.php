<?php

$input = trim(file_get_contents('input'));

$input = <<<EOF
1 + 2 * 3 + 4 * 5 + 6
1 + (2 * 3) + (4 * (5 + 6))
2 * 3 + (4 * 5)
5 + (8 * 3 + 9 + 3 * 4 * 3)
5 * 9 * (7 * 3 * 3 + 9 * 3 + (8 + 6 * 4))
((2 + 4 * 9) * (6 + 9 * 8 + 6) + 6) + 2 + 4 * 2
(6) + 2 + 4 * 2
EOF;

$lines = explode("\n", $input);

$sum = array_sum(array_map(function($line) {
    var_dump(($line));
    var_dump(convert($line));
    $sum = (eval('$x = (' . convert($line) . '); return $x;'));
    var_dump($sum);
    return $sum;
}, $lines));

var_dump($sum);

function convert($line) {
    $line = str_replace(' ', '', $line);
    $start = $end = '';

    $brackets = 0;
    for ($i = 0; $i < strlen($line); $i++) {
        if ($line[$i] === ')') {
            if ($brackets === 0) {
                return $start . $end;
            }
            $brackets--;
            continue;
        }

        if ($brackets > 0) {
            if ($line[$i] === '(') {
                $brackets++;
            }
            continue;
        }

        switch($line[$i]) {
            case '(':
                if ($start === '') {
                    $start = '(' . convert(substr($line, $i + 1)) . ')';
                } else {
                    $start = '(' . $start . '(' . convert(substr($line, $i + 1)) . '))';
                }
                $brackets++;
                break;
            case '+':
                $start .= $line[$i];
                break;
            case '*':
                $start = '(' . $start . ')' . $line[$i] . '(';
                $end = $end . ')';
                break;
            default:
                $start .= $line[$i];
        }
    }

    return $start . $end;
}
