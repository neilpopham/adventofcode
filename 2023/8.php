<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(8);

$data = $input->lines()->raw();

$directions = str_split(str_replace(['L', 'R'], ['0', '1'], array_shift($data)));
array_shift($data);

$instructions = [];
foreach ($data as $key => $value) {
    if (preg_match('/(\w+) = \((\w+), (\w+)\)/', $value, $matches)) {
        $instructions[$matches[1]] = [$matches[2], $matches[3]];
    }
}
unset($data);

$steps = 0;
$d = 0;
$key = 'AAA';
do {
    $key = $instructions[$key][$directions[$d]];
    $steps++;
    $d++;
    if (!isset($directions[$d])) {
        $d = 0;
    }
} while ($key != 'ZZZ');
print $steps . "\n";

foreach (array_keys($instructions) as $value) {
    if (substr($value, -1) == 'A') {
        $keys[] = $value;
    }
}
$steps = 0;
$d = 0;
foreach ($keys as $start) {
    $key = $start;
    $cycles[$start] = 0;
    do {
        $key = $instructions[$key][$directions[$d]];
        $steps++;
        $d++;
        if (!isset($directions[$d])) {
            $d = 0;
            $cycles[$start]++;
        }
    } while (substr($key, -1) !== 'Z');
}
print array_product($cycles) * count($directions) . "\n";
