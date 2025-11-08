<?php

require 'libs/aoc.php';

$data = new AdventOfCode\AdventOfCode()->input(day: 8)
    ->lines()->regex('/(\w+) (inc|dec) ([-\d]+) if (\w+) ([=!<>]+) ([-\d]+)/');

$max = 0;
$registers = [];
foreach ($data as $row) {
    if (!isset($registers[$row[0]])) {
        $registers[$row[0]] = 0;
    }
    if (!isset($registers[$row[3]])) {
        $registers[$row[3]] = 0;
    }
    $v = $row[2] * ($row[1] == 'inc' ? 1 : -1);
    $p = $row[0];
    $r = $registers[$row[3]];
    $condition = "\$c = {$registers[$row[3]]} {$row[4]} {$row[5]};";
    eval($condition);
    if ($c) {
        $registers[$p] += $v;
        if ($registers[$p] > $max) {
            $max = $registers[$p];
        }
    }
}

arsort($registers);

print reset($registers) . "\n";

print $max . "\n";
