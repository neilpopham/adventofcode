<?php

require 'libs/aoc.php';

$data = new AdventOfCode\AdventOfCode()->input(day: 20)->lines()->raw();

foreach ($data as $i => $row) {
    preg_match_all('/([pva])=<([-\d]+),([-\d]+),([-\d]+)>/', $row, $matches, PREG_SET_ORDER);
    // print_r($matches);
    $data[$i] = (object) [
        'p' => (object) ['x' => $matches[0][2], 'y' => $matches[0][3], 'z' => $matches[0][4]],
        'v' => (object) ['x' => $matches[1][2], 'y' => $matches[1][3], 'z' => $matches[1][4]],
        'a' => (object) ['x' => $matches[2][2], 'y' => $matches[2][3], 'z' => $matches[2][4]],
    ];
}

print_r($data);