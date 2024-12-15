<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(15);
$data = $input->lines()->raw();

$offsets = ['^' => [0, -1], '>' => [1, 0], 'v' => [0, 1], '<' => [-1, 0]];

$grid = [];
$boxes = [];
$d = false;
$y = 0;
$directions = '';
foreach ($data as $row) {
    if (empty($row)) {
        $d = true;
    } elseif ($d) {
        $directions .= $row;
    } else {
        $width = strlen($row);
        for ($x = 0; $x < $width; $x++) {
            if ($row[$x] == '@') {
                $sx = $x;
                $sy = $y;
            } elseif ($row[$x] == 'O') {
                $boxes[] = [$x, $y];
            } elseif ($row[$x] == '#') {
                $grid[$y][$x] = 1;
            }
        }
        $y++;
    }
}

$count = strlen($directions);
$height = count($grid);

$x = $sx;
$y = $sy;

for ($i = 0; $i < $count; $i++) {
    $ox = $offsets[$directions[$i]][0];
    $oy = $offsets[$directions[$i]][1];
    $nx = $x + $ox;
    $ny = $y + $oy;

    if (!isset($grid[$ny][$nx])) {
        $cell = [$nx, $ny];
        if (false !== $index = array_search($cell, $boxes)) {
            $moving = [];
            do {
                $moving[] = $index;
                $cell[0] += $ox;
                $cell[1] += $oy;
            } while (false !== $index = array_search($cell, $boxes));
            if (!isset($grid[$cell[1]][$cell[0]])) {
                foreach ($moving as $index) {
                    $boxes[$index][0] += $ox;
                    $boxes[$index][1] += $oy;
                }
                $x = $nx;
                $y = $ny;
            }
        } else {
            $x = $nx;
            $y = $ny;
        }
    }
}

$total = array_reduce($boxes, fn($t, $b) => $t += ($b[0] + $b[1] * 100));
print $total . "\n";

$grid = [];
$boxes = [];
$y = 0;
$id = 0;
foreach ($data as $row) {
    if (empty($row)) {
        break;
    }
    $width = strlen($row);
    for ($x = 0; $x < $width; $x++) {
        if ($row[$x] == '@') {
            $sx = $x * 2;
            $sy = $y;
        } elseif ($row[$x] == 'O') {
            $boxes[$y][$x * 2] = [$id, 0];
            $boxes[$y][$x * 2 + 1] = [$id, 1];
            $id++;
        } elseif ($row[$x] == '#') {
            $grid[$y][$x * 2] = 1;
            $grid[$y][$x * 2 + 1] = 1;
        }
    }
    $y++;
}

$width *= 2;
$x = $sx;
$y = $sy;

function can_move_vertically($x, $y, $oy)
{
    global $offsets, $grid, $boxes;
    $box = $boxes[$y][$x];
    $id = $box[0];
    $bxs = [];
    $bxs[$box[1]] = $x;
    $side = $box[1] == 0 ? 1 : 0;
    $bxs[$side] = $side == 0 ? $x - 1 : $x + 1;
    foreach ($bxs as $x) {
        if (isset($grid[$y + $oy][$x])) {
            return false;
        }
    }
    $moving = [];
    foreach ($bxs as $x) {
        if (isset($boxes[$y + $oy][$x])) {
            $moving[$boxes[$y + $oy][$x][0]] = [$x, $y + $oy];
        }
    }

    $return = [];
    foreach ($moving as $box) {
        if (false === $r = can_move_vertically($box[0], $box[1], $oy)) {
            return false;
        }
        $return = array_merge($return, $r);
    }
    foreach ($bxs as $side => $x) {
        $return[] = [$x, $y, $y + $oy, $id, $side];
    }
    return $return;
}

for ($i = 0; $i < $count; $i++) {
    $ox = $offsets[$directions[$i]][0];
    $oy = $offsets[$directions[$i]][1];
    $nx = $x + $ox;
    $ny = $y + $oy;

    if (!isset($grid[$ny][$nx])) {
        if (isset($boxes[$ny][$nx])) {
            if ($ox == 0) {
                if (false !== $move = can_move_vertically($nx, $ny, $oy)) {
                    foreach ($move as $box) {
                        unset($boxes[$box[1]][$box[0]]);
                    }
                    foreach ($move as $box) {
                        $boxes[$box[2]][$box[0]] = [$box[3], $box[4]];
                    }
                    $x = $nx;
                    $y = $ny;
                }
            } else {
                $moving = [];
                $bx = $nx;
                do {
                    $moving[] = [$bx, $boxes[$ny][$bx]];
                    $bx += $ox;
                } while (isset($boxes[$ny][$bx]));
                if (!isset($grid[$ny][$bx])) {
                    foreach ($moving as $box) {
                        unset($boxes[$ny][$box[0]]);
                    }
                    foreach ($moving as $box) {
                        $boxes[$ny][$box[0] + $ox] = $box[1];
                    }
                    $x = $nx;
                    $y = $ny;
                }
            }
        } else {
            $x = $nx;
            $y = $ny;
        }
    }
}

$total = 0;
foreach ($boxes as $y => $row) {
    $row = array_filter($row, fn($v) => $v[1] == 0);
    foreach ($row as $x => $box) {
        $total += ($y * 100 + $x);
    }
}
print $total . "\n";
