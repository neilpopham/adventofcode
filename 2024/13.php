<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(13);
$data = $input->lines()->raw();

$key = 0;
$machines = [];
foreach ($data as $i => $value) {
    if (empty($value)) {
        $key++;
    } elseif (preg_match('/Button A: X\+(\d+), Y\+(\d+)/', $value, $matches)) {
        $j = 0;
    } elseif (preg_match('/Button B: X\+(\d+), Y\+(\d+)/', $value, $matches)) {
        $j = 1;
    } elseif (preg_match('/Prize: X=(\d+), Y=(\d+)/', $value, $matches)) {
        $j = 2;
    }
    $machines[$key][$j] = [(int) $matches[1], (int) $matches[2]];
}

$total = 0;
foreach ($machines as $i => $machine) {
    $complete = [];
    for ($a = 0; $a < 101; $a++) {
        for ($b = 0; $b < 101; $b++) {
            $x = $machine[0][0] * $a + $machine[1][0] * $b;
            $y = $machine[0][1] * $a + $machine[1][1] * $b;
            if ($x == $machine[2][0] && $y == $machine[2][1]) {
                $complete[] = [$a, $b, $a * 3 + $b];
            }
        }
    }
    if (empty($complete)) {
        continue;
    }
    usort($complete, fn($a, $b) => $a[2] <=> $b[2]);
    $best = reset($complete);
    $total += $best[2];
}
print $total . "\n";
