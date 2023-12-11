<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(11);

$data = $input->lines()->raw();

$columns = array_fill(0, strlen($data[0]), '');
foreach ($data as $y => $row) {
    if (empty(str_replace('.', '', $row))) {
        $empty_rows[] = $y;
    }
    for ($x = 0; $x < strlen($row); $x++) {
        $columns[$x] .= $row[$x];
    }
}

foreach ($columns as $x => $value) {
    if (empty(str_replace('.', '', $value))) {
        $empty_columns[] = $x;
    }
}

function part1($data, $empty_rows, $empty_columns)
{
    foreach ($empty_columns as $i => $x) {
        $x += $i;
        foreach ($data as $y => $row) {
            $data[$y] = substr($row, 0, $x) . '.' . substr($row, $x);
        }
    }

    foreach ($empty_rows as $i => $y) {
        $y += $i;
        array_splice($data, $y, 0, $data[$y]);
    }

    foreach ($data as $y => $row) {
        for ($x = 0; $x < strlen($row); $x++) {
            if ($row[$x] == '#') {
                $galaxies[] = [$x, $y];
            }
        }
    }

    foreach ($galaxies as $g1 => $co1) {
        foreach ($galaxies as $g2 => $co2) {
            if ($g1 == $g2) {
                continue;
            }
            $min = min($g1, $g2);
            $max = max($g1, $g2);
            $distances["{$min}|{$max}"] = abs($co1[0] - $co2[0]) + abs($co1[1] - $co2[1]);
        }
    }

    print array_sum($distances) . "\n";
}

part1($data, $empty_rows, $empty_columns);

foreach ($data as $y => $row) {
    for ($x = 0; $x < strlen($row); $x++) {
        if ($row[$x] == '#') {
            $galaxies[] = [$x, $y];
        }
    }
}

$expander = 1000000;

foreach ($galaxies as $g1 => $co1) {
    foreach ($galaxies as $g2 => $co2) {
        if ($g1 == $g2) {
            continue;
        }

        $min = min($g1, $g2);
        $max = max($g1, $g2);

        if (isset($distances["{$min}|{$max}"])) {
            continue;
        }

        $dx = abs($co1[0] - $co2[0]);
        $dy = abs($co1[1] - $co2[1]);

        $sx = min($co1[0], $co2[0]);
        $ex = max($co1[0], $co2[0]);
        $sy = min($co1[1], $co2[1]);
        $ey = max($co1[1], $co2[1]);

        foreach ($empty_columns as $x) {
            if ($x > $sx && $x < $ex) {
                $dx += ($expander - 1);
            }
        }

        foreach ($empty_rows as $y) {
            if ($y > $sy && $y < $ey) {
                $dy += ($expander - 1);
            }
        }

        $distances["{$min}|{$max}"] = $dx + $dy;
    }
}

print array_sum($distances) . "\n";
