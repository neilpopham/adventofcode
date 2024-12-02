<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(2);
$data = $input->lines()->raw();

$reports = array_map(fn($report) => explode(' ', $report), $data);

function check_levels($levels)
{
    $sgn = $levels[1] <=> $levels[0];
    $count = count($levels);
    for ($i = 1; $i < $count; $i++) {
        $d = $levels[$i] - $levels[$i - 1];
        $ad = abs($d);
        if ($ad < 1 || $ad > 3) {
            return false;
        }
        if (($levels[$i] <=> $levels[$i - 1]) !== $sgn) {
            return false;
        }
    }
    return true;
}

$total = 0;
foreach ($reports as $levels) {
    if (check_levels($levels)) {
        $total++;
    }
}
print $total . "\n";

$total = 0;
foreach ($reports as $levels) {
    if (check_levels($levels)) {
        $total++;
        continue;
    }
    for ($i = 0; $i < count($levels); $i++) {
        $partial = $levels;
        array_splice($partial, $i, 1);
        if (check_levels($partial)) {
            $total++;
            continue 2;
        }
    }
}
print $total . "\n";
