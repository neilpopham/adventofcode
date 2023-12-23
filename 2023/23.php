<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(23);

$data = $input->lines()->raw();

$mx = strlen($data[0]);
$my = count($data);

$ex = $mx - 2;
$ey = $my - 1;

function part1($node)
{
    global $data, $queue, $best, $mx, $my, $ex, $ey;

    $valid = ['^', '>', 'v', '<'];

    list($x, $y, $path) = $node;

    if ($x == $ex && $y == $ey) {
        $length = count($path);
        if ($length > $best) {
            $best = $length;
        }
        return;
    }

    $np = $path;
    $np["{$x}|{$y}"] = 1;

    foreach ([[0, -1], [1, 0], [0, 1], [-1, 0]] as $o => $offset) {
        $nx = $x + $offset[0];
        $ny = $y + $offset[1];

        if (isset($np["{$nx}|{$ny}"])) {
            continue;
        }

        if ($nx < 0 || $ny < 0 || $nx >= $mx || $ny >= $my) {
            continue;
        }

        $tile = $data[$ny][$nx];
        if ($tile == '.' || $tile == $valid[$o]) {
            $queue[] = [$nx, $ny, $np];
        }
    }
}

$best = 0;
$queue = [[1, 0, []]];
while (count($queue) > 0) {
    $node = array_pop($queue);
    part1($node);
}
print $best . "\n";
