<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(6);
$data = $input->lines()->raw();

foreach ($data as $i => $line) {
    if (false !== $p = strpos($line, '^')) {
        $sx = $p;
        $sy = $i;
    }
    $data[$i] = str_split($line);
}

$offsets = [[0, -1], [1, 0], [0, 1], [-1, 0]];

$x = $sx;
$y = $sy;
$d = 0;
$steps["{$x}|{$y}"] = 1;
do {
    $nx = $x + $offsets[$d][0];
    $ny = $y + $offsets[$d][1];

    if (isset($data[$ny][$nx])) {
        if ($data[$ny][$nx] == '#') {
            $d = ++$d % 4;
        } else {
            $x = $nx;
            $y = $ny;
            $steps["{$x}|{$y}"] = 1;
        }
    }
} while (isset($data[$ny][$nx]));
print count($steps) . "\n";

$steps = array_keys($steps);
$template = $data;
$total = 0;
for ($i = 1; $i < count($steps); $i++) {
    $data = $template;
    list($bx, $by) = explode('|', $steps[$i]);

    $data[$by][$bx] = '#';

    $x = $sx;
    $y = $sy;
    $d = 0;
    $previous = [];
    $done = false;
    do {
        $nx = $x + $offsets[$d][0];
        $ny = $y + $offsets[$d][1];

        if (isset($data[$ny][$nx])) {
            if ($data[$ny][$nx] == '#') {
                $d = ++$d % 4;
                if (!isset($previous[$y][$x])) {
                    $previous[$y][$x] = $d;
                } elseif ($previous[$y][$x] == $d) {
                    $done = true;
                    $total++;
                }
            } else {
                $x = $nx;
                $y = $ny;
            }
        } else {
            $done = true;
        }
    } while (!$done);
}
print $total . "\n";
