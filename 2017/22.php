<?php

require 'libs/aoc.php';

use AdventOfCode\Formatting as Console;

$data = new AdventOfCode\AdventOfCode()->input(day: 22)->lines()->raw();

$data = array_map(fn ($v) => str_split($v), $data);

$x = floor(count($data[0]) / 2);
$y = floor(count($data) / 2);
$d = 0;
$grid = new AdventOfCode\Grid($data);

$offsets = [[0, -1], [1, 0], [0, 1], [-1, 0]];

$total = 0;
for ($t = 0; $t < 10000; $t++) {
    $cell = $grid->cell($x, $y, '.');
    if ($cell == '.') {
        $d = ($d + 3) % 4;
        $grid->set($x, $y, '#');
        $total++;
    } else {
        $d = ($d + 1) % 4;
        $grid->set($x, $y, '.');
    }
    $x += $offsets[$d][0];
    $y += $offsets[$d][1];
}

print $total . "\n";

$x = floor(count($data[0]) / 2);
$y = floor(count($data) / 2);
$d = 0;
$grid = new AdventOfCode\Grid($data);
$total = 0;

$state = ['.' => 'W', 'W' => '#', '#' => 'F', 'F' => '.'];
$turn = ['.' => 3, 'W' => 0, '#' => '1', 'F' => 2];

for ($t = 0; $t < 10000000; $t++) {
    $cell = $grid->cell($x, $y, '.');
    $new = $state[$cell];
    $d = ($d + $turn[$cell]) % 4;
    $grid->set($x, $y, $new);
    if ($new == '#') {
        $total++;
    }
    $x += $offsets[$d][0];
    $y += $offsets[$d][1];
}

print $total . "\n";
