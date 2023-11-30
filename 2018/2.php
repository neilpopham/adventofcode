<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(2);

$data = $input->lines()->raw();

$total = array_fill(0, 20, 0);

foreach ($data as $value) {
    $chars = count_chars($value, 1);
    $counts = array_unique(array_values($chars));
    foreach ($counts as $count) {
        $total[$count]++;
    }
}

print ($total[2] * $total[3]) . "\n";

foreach ($data as $i => $value1) {
    foreach ($data as $j => $value2) {
        if ($i == $j) {
            continue;
        }
        $misses = 0;
        $match = '';
        for ($i = 0; $i < strlen($value1); $i++) {
            if ($value1[$i] == $value2[$i]) {
                $match .= $value1[$i];
            } else {
                $misses++;
                if ($misses > 1) {
                    break;
                }
            }
        }
        if ($misses == 1) {
            print $match . "\n";
            exit;
        }
    }
}
