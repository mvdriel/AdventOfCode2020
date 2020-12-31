<?php

$input = trim(file_get_contents('input'));
$lines = explode("\n\n", $input);

foreach ($lines as $tile) {
    $tile = explode("\n", $tile);
    $number = substr($tile[0], strlen('Tile '), -1);
    $tile = array_map(function($row) {
        return array_map(function($cell) {
            return (bool) $cell;
        }, str_split(strtr($row, ['.' => '0', '#' => '1'])));
    }, array_slice($tile, 1));
    $tiles[$number] = $tile;
}

$size = (int) sqrt(count($tiles));

$monster = <<<EOF
                  # 
#    ##    ##    ###
 #  #  #  #  #  #   
EOF;

$monster = array_map(function($row) {
    return array_map(function($cell) {
        return (bool) $cell;
    }, str_split(strtr($row, [' ' => '0', '#' => '1'])));
}, explode("\n", $monster));

$connections = [];
foreach ($tiles as $number0 => $tile0) {
    for ($i = 0; $i < 8; $i++) {
        $side0 = firstSide(transform($tile0, $i));

        foreach ($tiles as $number1 => $tile1) {
            if ($number0 === $number1) {
                continue;
            }
            for ($j = 0; $j < 8; $j++) {
                $side1 = firstSide(transform($tile1, $j));

                if ($side0 === $side1) {
                    $connections[$number0][$i] = [
                        $number1 => $j
                    ];
                }
            }        
        }
    }
}

$corners = array_filter($connections, function($connection) {
    return count($connection) === 4;
});

$map = [];
$transformations = [];

$map[0][0] = array_keys($corners)[0];

$transformations[0][0] = 2;
if ($size === 3) {
    $transformations[0][0] = 1;
}

for ($y = 0; $y < $size; $y++) {
    for ($x = 0; $x < $size; $x++) {
        if ($x === 0 && $y === 0) {
            continue;
        } elseif ($x === 0) {
            $tile = $map[$y - 1][$x];
            $transformation = $transformations[$y - 1][$x];
            $direction = 2;
        } else {
            $tile = $map[$y][$x - 1];
            $transformation = $transformations[$y][$x - 1];
            $direction = 1;
        }

        if ($transformation > 3) {
            $transformation = 4 + (($transformation + 4 + $direction) % 4);
        } else {
            $transformation = (($transformation + 4 - $direction) % 4);
        }

        $connection = $connections[$tile][$transformation];

        $map[$y][$x] = array_keys($connection)[0];

        $newTransformation = array_values($connection)[0];
        if ($direction === 2) {
            if ($newTransformation > 3) {
                $newTransformation -= 4;
            } else {
                $newTransformation += 4;
            }
        } else {
            if ($newTransformation > 3) {
                $newTransformation = (($newTransformation + 2 + $direction) % 4);
            } else {
                $newTransformation = 4 + (($newTransformation + 2 - $direction) % 4);
            }
        }

        $transformations[$y][$x] = $newTransformation;
    }
}

$total = mergeMap($map, $transformations);

$count = $monsterCount = 0;
$finalMap = null;
$finalPositions = [];
for ($i = 0; $i < 8; $i++) {
    $transformed = transform($total, $i);
    $positions = findMonsters($transformed);
    if (count($positions) >= $monsterCount) {
        $finalMap = $transformed;
        $monsterCount = count($positions);
        $count = countRoughWaters($transformed, $positions);
        $finalPositions = $positions;
    }
}

var_dump($count);


function transform($tile, $transform) {
    $result = [];
    
    switch ($transform) {
        case 0:
            $result = $tile;
            break;
        case 1: // rotate 90 degrees clock wise
            $result = array_map('array_reverse', array_map(null, ...$tile));
            break;
        case 2: // rotate 180 degrees clock wise
            $result = transform(transform($tile, 1), 1);
            break;
        case 3: // rotate 270 degrees clock wise
            $result = array_map(null, ...array_map('array_reverse', $tile));
            break;
        case 4:
            $result = array_map('array_reverse', $tile);
            break;
        case 5:
            $result = array_map(null, array_map('array_reverse', transform($tile, 1)));
            break;
        case 6:
            $result = array_map('array_reverse', transform($tile, 2));
            break;
        case 7:
            $result = array_map(null, array_map('array_reverse', transform($tile, 3)));
            break;
        }

    return $result;
}

function firstSide($tile) {
    return $tile[0];
}

function printTile($tile) {
    $result  = [];
    foreach ($tile as $row) {
        $line = '';
        foreach ($row as $cell) {
            if ($cell === null) {
                $line .= 'O';
            } else {
                $line .= $cell ? '#' : '.';
            }
        }
        $result [] = $line;
    }

    return $result;
}

function printMap($map, $transformations) {
    global $tiles;

    $result = [];
    foreach($map as $y => $row) {
        foreach($row as $x => $cell) {
            $result[$y * 14] = ($result[$y * 14] ?? '') . str_pad($cell . ' (' . $transformations[$y][$x] . ') ', 11, ' ');
            foreach (printTile(transform($tiles[$cell], $transformations[$y][$x])) as $i => $line) {
                $result[$y * 14 + $i + 1] = ($result[$y * 14 + $i + 1] ?? '') . str_pad($line, 11, ' ');
            }
        }
    }

    $result = implode("\n", $result);
    echo $result . "\n\n";
}

function mergeMap($map, $transformations) {
    global $tiles;

    $result = [];
    foreach($map as $y => $row) {
        foreach($row as $x => $cell) {
            foreach (transform($tiles[$cell], $transformations[$y][$x]) as $ty => $trow) {
                foreach ($trow as $tx => $tcell) {
                    if ($ty === 0 || $ty === 9 || $tx === 0 || $tx === 9) {
                        continue;
                    }
                    $result[$y * 8 + $ty - 1][$x * 8 + $tx - 1] = (bool)$tcell;
                }
            }
        }
    }

    return $result;
}

function findMonsters($map) {
    global $monster;

    $positions = [];
    for ($y = 0; $y < count($map) - count($monster) + 1; $y++) {
        for ($x = 0; $x < count($map[$y]) - count($monster[0]) + 1; $x++) {
            $valid = true;
            for ($my = 0; $my < count($monster); $my++) {
                for ($mx = 0; $mx < count($monster[$my]); $mx++) {
                    if (($monster[$my][$mx] !== false) && ($map[$y + $my][$x + $mx] !== true)) {
                        $valid = false;
                        break 2;
                    }
                }
            }
            if ($valid) {
                $positions[] = [$y, $x];
            }
        }
    }

    return $positions;
}

function markMonsters($map, $monsters) {
    global $monster;

    foreach ($monsters as $position) {
        list($y, $x) = $position;

        for ($my = 0; $my < count($monster); $my++) {
            for ($mx = 0; $mx < count($monster[$my]); $mx++) {
                if ($monster[$my][$mx] === true) {
                    $map[$y + $my][$x + $mx] = null;
                }
            }
        }
    }

    return $map;
}

function countRoughWaters($map, $monsters) {
    global $monster;

    foreach ($monsters as $position) {
        list($y, $x) = $position;

        for ($my = 0; $my < count($monster); $my++) {
            for ($mx = 0; $mx < count($monster[$my]); $mx++) {
                if ($monster[$my][$mx] === true) {
                    $map[$y + $my][$x + $mx] = null;
                }
            }
        }
    }

    $count = 0;

    foreach ($map as $row) {
        foreach ($row as $cell) {
            if ($cell === true) {
                $count++;
            }
        }
    }

    return $count;
}
