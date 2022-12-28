<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(22)->lines(false)->raw();

$data = array_filter($data);
$path = array_pop($data);

$path = preg_split('/([LR])/i', $path, -1, PREG_SPLIT_DELIM_CAPTURE);

foreach ($data as $i => $row) {
    $data[$i] = array_filter(str_split($row), fn($v) => !empty(trim($v)));
}

$pos = [key($data[0]), 0];
$dir = [[1, 0], [0, 1], [-1,0], [0, -1]];
$d = 0;

foreach ($path as $move) {
    if ($move == 'L') {
        $d = $d == 0 ? 3 : $d - 1;
    } elseif ($move == 'R') {
        $d = $d == 3 ? 0 : $d + 1;
    } else {
        $o = $dir[$d];
        $x = $pos[0];
        $y = $pos[1];
        for ($i = 0; $i < $move; $i++) {
            $x += $o[0];
            $y += $o[1];
            if (isset($data[$y][$x])) {
                if ($data[$y][$x] == '#') {
                    $x -= $o[0];
                    $y -= $o[1];
                    break;
                }
            } else {
                $tx = $pos[0];
                $ty = $pos[1];
                while (isset($data[$ty][$tx])) {
                    $tx -= $o[0];
                    $ty -= $o[1];
                }
                $tx += $o[0];
                $ty += $o[1];
                if ($data[$ty][$tx] == '#') {
                    $tx = $x - $o[0];
                    $ty = $y - $o[1];
                    $i = $move;
                }
                $x = $tx;
                $y = $ty;
            }
        }
        $pos = [$x, $y];
    }
}

print 1000 * ($pos[1] + 1) + 4 * ($pos[0] + 1) + $d;
print "\n";
