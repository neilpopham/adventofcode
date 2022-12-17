<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(15)->lines()
    ->regex('/Sensor at x=([\-\d]+), y=([\-\d]+): closest beacon is at x=([\-\d]+), y=([\-\d]+)/');

$map = [[0, -1], [1, 0], [0, 1], [-1, 0]];
foreach ($data as $s => $pts) {
    $data[$s][4] = abs($pts[2] - $pts[0]) + abs($pts[3] - $pts[1]);
    foreach ($map as $o => $offset) {
        $data[$s][5 + $o] = [$pts[0] + $offset[0] * $data[$s][4], $pts[1] + $offset[1] * $data[$s][4]];
    }
}

function scan($row)
{
    global $data;
    $found = [];
    foreach ($data as $s => $sensor) {
        for ($i = 5; $i < 9; $i++) {
            list($x1, $y1) = $sensor[$i];
            for ($j = 5; $j < 9; $j++) {
                list($x2, $y2) = $sensor[$j];

                $dx = $x2 <=> $x1;
                $dy = $y2 <=> $y1;

                if (($dx == 0 || $dy == 0)
                    || ($y1 < $row && $y2 < $row)
                    || ($y1 > $row && $y2 > $row)) {
                    continue;
                }

                $dr = abs($row - $y1);
                $found[$x1 + ($dr * $dx)] = 1;
            }
        }
    }

    $found = array_keys($found);
    sort($found);
    return [current($found), end($found)];
}

list($min, $max) = scan(2000000);
print ($max - $min) . "\n";
