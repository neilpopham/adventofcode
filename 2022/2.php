<?php

require 'libs/api.php';

$api = new AdventOfCode();

$data = $api->input(2)->lines()->regex('/^(\w) (\w)$/');

$scores = [
    'X' => ['A' => 4, 'B' => 1, 'C' => 7],
    'Y' => ['A' => 8, 'B' => 5, 'C' => 2],
    'Z' => ['A' => 3, 'B' => 9, 'C' => 6],
];

$total = 0;
foreach ($data as $items) {
    $total += $scores[$items[1]][$items[0]];
}
print "{$total}\n";

$map = [
    'X' => ['A' => 'Z', 'B' => 'X', 'C' => 'Y'],
    'Y' => ['A' => 'X', 'B' => 'Y', 'C' => 'Z'],
    'Z' => ['A' => 'Y', 'B' => 'Z', 'C' => 'X'],
];

$total = 0;
foreach ($data as $items) {
    $item = $map[$items[1]][$items[0]];
    $total += $scores[$item][$items[0]];
}
print "{$total}\n";
