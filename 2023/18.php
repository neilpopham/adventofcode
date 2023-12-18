<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(18);

$data = $input->lines()->regex('/([UDLR])\s+(\d+).+(#[\da-f]+)/');

function find_inners($map, $lines, $min, $max)
{
    $total = 0;
    for ($y = $min; $y <= $max; $y++) {
        $ys = []; $xs = []; $hash = '';
        foreach ($lines as $line) {
            list($x1, $y1) = $line[0];
            list($x2, $y2) = $line[1];
            // Horizontal line on this row
            if (($y1 == $y2) && $y1 == $y) {
                $ys[] = [min($x1, $x2), max($x1, $x2)];
            // Vertical intersecting this row
            } elseif (min($y1, $y2) < $y && max($y1, $y2) >= $y) {
                $xs[] = $x1;
            }
        }
        sort($xs);
        $x1 = 0;
        foreach ($xs as $c => $x2) {
            if ($c % 2) {
                $dx = $x2 - $x1 - 1;
                foreach ($ys as $yxs) {
                    if ($yxs[0] == $x1 && $yxs[1] == $x2) {
                        $dx -= $yxs[1] - $yxs[0] - 1;
                    } elseif ($yxs[0] == $x1 || $yxs[1] == $x2) {
                        $dx -= $yxs[1] - $yxs[0];
                    } elseif ($yxs[0] > $x1 && $yxs[1] < $x2) {
                        $dx -= $yxs[1] - $yxs[0] + 1;
                    }
                }
                $total += $dx;
            }
            $x1 = $x2;
        }
    }
    return $total;
}

function process($data, $map, $get_direction, $get_count)
{
    $total = 0;
    $x = 0;
    $y = 0;
    $min = PHP_INT_MAX;
    $max = 0;

    foreach ($data as $i => $instruction) {
        $direction = $get_direction($instruction);
        $count = $get_count($instruction);

        $lines[$i] = [[$x, $y]];
        $x += $count * $map[$direction][0];
        $y += $count * $map[$direction][1];
        $lines[$i][] = [$x, $y];

        $min = min($min, $y);
        $max = max($max, $y);

        $total += $count;
    }

    return $total + find_inners($map, $lines, $min, $max);
}

print process(
    $data,
    ['U' => [0, -1], 'R' => [1, 0], 'D' => [0, 1], 'L' => [-1, 0]],
    fn($v) => $v[0],
    fn($v) => $v[1]
) . "\n";

print process(
    $data,
    [[1, 0], [0, 1], [-1, 0], [0, -1]],
    fn($v) => (int) substr($v[2], 6),
    fn($v) => hexdec(substr($v[2], 1, 5))
) . "\n";
