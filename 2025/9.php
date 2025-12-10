<?php

require 'libs/aoc.php';

$input = new AdventOfCode\AdventOfCode()->input(9)->lines();

$data = $input->regex('/(\d+),(\d+)/');

$maxx = 0;
$areas = [];
foreach ($data as $p1 => [$x1, $y1]) {
    $maxx = max($maxx, $x1);
    foreach ($data as $p2 => [$x2, $y2]) {
        if ($x1 == $x2 && $y1 == $y2) {
            continue;
        }
        $k1 = min($p1, $p2);
        $k2 = max($p1, $p2);
        $key = "{$k1}|{$k2}";
        if (isset($areas[$key])) {
            continue;
        }
        $width = (abs($x1 - $x2) + 1);
        $height = (abs($y1 - $y2) + 1);
        $areas[$key] = [$width * $height, $p1, $p2];
    }
}
rsort($areas);
$area = reset($areas);
print $area[0] . "\n";

$grid = new AdventOfCode\Grid();
foreach ($data as [$x, $y]) {
    $grid->set($x, $y, '#');
}

$last = count($data) - 1;
foreach ($data as $i => [$x, $y]) {
    $neighbour = $i == 0 ? $data[$last] : $data[$i - 1];
    if ($neighbour[0] == $x) {
        $s = min($y, $neighbour[1]);
        $e = max($y, $neighbour[1]);
        for ($c = $s; $c <= $e; $c++) {
            $grid->set($x, $c, $grid->cell($x, $c, 'x'));
        }
    } else {
        $s = min($x, $neighbour[0]);
        $e = max($x, $neighbour[0]);
        for ($c = $s; $c <= $e; $c++) {
            $grid->set($c, $y, $grid->cell($c, $y, 'x'));
        }
    }
}

do {
    $found = true;
    [$area, $p1, $p2] = array_shift($areas);

    $x1 = min($data[$p1][0], $data[$p2][0]);
    $x2 = max($data[$p1][0], $data[$p2][0]);
    $y1 = min($data[$p1][1], $data[$p2][1]);
    $y2 = max($data[$p1][1], $data[$p2][1]);

    foreach ($grid->cells as $y => $row) {
        foreach ($row as $x => $char) {
            if ($x == $data[$p1][0] && $y == $data[$p1][1]) {
                continue;
            }
            if ($x == $data[$p2][0] && $y == $data[$p2][1]) {
                continue;
            }
            if ($x > $x1 && $x < $x2 && $y > $y1 && $y < $y2) {
                $found = false;
                break 2;
            }
        }
    }
} while (false === $found);
print $area . "\n";
