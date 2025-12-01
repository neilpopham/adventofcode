<?php

require 'libs/aoc.php';

$input = new AdventOfCode\AdventOfCode()->input(1)->lines();

$data = array_map(
    fn ($x) => str_replace(['L', 'R'], ['-', ''], $x),
    $input->raw()
);

$p = 50;
$total = 0;
foreach ($data as $value) {
    $p = ($p + $value) % 100;
    if ($p == 0) {
        $total++;
    }
}
print $total . "\n";

$p = 50;
$total = 0;
foreach ($data as $value) {
    $o = $p;
    $p = (100 + $p + ($value % 100)) % 100;
    $total += floor(abs($value) / 100);
    if ($p == 0) {
        $total++;
    } elseif ($o != 0 && ($value > 0 && $p < $o || $value < 0 && $p > $o)) {
        $total++;
    }
}
print $total . "\n";