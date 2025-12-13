<?php

require 'libs/aoc.php';

$input = new AdventOfCode\AdventOfCode()->input(12)->lines();

$data = $input->raw();

$index = 0;
$shapes = [];
foreach ($data as $line) {
    if (preg_match('/[#\.]+/', $line, $matches)) {
        $line = str_replace('#', $index, $line);
        $shapes[$index][] = str_split($line);
    } elseif (preg_match('/(\d+)x(\d+): (.+)/', $line, $matches)) {
        $matches[3] = explode(' ', trim($matches[3]));
        $regions[] = array_slice($matches, 1);
    } elseif (empty($line)) {
        $index++;
    }
}

$total = 0;
foreach ($regions as [$width, $height, $counts]) {
    $area = $width * $height;
    $required = 9 * array_sum($counts);
    $total += $area >= $required;
}
print $total . "\n";
