<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(18)->lines()->regex('/(\d+),(\d+),(\d+)/');

$min = [PHP_INT_MAX, PHP_INT_MAX, PHP_INT_MAX];
$max = [0, 0, 0];
foreach ($data as $a) {
    $lava[$a[2]][$a[1]][$a[0]] = $a[0];
    for ($i =0; $i < 3; $i++) {
        $min[$i] = min($min[$i], $a[$i]);
        $max[$i] = max($max[$i], $a[$i]);
    }
}

$map = [[1, 0, 0], [-1, 0, 0], [0, 1, 0], [0, -1, 0], [0, 0, 1], [0, 0, -1]];

$total = 0;
foreach ($lava as $z => $slice) {
    foreach ($slice as $y => $row) {
        foreach ($row as $x) {
            $exposed = 6;
            foreach ($map as $offset) {
                if (isset($lava[$z + $offset[0]][$y + $offset[1]][$x + $offset[2]])) {
                    $exposed--;
                }
            }
            $total += $exposed;
        }
    }
}
print "{$total}\n";

function scan($x, $y, $z)
{
    global $lava, $map, $g, $min, $max;
    $q = [];
    if (isset($g[$z][$y][$x])) {
        return [];
    }
    $g[$z][$y][$x] = 0;
    foreach ($map as $offset) {
        $cx = $x + $offset[0];
        $cy = $y + $offset[1];
        $cz = $z + $offset[2];
        if ($cx < -1 || $cx > $max[0] + 2 || $cy < -1 || $cy > $max[1] + 2 || $cz < -1 || $cz > $max[2] + 2) {
            continue;
        } elseif (isset($lava[$cz][$cy][$cx])) {
            $g[$z][$y][$x]++;
            if ($z == 1 && $y == 1 & $x == 2) {
                print_r($offset);
            }
        } else {
            $q[] = [$cx, $cy, $cz];
        }
    }
    return $q;
}

$g = [];
$q = scan(0, 0, 0);
$current = current($q);
while (!is_null($current)) {
    $q = array_merge($q, scan($current[0], $current[1], $current[2]));
    $current = array_shift($q);
}
$total = 0;
foreach ($g as $z => $slice) {
    foreach ($slice as $y => $row) {
        $total += array_sum($row);
    }
}
print "{$total}\n";
