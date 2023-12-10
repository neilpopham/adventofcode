<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(10);

$data = $input->lines()->raw();

foreach ($data as $y => $line) {
    if (false !== $x = strpos($line, 'S')) {
        $s = [$y, $x];
        $sy = $y;
        $sx = $x;
    }
    $data[$y] = str_split($line);
}

$mx = count($data[0]);
$my = count($data);

$map = [
    '|' => [[0, 1], [0, -1]],
    '-' => [[-1, 0], [1, 0]],
    'L' => [[1, 0], [0, -1]],
    'J' => [[-1, 0], [0, -1]],
    '7' => [[-1, 0], [0, 1]],
    'F' => [[1, 0], [0, 1]],
    '.' => [],
];

function mid($min, $value, $max)
{
    return min($max, max($min, $value));
}

$neighbours = [[0, -1], [1, 0], [0, 1], [-1, 0]];

foreach ($neighbours as $offset) {
    $dx = $offset[0];
    $dy = $offset[1];
    $cy = mid(0, $sy + $dy, $my);
    $cx = mid(0, $sx + $dx, $mx);
    if ($cx == $sx && $cy == $sy) {
        continue;
    }
    $pipe = $data[$cy][$cx];
    foreach ($map[$pipe] as $offset) {
        if ($cx + $offset[0] == $sx && $cy + $offset[1] == $sy) {
            $cells[] = [$pipe, $dx, $dy];
        }
    }
}

$matches = [];
foreach ($cells as $i => $meta) {
    list($pipe, $dx, $dy) = $meta;
    foreach ($map as $type => $connectors) {
        foreach ($connectors as $female) {
            if ($female == [$dx, $dy]) {
                $matches[$i][] = $type;
            }
        }
    }
}

$intersect = array_intersect($matches[0], $matches[1]);
$s = reset($intersect);

$e = 0;
$x = $sx + $map[$s][$e][0];
$y = $sy + $map[$s][$e][1];
$path["{$sy}|{$sx}"] = [$sx, $sy, $e];
while ($x != $sx || $y != $sy) {
    $previous = end($path);
    $index = "{$y}|{$x}";
    $path[$index] = [$x, $y];
    $pipe = $data[$y][$x];
    foreach ($map[$pipe] as $e => $offset) {
        if ($x + $offset[0] == $previous[0] && $y + $offset[1] == $previous[1]) {
            continue;
        }
        $x += $offset[0];
        $y += $offset[1];
        break;
    }
    $path[$index][2] = $e;
}

print (count($path) / 2) . "\n";

$bounds = [
    '|' => [
        [
            [[1, 0]],
            [[-1, 0]]
        ],
        [
            [[-1, 0]],
            [[1, 0]],
        ],
    ],
    '-' => [
        [
            [[0, 1]],
            [[0, -1]],
        ],
        [
            [[0, -1]],
            [[0, 1]],
        ],
    ],
    'L' => [
        [
            [[1, -1]],
            [[-1, 0], [-1, 1], [0, 1]],
        ],
        [
            [[-1, 0], [-1, 1], [0, 1]],
            [[1, -1]],
        ],
    ],
    'J' => [
        [
            [[1, 0], [1, 1], [0, 1]],
            [[-1, -1]],
        ],
        [
            [[-1, -1]],
            [[0, 1], [1, 1], [1, 0]],
        ],
    ],
    '7' => [
        [
            [[-1, 1]],
            [[0, -1], [1, -1], [1, 0]],
        ],
        [
            [[0, -1], [1, -1], [1, 0]],
            [[-1, 1]],
        ],
    ],
    'F' => [
        [
            [[-1, 0], [-1, -1], [0, -1]],
            [[1, 1]],
        ],
        [
            [[1, 1]],
            [[-1, 0], [-1, -1], [0, -1]],
        ],
    ],
];

// Tried both 0 and 1 and can see by eye 0 is external, 1 is internal
$lr = 1;

$inside = [];
foreach ($path as $coords) {
    list($x, $y, $e) = $coords;
    $pipe = $data[$y][$x];
    if ($pipe == 'S') {
        $pipe = $s;
    }
    $cells = $bounds[$pipe][$lr][$e];
    foreach ($cells as $coords) {
        $dx = $x + $coords[0];
        $dy = $y + $coords[1];
        if (!isset($path["{$dy}|{$dx}"])) {
            $inside["{$dy}|{$dx}"] = [$dx, $dy];
        }
    }
}

$searching = true;
while ($searching) {
    $searching = false;
    foreach ($inside as $key => $coords) {
        list($x, $y) = $coords;
        for ($dy = -1; $dy <= 1; $dy++) {
            for ($dx = -1; $dx <= 1; $dx++) {
                $cx = $x + $dx;
                $cy = $y + $dy;
                if (!isset($path["{$cy}|{$cx}"]) && !isset($inside["{$cy}|{$cx}"])) {
                    $inside["{$cy}|{$cx}"] = [$cx, $cy];
                    $searching = true;
                }
            }
        }
    }
}

print count($inside) . "\n";
