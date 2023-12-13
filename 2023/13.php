<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(13);

$data = $input->lines(false)->raw();

$g = 0;
$grids = [];
foreach ($data as $line) {
    if (empty($line)) {
        $g++;
        continue;
    }
    $grids[$g][] = $line;
}
unset($data);

function get_axis($grid, $ignore = null)
{
    $axis = array_fill(1, strlen($grid[0]) - 1, true);
    if (!is_null($ignore)) {
        $axis[$ignore] = false;
    }
    foreach ($grid as $y => $line) {
        $length = strlen($line);
        for ($x = 1; $x < $length; $x++) {
            if (false === $axis[$x]) {
                continue;
            }
            $min = min($x, $length - $x);
            $p1 = substr(substr($line, 0, $x), -$min);
            $p2 = substr(substr($line, $x), 0, $min);
            if ($p1 != strrev($p2)) {
                $axis[$x] = false;
            }
        }
    }
    $keys = array_keys(array_filter($axis));
    return empty($keys) ? 0 : reset($keys);
}

$total = 0;
foreach ($grids as $g => $grid) {
    $vertical[$g] = get_axis($grid);
    $length = strlen($grid[0]);
    $columns = array_fill(0, $length, '');
    for ($x = 0; $x < $length; $x++) {
        foreach (array_keys($grid) as $y) {
            $columns[$x] .= $grid[$y][$x];
        }
    }
    $horizontal[$g] = get_axis($columns);
    $total += $vertical[$g];
    $total += (100 * $horizontal[$g]);
}
print $total . "\n";

function find_reflection($grid, $g)
{
    global $vertical, $horizontal;
    $length = strlen($grid[0]);
    for ($y = 0; $y < count($grid); $y++) {
        for ($x = 0; $x < $length; $x++) {
            $current = $grid;
            $current[$y][$x] = $current[$y][$x] == '.' ? '#' : '.';
            $ver = get_axis($current, $vertical[$g]);
            $columns = array_fill(0, $length, '');
            for ($cx = 0; $cx < $length; $cx++) {
                foreach (array_keys($current) as $cy) {
                    $columns[$cx] .= $current[$cy][$cx];
                }
            }
            $hor = get_axis($columns, $horizontal[$g]);
            if ($ver || $hor) {
                return [$ver, $hor];
            }
        }
    }
    return [0, 0];
}

$total = 0;
foreach ($grids as $g => $grid) {
    $axis = find_reflection($grid, $g);
    $total += $axis[0];
    $total += (100 * $axis[1]);
}
print $total . "\n";
