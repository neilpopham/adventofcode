<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(16);
$data = $input->lines()->map(fn($row) => str_split($row));

$grid = [];
foreach ($data as $y => $row) {
    foreach ($row as $x => $value) {
        if ($value == 'S') {
            $sx = $x;
            $sy = $y;
        } elseif ($value == 'E') {
            $ex = $x;
            $ey = $y;
        } elseif ($value == '#') {
            $grid[$y][$x] = 1;
        }
    }
}

$offsets = [[0, -1], [1, 0], [0, 1], [-1, 0]];

function check($item, $part1 = true)
{
    global $grid, $seen, $offsets, $ex, $ey, $queue, $best;
    list($path, $g) = $item;
    list($x, $y, $d) = end($path);

    if ($best < $g) {
        return;
    }

    if ($x == $ex && $y == $ey) {
        return $g;
    }

    if (isset($seen[$y][$x][$d])) {
        if ($seen[$y][$x][$d] < $g) {
            return;
        }
        if ($part1 && ($seen[$y][$x][$d] == $g)) {
            return;
        }
    }
    $seen[$y][$x][$d] = $g;

    foreach ($offsets as $o => $offset) {
        if (($o + 2) % 4 == $d) {
            continue;
        }

        $nx = $x + $offset[0];
        $ny = $y + $offset[1];

        if (isset($grid[$ny][$nx])) {
            continue;
        }

        $ng = $g + ($o == $d ? 1 : 1001);
        $q = [$path, $ng];
        $q[0][] = [$nx, $ny, $o];
        $queue[] = $q;
    }
}

$best = PHP_INT_MAX;
$seen = [];
$queue = [];
$scores = [];
$successes = [];
$item = [[[$sx, $sy, 1]], 0];
while (!is_null($item)) {
    if (null !== $result = check($item)) {
        $scores[] = $item[1];
    }
    usort($queue, fn($a, $b) => $b[1] <=> $a[1]);
    $item = array_pop($queue);
}
sort($scores);
$best = reset($scores);
print $best . "\n";

$seen = [];
$queue = [];
$unique = [];
$item = [[[$sx, $sy, 1]], 0];
while (!is_null($item)) {
    if (null !== $result = check($item, false)) {
        foreach ($item[0] as $move) {
            $unique["{$move[0]}|{$move[1]}"] = 1;
        }
    }
    usort($queue, fn($a, $b) => $b[1] <=> $a[1]);
    $item = array_pop($queue);
}
print count($unique) . "\n";
