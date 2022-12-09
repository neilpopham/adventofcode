<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(3)->lines();

$wires = [];
foreach ($data as $i => $line) {
    $wires[$i] = explode(',', $line);
}

$map = ['U' => [0, 1], 'D' => [0, -1], 'L' => [-1, 0], 'R' => [1, 0]];

$pos = [[[0, 0, 0, 0, 0]], [[0, 0, 0, 0, 0]]];

foreach ($wires as $w => $wire) {
    $p = 0;
    foreach ($wire as $i => $move) {
        if (preg_match('/^([UDLR])(\d+)$/', $move, $matches)) {
            list(, $dir, $num) = $matches;
            $x = $pos[$w][$p][0] + $map[$dir][0] * $num;
            $y = $pos[$w][$p][1] + $map[$dir][1] * $num;
            $pos[$w][] = [$x, $y, $map[$dir][0], $map[$dir][1]];
            $p++;
        }
    }
}

$intersects = [];
for ($p0 = 1; $p0 < count($pos[0]); $p0++) {

    $h0 = $pos[0][$p0][3] == 0 ? 1 : 0;
    $s0 = [min($pos[0][$p0 - 1][0], $pos[0][$p0][0]), min($pos[0][$p0 - 1][1], $pos[0][$p0][1])];
    $e0 = [max($pos[0][$p0 - 1][0], $pos[0][$p0][0]), max($pos[0][$p0 - 1][1], $pos[0][$p0][1])];

    $pos[0][$p0][4] = $pos[0][$p0 - 1][4] + abs($pos[0][$p0][0] - $pos[0][$p0 - 1][0]) + abs($pos[0][$p0][1] - $pos[0][$p0 - 1][1]);

    for ($p1 = 1; $p1 < count($pos[1]); $p1++) {

        $pos[1][$p1][4] = $pos[1][$p1 - 1][4] + abs($pos[1][$p1][0] - $pos[1][$p1 - 1][0]) + abs($pos[1][$p1][1] - $pos[1][$p1 - 1][1]);

        if ($p0 == 1 && $p1 == 1) {
            continue;
        }

        $h1 = $pos[1][$p1][3] == 0 ? 1 : 0;
        if ($h1 == $h0) {
            continue;
        }

        $s1 = [min($pos[1][$p1 - 1][0], $pos[1][$p1][0]), min($pos[1][$p1 - 1][1], $pos[1][$p1][1])];
        $e1 = [max($pos[1][$p1 - 1][0], $pos[1][$p1][0]), max($pos[1][$p1 - 1][1], $pos[1][$p1][1])];

        if ($h0) {
            if (($s1[0] < $s0[0]) || ($s1[0] > $e0[0])) {
                continue;
            }
            if (($s1[1] > $s0[1]) || ($e1[1] < $s0[1])) {
                continue;
            }

            $d0 = $pos[0][$p0 - 1][4] + abs($pos[0][$p0 - 1][0] - $pos[1][$p1][0]);
            $d1 = $pos[1][$p1 - 1][4] + abs($pos[1][$p1 - 1][1] - $pos[0][$p0][1]);

            $intersects[] = [$s1[0], $s0[1], abs($s1[0]) + abs($s0[1]), $d0 + $d1, $d0, $d1];
        } else {
            if (($s1[0] > $s0[0]) || ($e1[0] < $s0[0])) {
                continue;
            }
            if ((($s1[1] > $e0[1]) || ($s1[1] < $s0[1]))) {
                continue;
            }    
        
            $d0 = $pos[0][$p0 - 1][4] + abs($pos[0][$p0 - 1][1] - $pos[1][$p1][1]);
            $d1 = $pos[1][$p1 - 1][4] + abs($pos[1][$p1 - 1][0] - $pos[0][$p0][0]);

            $intersects[] = [$s0[0], $s1[1], abs($s0[0]) + abs($s1[1]), $d0 + $d1, $d0, $d1];
        }
    }
}

usort($intersects, fn($a, $b) =>  $a[2] <=> $b[2]);

print $intersects[0][2] . "\n";

usort($intersects, fn($a, $b) =>  $a[3] <=> $b[3]);

print $intersects[0][3] . "\n";