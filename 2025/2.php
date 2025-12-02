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
        if (preg_match('/^(\d+)\1$/', $value)) {
            $total += $value;
        }
    }
}
print $total . "\n";

$total = 0;
foreach ($data as $values) {
    for ($value = $values[0]; $value <= $values[1]; $value++) {
        if (preg_match('/^(\d+)\1+$/', $value)) {
            $total += $value;
        }
    }
}
print $total . "\n";
