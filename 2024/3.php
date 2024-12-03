<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(3);
$data = $input->raw();

preg_match_all('/mul\((\d{1,3}),(\d{1,3})\)/', $data, $matches, PREG_SET_ORDER);

$total = array_reduce($matches, fn($total, $match) => $total += $match[1] * $match[2]);
print $total . "\n";

preg_match_all('/do\(\)|don\'t\(\)|mul\((\d{1,3}),(\d{1,3})\)/', $data, $matches, PREG_SET_ORDER);

$total = 0;
$count = true;
foreach ($matches as $match) {
    switch ($match[0]) {
        case "do()":
            $count = true;
            break;
        case "don't()":
            $count = false;
            break;
        default:
            if ($count) {
                $total += $match[1] * $match[2];
            }
    }
}
print $total . "\n";
