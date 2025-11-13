<?php

require 'libs/aoc.php';

$data = new AdventOfCode\AdventOfCode()->input(day: 19)->lines(false)->raw();

$data = array_map(fn($x) => str_split($x), $data);

$steps = 0;
$letters = [];
$dx = 0;
$dy = 1;
$y = 0;
foreach ($data[0] as $x => $c) {
    if ($c == '|') {
        break;
    }
}

do {
    $steps++;
    if (preg_match('/[A-Z]/', $data[$y][$x])) {
        $letters[] = $data[$y][$x];
    } elseif ($data[$y][$x] == '+') {
        if ($dx == 0) {
            $dy = 0;
            if ($data[$y][$x + 1] != ' ') {
                $dx = 1;
            } else {
                $dx = -1;
            }
        } else {
            $dx = 0;
            if ($data[$y + 1][$x] != ' ') {
                $dy = 1;
            } else {
                $dy = -1;
            }
        }
    }
    $x += $dx;
    $y += $dy;
} while ($data[$y][$x] != ' ');

print implode('', $letters) . "\n";

print $steps . "\n";
