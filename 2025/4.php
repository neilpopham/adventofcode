<?php

require 'libs/aoc.php';

$input = new AdventOfCode\AdventOfCode()->input(4)->lines();

$data = array_map(fn($x) => str_split($x), $input->raw());

$grid = new AdventOfCode\Grid($data);

$total = 0;
for ($y = 0; $y < $grid->height; $y++) {
    for ($x = 0; $x < $grid->width; $x++) {
        if ($grid->cell($x, $y) == '@') {
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
            if ($sides < 4) {
                $total++;
            }
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
            if ($grid->cell($x, $y) == '@') {
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
                if ($sides < 4) {
                    $total++;
                    $grid->set($x, $y, 'X');
                }
            }
        }
    }
}
print $total . "\n";
