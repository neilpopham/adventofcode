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
    global $grid, $g, $offsets, $ex, $ey, $queue, $best;
    $path = $item[0];
    list($x, $y, $d) = end($path);
    $h = $item[1];

    if ($h > $best) {
        return;
    }

    if ($x == $ex && $y == $ey) {
        return $h;
    }

    if ($part1) {
        if (isset($g[$y][$x])) {
            if ($g[$y][$x] < $h) {
                return;
            }
        }
        $g[$y][$x] = $h;
    } else {
        if (isset($g[$y][$x][$d])) {
            if ($g[$y][$x][$d] < $h) {
                return;
            }
        }
        $g[$y][$x][$d] = $h;
    }

    foreach ($offsets as $o => $offset) {
        if (($o + 2) % 4 == $d) {
            continue;
        }

        $nx = $x + $offset[0];
        $ny = $y + $offset[1];

        if (isset($grid[$ny][$nx])) {
            continue;
        }

        $q = [$path, $h + ($o == $d ? 1 : 1001)];
        $q[0][] = [$nx, $ny, $o];
        $queue[] = $q;
    }
}

$g = [];
$queue = [[[[$sx, $sy, 1]], 0]];
$best = PHP_INT_MAX;
$scores = [];
$item = array_pop($queue);
while (!is_null($item)) {
    if (null !== $result = check($item)) {
        $scores[] = $result;
        sort($scores);
        $best = reset($scores);
    }
    usort($queue, fn($a, $b) => $b[1] <=> $a[1]);
    $item = array_pop($queue);
}
print $best . "\n";

$g = [];
$queue = [[[[$sx, $sy, 1]], 0]];
$successes = [];
$item = array_pop($queue);
while (!is_null($item)) {
    if (null !== $result = check($item, false)) {
        $successes[] = $item[0];
    }
    usort($queue, fn($a, $b) => $b[1] <=> $a[1]);
    $item = array_pop($queue);
}

$unique = [];
foreach ($successes as $success) {
    foreach ($success as $path) {
        $unique["{$path[0]}|{$path[1]}"] = 1;
    }
}
print count($unique) . "\n";
