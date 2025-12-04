<?php

require 'libs/aoc.php';

$input = new AdventOfCode\AdventOfCode()->input(4)->lines();

$data = array_map(fn($x) => str_split($x), $input->raw());

$grid = new AdventOfCode\Grid($data);

$neighbours = new AdventOfCode\Grid();

function neighbours($grid, $x, $y)
{
    $sides = 0;
    for ($dy = -1; $dy <= 1; $dy++) {
        for ($dx = -1; $dx <= 1; $dx++) {
            if ($dx == 0 && $dy == 0) {
                continue;
            }
            if ($grid->cell($x + $dx, $y + $dy, '.') == '@') {
                $sides++;
            }
            if ($sides > 3) {
                break 2;
            }
        }
    }
    return $sides;
}

$total = 0;
for ($y = 0; $y < $grid->height; $y++) {
    for ($x = 0; $x < $grid->width; $x++) {
        if ($grid->cell($x, $y) == '@') {
            $sides = neighbours($grid, $x, $y);
            if ($sides < 4) {
                $total++;
            }
            $neighbours->set($x, $y, $sides);
        }
    }
}
print $total . "\n";

$previous = 1;
$total = 0;
while ($total != $previous) {
    $previous = $total;
    for ($y = 0; $y < $grid->height; $y++) {
        for ($x = 0; $x < $grid->width; $x++) {
            if ($neighbours->cell($x, $y, 9) < 4) {
                $neighbours->set($x, $y, 9);
                $grid->set($x, $y, 'X');
                $total++;
                for ($dy = -1; $dy <= 1; $dy++) {
                    for ($dx = -1; $dx <= 1; $dx++) {
                        $cx = $x + $dx;
                        $cy = $y + $dy;
                        if ($grid->cell($cx, $cy, '.') == '@') {
                            $neighbours->set($cx, $cy, neighbours($grid, $cx, $cy));
                        }
                    }
                }
            }
        }
    }
}
print $total . "\n";
