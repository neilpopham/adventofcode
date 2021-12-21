<?php

require('libs/core.php');

$data = load_data("_21.txt");

$position = [];
foreach ($data as $value) {
    if (preg_match('/^Player ([1|2]) starting position: (\d+)$/', $value, $matches)) {
        $position[$matches[1] - 1] = $matches[2];
    }
}

function part1($position) {
    $dice = 1;
    $roll = 0;
    $player = 0;
    $score = [0, 0];
    $max = 1000;
    do {
        $move = 0;
        for ($r = 1; $r <= 3; $r++) {
            $move += $dice++;
            if ($dice > 100) {
                $dice = 1;
            }
        }
        $roll++;
        $move = $move % 10;
        $position[$player] += $move;
        if ($position[$player] > 10) {
            $position[$player] = $position[$player] % 10;
        }
        $score[$player] += $position[$player];
        $player = $player ^ 1;
    } while ($score[0] < $max && $score[1] < $max);
    return min($score) * $roll * 3;
}

print part1($position);
print "\n";
