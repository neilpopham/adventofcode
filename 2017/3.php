<?php

require 'libs/aoc.php';

$number = new AdventOfCode\AdventOfCode()->input(3)->raw();

$i = 1;
do {
    $i += 2;
} while (pow($i, 2) < $number);

$c = pow($i - 2, 2);
$x = $y = floor($i / 2);

$offsets = [[0,-1], [-1,0], [0,1], [1,0]];
$o = 0;
$d = 0;

while ($c != $number) {
    if ($d == $i - 1) {
        $o++;
        $d = 0;
    }
    $x += $offsets[$o][0];
    $y += $offsets[$o][1];
    $c++;
    $d++;
}

$distance = abs($x) + abs($y);

print $distance . "\n";

$offsets = [[0,-1], [1,0], [0,1], [-1,0]];
$x = 1;
$y = 0;
$d = 0;
$grid = [[1, 1]];
$value = 1;
while ($value < $number) {
    $nd = ($d + 3) % 4;
    $nx = $x + $offsets[$nd][0];
    $ny = $y + $offsets[$nd][1];
    if (!isset($grid[$ny]) || !isset($grid[$ny][$nx])) {
        $x = $nx;
        $y = $ny;
        $d = $nd;
    } else {
        $x += $offsets[$d][0];
        $y += $offsets[$d][1];
    }
    $value = 0;
    for ($oy = -1; $oy <= 1; $oy++) {
        for ($ox = -1; $ox <= 1; $ox++) {
            if (isset($grid[$y + $oy]) & isset($grid[$y + $oy][$x + $ox])) {
                $value += $grid[$y + $oy][$x + $ox];
            }
        }
    }
    $grid[$y][$x] = $value;
}

print $value . "\n";
