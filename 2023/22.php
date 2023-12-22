<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(22);

$data = $input->lines()->regex('/(.+)~(.+)/');

foreach ($data as $key => $coords) {
    foreach ($coords as $c => $values) {
        $data[$key][$c] = explode(',', $values);
    }
}

usort(
    $data,
    function ($a, $b) {
        $ma = min($a[0][2], $a[1][2]);
        $mb = min($b[0][2], $b[1][2]);
        return $ma <=> $mb;
    }
);

$resting = [];
foreach ($data as $b => $brick) {
    $mz = min($brick[0][2], $brick[1][2]);
    $z = $mz;
    do {
        $z--;
        if ($z == 0) {
            $vacant = false;
            break;
        }
        $vacant = true;
        foreach ($data as $s => $sibling) {
            if ($s == $b) {
                continue;
            }
            if ($sibling[0][2] > $z || $sibling[1][2] < $z) {
                continue;
            }
            if (
                $sibling[1][0] < $brick[0][0]
                || $sibling[0][0] > $brick[1][0]
                || $sibling[1][1] < $brick[0][1]
                || $sibling[0][1] > $brick[1][1]
            ) {
                continue;
            }
            $resting[$b][$s] = $s;
            $vacant = false;
        }
    } while ($vacant);
    $dz = $mz - $z - 1;
    $data[$b][0][2] -= $dz;
    $data[$b][1][2] -= $dz;
}

$required = [];
foreach ($resting as $b => $supports) {
    if (count($supports) == 1) {
        $brick = reset($supports);
        $required[$brick] = 1;
    }
}

$removable = array_diff(array_keys($data), array_keys($required));

print count($removable) . "\n";

$total = 0;
foreach (array_keys($required) as $brick) {
    $queue = [$brick];
    $bricks = $resting;
    while (count($queue)) {
        $brick = array_pop($queue);
        foreach ($bricks as $b => $supports) {
            if (isset($supports[$brick])) {
                unset($bricks[$b][$brick]);
            }
            if (empty($bricks[$b])) {
                $queue[] = $b;
                unset($bricks[$b]);
                $total++;
            }
        }
    }
}

print $total . "\n";
