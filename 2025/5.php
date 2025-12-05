<?php

require 'libs/aoc.php';

$input = new AdventOfCode\AdventOfCode()->input(5)->lines();

$data = $input->raw();

$ranges = [];
$ingredients = [];
foreach ($data as $line) {
    if (preg_match('/(\d+)\-(\d+)/', $line, $matches)) {
        $ranges[] = array_map(fn ($x) => preg_match('/^\d+$/', $x) ? (int) $x : $x, $matches);
    } elseif (preg_match('/(\d+)/', $line)) {
        $ingredients[] = (int) $line;
    }
}

$total = 0;
foreach ($ingredients as $ingredient) {
    foreach ($ranges as $range) {
        if ($ingredient >= $range[1] && $ingredient <= $range[2]) {
            $total++;
            break;
        }
    }
}
print $total . "\n";

$reduced = [];
usort($ranges, fn($a, $b) => $a[1] <=> $b[1]);
foreach ($ranges as $range) {
    $merged = false;
    foreach ($reduced as $key => $value) {
        if ($range[1] <= $value[2]) {
            $reduced[$key][2] = max($value[2], $range[2]);
            $merged = true;
            break;
        }
    }
    if (!$merged) {
        $reduced[] = $range;
    }
}
$total = array_reduce($reduced, fn($total, $range) => $total += $range[2] - $range[1] + 1);
print $total . "\n";
