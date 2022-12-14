<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(14)->lines()->raw();

$my = 0;
$cells = [];
foreach ($data as $key => $value) {
    if (preg_match_all('/(\d+),(\d+)/', $value, $matches, PREG_SET_ORDER)) {
        for ($i = 1; $i < count($matches); $i++) {
            list(, $x1, $y1) = $matches[$i - 1];
            list(, $x2, $y2) = $matches[$i];
            if ($y1 == $y2) {
                if (!isset($cells[$y1])) {
                    $cells[$y1] = [];
                }
                $xs = min($x1, $x2);
                $xe = max($x1, $x2);
                for ($x = $xs; $x <= $xe; $x++) {
                    $cells[$y1][$x] = 1;
                }
            } else {
                $ys = min($y1, $y2);
                $ye = max($y1, $y2);
                for ($y = $ys; $y <= $ye; $y++) {
                    if (!isset($cells[$y])) {
                        $cells[$y] = [];
                    }
                    $cells[$y][$x1] = 1;
                }
            }
            $y = (int) ($ye ?? $y1);
            if ($y > $my) {
                $my = $y;
            }
        }
    }
}

$my++;

function check($cells, $part2)
{
    global $my;
    $map = [[0, 1], [-1, 1], [1, 1]];
    $canmove = true;
    $t = -1;
    while ($canmove) {
        $t++;
        $s = [500, 0];
        $moving = true;
        while ($moving) {
            $moving = false;
            foreach ($map as $offset) {
                if (($cells[$s[1] + $offset[1]][$s[0] + $offset[0]] ?? 0) == 0) {
                    $s[0] += $offset[0];
                    $s[1] += $offset[1];
                    $moving = true;
                    break;
                }
            }
            if ($part2) {
                if ($moving) {
                    if ($s[1] == $my) {
                        $moving = false;
                    }
                } else {
                    if ($s[1] == 0 && $s[0] == 500) {
                        $canmove = false;
                        $moving = false;
                    }
                }
            } elseif ($s[1] == $my) {
                $canmove = false;
                $moving = false;
            }
            if ($moving === false) {
                $cells[$s[1]][$s[0]] = 2;
            }
        }
    }
    return $t;
}

$t = check($cells, false);
print "{$t}\n";
$t = check($cells, true) + 1;
print "{$t}\n";
