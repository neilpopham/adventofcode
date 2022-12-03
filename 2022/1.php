<?php

require 'libs/api.php';

$api = new AdventOfCode();

$data = $api->input(1)->lines();

$food = [0];
$elf = 0;

foreach ($data as $value) {
    if (empty($value)) {
        $elf++;
        $food[$elf] = 0;
    } else {
        $food[$elf] += $value;
    }
}

rsort($food);

print $food[0] . "\n";

print array_sum(array_slice($food, 0, 3)) . "\n";
