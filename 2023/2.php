<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(2);

$data = $input->lines()->regex('/Game (\d+): (.+)/');

foreach ($data as $i => $line) {
    $data[$i][1] = array_map(
        function ($list) {
            return array_map(
                function ($cube) {
                    preg_match('/(\d+) (\w+)/', $cube, $matches);
                    return array_slice($matches, 1);
                },
                explode(',', $list)
            );
        },
        explode(';', $line[1])
    );
}

$max = ['red' => 12, 'green' => 13, 'blue' => 14];

$total = 0;
foreach ($data as $line) {
    $valid = true;
    foreach ($line[1] as $set) {
        foreach ($set as $cube) {
            list($count, $colour) = $cube;
            if ($count > $max[$colour]) {
                $valid = false;
                break 2;
            }
        }
    }
    if ($valid) {
        $total += $line[0];
    }
}
print $total . "\n";

$total = 0;
foreach ($data as $line) {
    $min = ['red' => 0, 'green' => 0, 'blue' => 0];
    foreach ($line[1] as $set) {
        foreach ($set as $cube) {
            list($count, $colour) = $cube;
            $min[$colour] = max($min[$colour], $count);
        }
    }
    $total += array_reduce($min, fn($t, $v) => $t * $v, 1);
}
print $total . "\n";
