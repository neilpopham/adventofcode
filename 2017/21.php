<?php

require 'libs/aoc.php';

$data = new AdventOfCode\AdventOfCode()->input(day: 21)->lines()->regex('/(.+) => (.+)/');

$data = array_map(
    function ($row) {
        return array_map(
            fn($r) => str_replace('/', '', $r),
            $row
        );
    },
    $data
);

$rota = [
    2 => [1, 3, 0, 2],
    3 => [2, 5, 8, 1, 4, 7, 0, 3, 6],
];

$mira = [
    2 => [1, 0, 3, 2],
    3 => [2, 1, 0, 5, 4, 3, 8, 7, 6],
];

foreach ($data as $i => $rule) {
    $len = strlen($rule[0]);
    $m = sqrt($len);
    $rotations = [$rule[0]];
    for ($r = 1; $r < 4; $r++) {
        $rotations[$r] = "";
        for ($c = 0; $c < $len; $c++) {
            $rotations[$r][$c] = $rotations[$r - 1][$rota[$m][$c]];
        }
    }
    foreach ($rotations as $r => $value) {
        $flip = "";
        for ($c = 0; $c < $len; $c++) {
            $flip[$c] = $value[$mira[$m][$c]];
        }
        $rotations[] = $flip;
    }
    $data[$i][0] = array_unique($rotations);
}

$grid = [
    '.#.',
    '..#',
    '###',
];

function split($grid, $len)
{
    $new = array_chunk($grid, $len);
    foreach ($new as $y => $chunk) {
        $g = [];
        foreach ($chunk as $i => $row) {
            $row = str_split($row, $len);
            foreach ($row as $x => $chars) {
                $g[$x][$i] = $chars;
            }
        }
        $new[$y] = $g;
    }
    return $new;
}

function iterate($grid, $count)
{
    global $data;
    for ($turn = 0; $turn < $count; $turn++) {
        $len = count($grid);

        if ($len % 2 == 0) {
            $split = split($grid, 2);
            $size = 3;
        } elseif ($len % 3 == 0) {
            $split = split($grid, 3);
            $size = 4;
        }

        foreach ($split as $y => $rows) {
            foreach ($rows as $x => $columns) {
                $chunk = implode('', $columns);
                foreach ($data as $rule) {
                    foreach ($rule[0] as $pattern) {
                        if ($pattern == $chunk) {
                            $split[$y][$x] = str_split($rule[1], $size);
                            break 2;
                        }
                    }
                }
            }
        }

        $grid = [];
        foreach ($split as $y => $rows) {
            $row = "";
            foreach ($rows as $x => $columns) {
                foreach ($columns as $i => $chars) {
                    if (!isset($grid[$y * $size + $i])) {
                        $grid[$y * $size + $i] = "";
                    }
                    $grid[$y * $size + $i] .= $chars;
                }
            }
        }
    }

    return array_reduce(
        $grid,
        function ($total, $row) {
            $row = str_replace('.', '', $row);
            return $total + strlen($row);
        }
    );
}

print iterate($grid, 5) . "\n";
print iterate($grid, 18) . "\n";
