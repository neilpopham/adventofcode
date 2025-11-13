<?php

require 'libs/aoc.php';

$data = new AdventOfCode\AdventOfCode()->input(day: 17)->raw();

function process($step, $loops, $index = null)
{
    $pos = 0;
    $positions = [0];

    for ($i = 0; $i < $loops; $i++) {
        if ($i > 0) {
            $pos = ($pos + $step) % ($i + 1);
        }
        array_splice($positions, ++$pos, 0, [$i + 1]);
    }

    return $index === null ? $positions[$pos + 1] : $positions[$index];
}

print process($data, 2017) . "\n";

print process($data, 50000000, 1) . "\n";
