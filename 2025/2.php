<?php

require 'libs/aoc.php';

$input = new AdventOfCode\AdventOfCode()->input(2)->raw();

$data = array_map(
    fn ($x) => explode('-', $x),
    explode(',', $input)
);

$total = 0;
foreach ($data as $values) {
    for ($value = $values[0]; $value <= $values[1]; $value++) {
        if (strlen($value) % 2 == 1) {
            continue;
        }
        $half = strlen($value) / 2;
        if (substr($value, 0, $half) == substr($value, $half)) {
            $total += $value;
        }
    }
}
print $total . "\n";

$total = 0;
foreach ($data as $values) {
    for ($value = $values[0]; $value <= $values[1]; $value++) {
        $half = floor(strlen($value) / 2);
        for ($x = 1; $x <= $half; $x++) {
            $parts = str_split($value, $x);
            $set = array_combine($parts, $parts);
            if (count($set) == 1) {
                $total += $value;
                break;
            }
        }
    }
}
print $total . "\n";
