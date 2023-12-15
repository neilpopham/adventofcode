<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(14);

$data = $input->lines()->raw();

$my = count($data);
$mx = strlen($data[0]);
$rocks = [];
$cubes = [];
foreach ($data as $y => $line) {
    for ($x = 0; $x < $mx; $x++) {
        if ($line[$x] == 'O') {
            $rocks[] = [$x, $y];
        } elseif ($line[$x] == '#') {
            $cubes[0][$x][] = [$x, $y];
            $cubes[1][$y][] = [$x, $y];
            $solids[$y][$x] = '#';
        }
    }
}

function tilt($rocks, $dir)
{
    global $solids, $cubes, $mx, $my, $cycle, $hashes;
    $map = $solids;
    switch ($dir) {
        case 0:
            usort($rocks, fn($a, $b) => $a[1] <=> $b[1]);
            foreach ($rocks as $r => $rock) {
                list($rx, $ry) = $rock;
                $floor = -1;
                if (isset($cubes[0][$rx])) {
                    foreach ($cubes[0][$rx] as $cube) {
                        if ($cube[1] < $ry) {
                            $floor = max($floor, $cube[1]);
                        }
                    }
                }
                $y = $floor + 1;
                while (isset($map[$y][$rx])) {
                    $y++;
                }
                $rocks[$r] = [$rx, $y];
                $map[$rocks[$r][1]][$rocks[$r][0]] = 'O';
            }
            break;
        case 1:
            usort($rocks, fn($a, $b) => $a[0] <=> $b[0]);
            foreach ($rocks as $r => $rock) {
                list($rx, $ry) = $rock;
                $floor = -1;
                if (isset($cubes[1][$ry])) {
                    foreach ($cubes[1][$ry] as $cube) {
                        if ($cube[0] < $rx) {
                            $floor = max($floor, $cube[0]);
                        }
                    }
                }
                $x = $floor + 1;
                while (isset($map[$ry][$x])) {
                    $x++;
                }
                $rocks[$r] = [$x, $ry];
                $map[$rocks[$r][1]][$rocks[$r][0]] = 'O';
            }
            break;
        case 2:
            usort($rocks, fn($a, $b) => $b[1] <=> $a[1]);
            foreach ($rocks as $r => $rock) {
                list($rx, $ry) = $rock;
                $floor = $my;
                if (isset($cubes[0][$rx])) {
                    foreach ($cubes[0][$rx] as $cube) {
                        if ($cube[1] > $ry) {
                            $floor = min($floor, $cube[1]);
                        }
                    }
                }
                $y = $floor - 1;
                while (isset($map[$y][$rx])) {
                    $y--;
                }
                $rocks[$r] = [$rx, $y];
                $map[$rocks[$r][1]][$rocks[$r][0]] = 'O';
            }
            break;
        case 3:
            usort($rocks, fn($a, $b) => $b[0] <=> $a[0]);
            foreach ($rocks as $r => $rock) {
                list($rx, $ry) = $rock;
                $floor = $mx;
                if (isset($cubes[1][$ry])) {
                    foreach ($cubes[1][$ry] as $cube) {
                        if ($cube[0] > $rx) {
                            $floor = min($floor, $cube[0]);
                        }
                    }
                }
                $x = $floor - 1;
                while (isset($map[$ry][$x])) {
                    $x--;
                }
                $rocks[$r] = [$x, $ry];
                $map[$rocks[$r][1]][$rocks[$r][0]] = 'O';
            }
            break;
    }

    if ($dir == 3) {
        $hash = '';
        foreach ($map as $y => $row) {
            foreach (array_keys($row) as $x) {
                $hash .= str_pad($x, 2, '0', STR_PAD_LEFT);
            }
        }
        $hash = md5($hash);
        $match = array_search($hash, $hashes);
        $hashes[$cycle] = $hash;
        if (false !== $match) {
            $loop = $cycle - $match;
            $add = $loop * floor((MAX_CYCLES - $match) / $loop);
            $cycle = $match + $add - 1;
            $hashes = [];
        }
    }

    return $rocks;
}

$hashes = [];
$cycle = 1;
$d = 0;
const MAX_CYCLES = 4000000000;

function part1($rocks)
{
    global $my;
    $rocks = tilt($rocks, 0);

    return array_reduce($rocks, fn($t, $v) => $t + $my - $v[1], 0);
}

function part2($rocks)
{
    global $cycle, $my, $hashes;
    $hashes = [];
    $d = 0;
    do {
        $cycle++;
        $rocks = tilt($rocks, $d);
        $d++;
        $d = $d % 4;
    } while ($cycle < MAX_CYCLES);

    return array_reduce($rocks, fn($t, $v) => $t + $my - $v[1], 0);
}

print part1($rocks) . "\n";

print part2($rocks) . "\n";
