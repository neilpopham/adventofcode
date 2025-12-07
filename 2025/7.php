<?php
require 'libs/aoc.php';

$input = new AdventOfCode\AdventOfCode()->input(7);

$grid = $input->grid();

$sx = array_search('S', $grid->row(0));

$y = 0;
$x = $sx;
$tachyons["{$x}|{$y}"] = [$x, $y, true];
$splits = new AdventOfCode\Set();
do {
    $changed = false;
    foreach ($tachyons as $key => [$x, $y, $active]) {
        if (false === $active) {
            continue;
        }
        $changed = true;
        $south = $grid->cell($x, $y + 1, 'x');
        $ny = $y + 1;
        if ($south == 'x') {
            $tachyons[$key][2] = false;
        } elseif ($south == '^') {
            $splits->add("{$x}|{$ny}");
            $tachyons[$key][2] = false;
            $nx = $x - 1;
            $tachyons["{$nx}|{$ny}"] = [$nx, $ny, true];
            $nx = $x + 1;
            $tachyons["{$nx}|{$ny}"] = [$nx, $ny, true];
        } else {
            $tachyons[$key][1] = $ny;
        }
    }
} while ($changed);
print $splits->size() . "\n";

function countbeams($x, $y)
{
    global $grid, $beams;
    $sx = $x; $sy = $y;
    if (isset($beams["{$x}|{$y}"])) {
        return $beams["{$x}|{$y}"];
    }
    do {
        $y++;
        $cell = $grid->cell($x, $y, 'x');
        if ($cell == 'x') {
            $beams["{$sx}|{$sy}"] = 1;
            return 1;
        } elseif ($cell == '^') {
            $beams["{$sx}|{$sy}"] = countbeams($x - 1, $y) + countbeams($x + 1, $y);
            return $beams["{$sx}|{$sy}"];
        }
    } while (true);
}

$y = 0;
$x = $sx;
$beams = [];
print countbeams($x, $y) . "\n";
