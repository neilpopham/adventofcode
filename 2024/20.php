<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(20);
$data = $input->lines()->map(fn($row) => str_split($row));

$offsets = [[0, -1], [1, 0], [0, 1], [-1, 0]];

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

$width = count($data[0]);
$height = count($data);
$my = $height - 1;
$mx = $width - 1;

$movable = [];
foreach ($grid as $y => $row) {
    foreach (array_keys($row) as $x) {
        if ($y > 0 && $y < $my && !isset($grid[$y - 1][$x]) && !isset($grid[$y + 1][$x])) {
            $movable[] = [$x, $y, 1];
        } elseif ($x > 0 && $x < $mx && !isset($grid[$y][$x - 1]) && !isset($grid[$y][$x + 1])) {
            $movable[] = [$x, $y, 0];
        }
    }
}

function check($item)
{
    global $grid, $queue, $seen, $offsets, $ex, $ey;
    list($path, $g) = $item;
    list($x, $y, $d) = end($path);

    if ($x == $ex && $y == $ey) {
        $seen[$y][$x] = $g;
        return $g;
    }

    if (isset($seen[$y][$x])) {
        if ($seen[$y][$x] <= $g) {
            return;
        }
    }
    $seen[$y][$x] = $g;

    foreach ($offsets as $o => $offset) {
        if (($o + 2) % 4 == $d) {
            continue;
        }

        $nx = $x + $offset[0];
        $ny = $y + $offset[1];

        if (isset($grid[$ny][$nx])) {
            continue;
        }

        $ng = $g + 1;
        $q = [$path, $ng];
        $q[0][] = [$nx, $ny, $o];
        $queue[] = $q;
    }
}

$seen = [];
$queue = [];
$item = [[[$sx, $sy, 99]], 0];
while (!is_null($item)) {
    if (check($item)) {
        $gs = $seen;
    }
    $item = array_pop($queue);
}

$cheats = 0;
foreach ($movable as $coords) {
    list($x, $y, $o) = $coords;
    if ($o == 0) {
        $g1 = min($gs[$y][$x - 1], $gs[$y][$x + 1]);
        $g2 = max($gs[$y][$x - 1], $gs[$y][$x + 1]);
    } else {
        $g1 = min($gs[$y - 1][$x], $gs[$y + 1][$x]);
        $g2 = max($gs[$y - 1][$x], $gs[$y + 1][$x]);
    }
    $saving = $g2 - ($g1 + 2);
    if ($saving >= 100) {
        $cheats++;
    }
}
print $cheats . "\n";
