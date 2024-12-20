<?php

require 'libs/api.php';
require 'libs/console.php';

$input = (new AdventOfCode())->input(18);
$data = $input->lines()->raw();

$width = 71;
$height = 71;
$bytes = 1024;

$grid = [];
for ($i = 0; $i < $bytes; $i++) {
    list($x, $y) = explode(',', $data[$i]);
    $grid[$y][$x] = 1;
}

$offsets = [[0, -1], [1, 0], [0, 1], [-1, 0]];

function heuristic($x, $y, $g)
{
    global $width, $height;
    $m = $width + $height;
    $d = abs($width - $x) + abs($height - $y);
    return $g - ($m / $d);
}

function check($item)
{
    global $offsets, $grid, $width, $height, $queue, $seen;
    list($path, $g, $h) = $item;
    list($x, $y, $d) = end($path);

    if ($x == ($width - 1) && $y == ($height - 1)) {
        return true;
    }

    if (isset($seen[$y][$x])) {
        if ($seen[$y][$x] <= $h) {
            return;
        }
    }

    $seen[$y][$x] = $h;
    $ng = $g + 1;

    foreach ($offsets as $o => $offset) {
        if (($o + 2) % 4 == $d) {
            continue;
        }

        $nx = $x + $offset[0];
        $ny = $y + $offset[1];

        if ($nx < 0 || $nx >= $width) {
            continue;
        }
        if ($ny < 0 || $ny >= $height) {
            continue;
        }
        if (isset($grid[$ny][$nx])) {
            continue;
        }

        $q = [$path, $ng, heuristic($nx, $ny, $ng)];
        $q[0][] = [$nx, $ny, $o];
        $queue[] = $q;
    }
}

$queue = [];
$item = [[[0, 0, -1]], 0, heuristic(0, 0, 0)];
while (!is_null($item)) {
    if (check($item)) {
        print $item[1] . "\n";
        break;
    }
    usort($queue, fn($a, $b) => $b[1] <=> $a[1]);
    $item = array_pop($queue);
}

$i = $bytes;
do {
    $found = false;
    list($x, $y) = explode(',', $data[$i]);
    $grid[$y][$x] = 1;
    $seen = [];
    $queue = [];
    $item = [[[0, 0, -1]], 0, heuristic(0, 0, 0)];
    while (!is_null($item)) {
        if (check($item)) {
            $found = true;
            $i++;
            break;
        }
        usort($queue, fn($a, $b) => $b[1] <=> $a[1]);
        $item = array_pop($queue);
    }
} while ($found);
print $data[$i];
