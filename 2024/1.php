<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(1);
$data = $input->lines()->raw();

$numbers = [];
foreach ($data as $i => $line) {
    list($numbers[0][$i], $numbers[1][$i]) = explode('   ', $line);
}

sort($numbers[0]);
sort($numbers[1]);

$total = 0;
for ($i = 0; $i < count($data); $i++) {
    $total +=  abs($numbers[0][$i] - $numbers[1][$i]);
}
print $total . "\n";

$counts = array_count_values($numbers[1]);

$total = 0;
foreach ($numbers[0] as $number) {
    $total += isset($counts[$number]) ? ($number * $counts[$number]) : 0;
}
print $total . "\n";
