<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(23)->lines()->raw();

$map = [];
$elves = [];
$e = 0;

foreach ($data as $y => $row) {
    for ($x = 0; $x < strlen($row); $x++) {
        if ($row[$x] == '#') {
            $map[$y][$x] = $e;
            $elves[$e] = [$x, $y];
            $e++;
        }
    }
}

$dir = [
    ['N' => [0, -1], 'NE' => [1, -1], 'NW' => [-1, -1]],
    ['S' => [0, 1], 'SE' => [1, 1], 'SW' => [-1, 1]],
    ['W' => [-1, 0], 'NW' => [-1, -1], 'SW' => [-1, 1]],
    ['E' => [1, 0], 'NE' => [1, -1], 'SE' => [1, 1]],
];

function check_dir($map, $dir, $elf)
{
    list($x, $y) = $elf;
    $or = [];
    foreach ($dir as $set) {
        $okay = true;
        foreach ($set as $offset) {
            if (isset($map[$y + $offset[1]]) && isset($map[$y + $offset[1]][$x + $offset[0]])) {
                $okay = false;
                break;
            }
        }
        if ($okay) {
            $or[] = reset($set);
        }
    }
    return count($or) == 4 ? [0, 0] : (empty($or) ? [0, 0] : reset($or));
}

function check($map, $elves, $dir, $part1)
{
    $t = 1;
    $moving = true;
    while ($moving) {
        $moving = false;
        $proposed = [];

        foreach ($elves as $e => $p) {
            $d = check_dir($map, $dir, $p);
            $elves[$e][2] = $p[0] + $d[0];
            $elves[$e][3] = $p[1] + $d[1];
            $proposed[$elves[$e][3]][$elves[$e][2]] = ($proposed[$elves[$e][3]][$elves[$e][2]] ?? 0) + 1;
        }

        foreach ($elves as $e => $p) {
            if ($p[2] == $p[0] && $p[3] == $p[1]) {
                continue;
            }
            if ($proposed[$p[3]][$p[2]] == 1) {
                unset($map[$p[1]][$p[0]]);
                $elves[$e][0] = $p[2];
                $elves[$e][1] = $p[3];
                $map[$p[3]][$p[2]] = $e;
                $moving = true;
            }
        }

        $dir[] = array_shift($dir);

        if ($part1 && $t == 10) {
            $min = [PHP_INT_MAX, PHP_INT_MAX];
            $max = [0, 0];
            foreach ($elves as $e => $p) {
                $min[0] = min($min[0], $p[0]);
                $min[1] = min($min[1], $p[1]);
                $max[0] = max($max[0], $p[0]);
                $max[1] = max($max[1], $p[1]);
            }
            $blank = 0;
            for ($y = $min[1]; $y <= $max[1]; $y++) {
                for ($x = $min[0]; $x <= $max[0]; $x++) {
                    if (!isset($map[$y][$x])) {
                        $blank++;
                    }
                }
            }
            return $blank;
        } elseif ($moving === false) {
            return $t;
        }

        $t++;
    }
}

print check($map, $elves, $dir, true) . "\n";
print check($map, $elves, $dir, false) . "\n";
