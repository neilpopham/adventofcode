<?php

require 'libs/aoc.php';

$input = new AdventOfCode\AdventOfCode()->input(8)->lines();

$data = $input->regex('/(\d+),(\d+),(\d+)/');

define(CONNECTIONS, 1000);

function euclidean($p, $q)
{
    return sqrt(pow($p[0] - $q[0], 2) + pow($p[1] - $q[1], 2) + pow($p[2] - $q[2], 2));
}

$boxes = [];
$distances = [];

foreach ($data as $p1 => $point1) {
    $data[$p1][3] = PHP_INT_MAX;
    foreach ($data as $p2 => $point2) {
        if ($p1 == $p2) {
            continue;
        }
        $k1 = min($p1, $p2);
        $k2 = max($p1, $p2);
        $key = "{$k1}|{$k2}";
        if (isset($distances[$key])) {
            continue;
        }
        $distances[$key] = [euclidean($point1, $point2), $p1, $p2];
    }
}

usort($distances, fn($a, $b) => $a[0] <=> $b[0]);

function junction($distance, $p1, $p2)
{
    global $data, $boxes;

    $b1 = $data[$p1][3];
    $b2 = $data[$p2][3];
    $id = count($boxes);

    if ($b1 === PHP_INT_MAX) {
        if ($b2 === PHP_INT_MAX) {
            $boxes[$id] = [$p1, $p2];
            $data[$p1][3] = $id;
            $data[$p2][3] = $id;
        } else {
            $boxes[$b2][] = $p1;
            $data[$p1][3] = $b2;
        }
    } elseif ($b1 != $b2) {
        if ($b2 === PHP_INT_MAX) {
            $boxes[$b1][] = $p2;
            $data[$p2][3] = $b1;
        } else {
            foreach ($boxes[$b2] as $p) {
                $data[$p][3] = $b1;
            }
            $boxes[$b1] = array_merge($boxes[$b1], $boxes[$b2]);
            $boxes[$b2] = [];
        }
    }
}

$i = 0;
while ($i < CONNECTIONS) {
    junction(...$distances[$i]);
    $i++;
}
$counts = array_map(fn($x) => count($x), $boxes);
rsort($counts);
print array_product(array_slice($counts, 0, 3)) . "\n";

while (true) {
    junction(...$distances[$i]);
    foreach ($boxes as $box) {
        if (count($box) == count($data)) {
            break 2;
        }
    }
    $i++;
};

print ($data[$distances[$i][1]][0] * $data[$distances[$i][2]][0]) . "\n";
