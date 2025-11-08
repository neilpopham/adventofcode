<?php

require 'libs/aoc.php';

$data = new AdventOfCode\AdventOfCode()->input(day: 11)->raw();
$data = explode(',', $data);

$offset = [
    'n' => [0, -2],
    'ne' => [1, -1],
    'se' => [1, 1],
    's' => [0, 2],
    'sw' => [-1, 1],
    'nw' => [-1, -1],
];

function steps($x, $y)
{
    $ax = abs($x);
    $ay = abs($y);
    if ($ax < $ay) {
        $steps = $ax;
        $ay -= $ax;
        $steps += $ay / 2;
        return $steps;
    }
    return null;
}

$x = 0;
$y = 0;
$max = 0;
foreach ($data as $move) {
    $x += $offset[$move][0];
    $y += $offset[$move][1];
    $max = max($max, steps($x, $y));
}

print steps($x, $y) . "\n";
print $max . "\n";
