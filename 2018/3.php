<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(3);

$data = $input->lines()->regex('/#(\d+) @ (\d+),(\d+): (\d+)x(\d+)/');

$cloth = [];
foreach ($data as $claim) {
    for ($dx = 0; $dx < $claim[3]; $dx++) {
        for ($dy = 0; $dy < $claim[4]; $dy++) {
            if (!isset($cloth[$claim[1] + $dx])) {
                $cloth[$claim[1] + $dx] = [];
            }
            if (!isset($cloth[$claim[1] + $dx][$claim[2] + $dy])) {
                $cloth[$claim[1] + $dx][$claim[2] + $dy] = 0;
            }
            $cloth[$claim[1] + $dx][$claim[2] + $dy]++;
        }
    }
}

$total = 0;
foreach ($cloth as $x => $column) {
    foreach ($column as $y => $value) {
        if ($cloth[$x][$y] > 1) {
            $total++;
        }
    }
}
print $total . "\n";

foreach ($data as $claim) {
    $valid = true;
    for ($dx = 0; $dx < $claim[3]; $dx++) {
        for ($dy = 0; $dy < $claim[4]; $dy++) {
            if ($cloth[$claim[1] + $dx][$claim[2] + $dy] > 1) {
                $valid = false;
                break 2;
            }
        }
    }
    if ($valid) {
        print $claim[0] . "\n";
        exit;
    }
}
