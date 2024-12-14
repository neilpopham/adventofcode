<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(12);
$data = $input->lines()->map(fn($row) => str_split($row));

$offsets = [[0, -1], [-1, 0], [1, 0], [0, 1]];
$dirs = [1, 0, 2, 3];

$ids = [];
foreach ($data as $y => $row) {
    foreach ($row as $x => $char) {
        foreach ($offsets as $o => $offset) {
            $nx = $x + $offset[0];
            $ny = $y + $offset[1];
            if (!isset($data[$ny][$nx])) {
                continue;
            }
            if ($data[$ny][$nx] == $char) {
                if (isset($ids[$ny][$nx])) {
                    if (isset($ids[$y][$x])) {
                        if ($ids[$ny][$nx] != $ids[$y][$x]) {
                            foreach ($ids as $iy => $irow) {
                                foreach (array_keys($irow) as $ix) {
                                    if ($ids[$iy][$ix] == $ids[$ny][$nx]) {
                                        $ids[$iy][$ix] = $ids[$y][$x];
                                    }
                                }
                            }
                        }
                    } else {
                        $ids[$y][$x] = $ids[$ny][$nx];
                    }
                }
            }
        }
        if (!isset($ids[$y][$x])) {
            $ids[$y][$x] = $y * 1000 + $x;
        }
    }
}

$plots = [];
foreach ($ids as $y => $row) {
    foreach ($row as $x => $id) {
        $plots[$id][] = [$x, $y];
    }
}

$total = 0;
foreach ($plots as $id => $cells) {
    $perimeter = 0;
    foreach ($cells as $c) {
        $x = $c[0];
        $y = $c[1];
        foreach ($offsets as $o) {
            $nx = $x + $o[0];
            $ny = $y + $o[1];
            if (!isset($data[$ny][$nx])) {
                $perimeter++;
                continue;
            }
            if ($ids[$ny][$nx] != $id) {
                $perimeter++;
            }
        }
    }
    $total += ($perimeter * count($cells));
}
print $total . "\n";

$ids = [];
foreach ($plots as $id => $cells) {
    $giants[$id] = [];
    foreach ($cells as $cell) {
        foreach (range(0, 2) as $gy) {
            foreach (range(0, 2) as $gx) {
                $giants[$id][] = [$cell[0] * 3 + $gx + 1, $cell[1] * 3 + $gy + 1];
                $ids[$cell[1] * 3 + $gy + 1][$cell[0] * 3 + $gx + 1] = $id;
            }
        }
    }
}

$offsets = [[0, -1], [1, 0], [0, 1], [-1, 0]];

$panels = [];
$total = 0;
foreach ($giants as $id => $cells) {
    $panels[$id] = [];
    foreach ($cells as $c) {
        $x = $c[0];
        $y = $c[1];
        for ($dy = -1; $dy <= 1; $dy++) {
            for ($dx = -1; $dx <= 1; $dx++) {
                $nx = $x + $dx;
                $ny = $y + $dy;
                if (!isset($ids[$ny][$nx])) {
                    $panels[$id][$ny][$nx] = [$nx, $ny];
                    continue;
                }
                if ($ids[$ny][$nx] != $id) {
                    $panels[$id][$ny][$nx] = [$nx, $ny];
                }
            }
        }
    }

    $corners = 0;
    do {
        $d = 1;
        $row = reset($panels[$id]);
        $sy = key($panels[$id]);
        $sx = key($row);
        $x = $sx;
        $y = $sy;
        $corners++;

        do {
            $nx = $x + $offsets[$d][0];
            $ny = $y + $offsets[$d][1];

            if (!isset($panels[$id][$ny][$nx])) {
                $corners++;
                $dd = $d;
                $od = ($d + 2) % 4;
                while ($d == $od || !isset($panels[$id][$ny][$nx])) {
                    $d = ++$d % 4;
                    $nx = $x + $offsets[$d][0];
                    $ny = $y + $offsets[$d][1];
                }
            } else {
                if ($x != $sx || $y != $sy) {
                    unset($panels[$id][$y][$x]);
                }
                $x = $nx;
                $y = $ny;
            }
        } while ($corners < 4 || $x != $sx || $y != $sy);

        unset($panels[$id][$sy][$sx]);
        foreach ($panels[$id] as $r => $value) {
            if (empty($value)) {
                unset($panels[$id][$r]);
            }
        }
    } while (!empty($panels[$id]));

    $total += ($corners * count($plots[$id]));
}
print $total . "\n";
