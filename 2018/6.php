<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(6);

$data = $input->lines()->regex('/(\d+), (\d+)/');

$max = [];
foreach ($data as $coords) {
    foreach ($coords as $i => $value) {
        $max[$i] = max($max[$i] ?? 0, $value);
    }
}

$owners = [];
for ($y = 0; $y <= $max[1]; $y++) {
    $owners[$y] = [];
    for ($x = 0; $x <= $max[0]; $x++) {
        $min = PHP_INT_MAX;
        $oid = null;
        foreach ($data as $id => $coords) {
            $d = abs($coords[0] - $x) + abs($coords[1] - $y);
            if ($d < $min) {
                $min = $d;
                $oid = $id;
            } elseif ($d == $min) {
                $oid = null;
            }
        }
        $owners[$y][$x] = $oid;
    }
}

$invalid = [];
$totals = array_fill(0, count($data), 0);
foreach ($owners as $y => $row) {
    foreach ($row as $x => $oid) {
        if (is_null($oid)) {
            continue;
        }
        if ($y == 0 || $x == 0 || $x == $max[0] || $y == $max[1]) {
            $invalid[$oid] = 1;
            $totals[$oid] = 0;
            continue;
        }
        if (isset($invalid[$oid])) {
            continue;
        }
        $totals[$oid]++;
    }
}

rsort($totals);

print reset($totals) . "\n";

$limit = 10000;
$points = 0;
for ($y = 0; $y <= $max[1]; $y++) {
    for ($x = 0; $x <= $max[0]; $x++) {
        $total = array_reduce(
            $data,
            fn($value, $coords) => $value + abs($coords[0] - $x) + abs($coords[1] - $y),
            0
        );
        if ($total < $limit) {
            $points++;
        }
    }
}

print $points . "\n";
