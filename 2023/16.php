<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(16);

$data = $input->lines()->raw();

$my = count($data);
$mx = strlen($data[0]);
$offsets = [[0, -1], [1, 0], [0, 1], [-1, 0]];

function move($beams, $b)
{
    global $data, $energised, $offsets, $beams, $mx, $my;
    $beam = $beams[$b];
    list($x, $y, $d) = $beam;

    if (isset($energised[$y][$x]) && in_array($d, $energised[$y][$x])) {
        unset($beams[$b]);
        return;
    }
    $energised[$y][$x][] = $d;

    $x += $offsets[$d][0] ?? 0;
    $y += $offsets[$d][1] ?? 0;
    $d = $d % 4;

    if ($x < 0 || $x == $mx || $y < 0 || $y == $my) {
        unset($beams[$b]);
        return;
    }

    $tile = $data[$y][$x];

    switch ($tile) {
        case '/':
            $d = (5 - $d) % 4;
            break;
         case '\\':
            $d = 3 - $d;
            break;
        case '-':
            if ($d % 2 == 0) {
                $d = 1;
                $beams[] = [$x, $y, 3];
            }
            break;
        case '|':
            if ($d % 2 == 1) {
                $d = 0;
                $beams[] = [$x, $y, 2];
            }
            break;
    }
    $beams[$b] = [$x, $y, $d];
}

function energise($beam)
{
    global $beams, $energised;
    $beams = [$beam];
    $energised = [];
    while (count($beams)) {
        foreach (array_keys($beams) as $b) {
            move($beams, $b);
        }
        $beams = array_values($beams);
    }
    return array_reduce($energised, fn($t, $v) => $t + count($v));
}

print energise([0, 0, 5]) . "\n";

$starts = [];
$sx = $mx - 1;
$sy = $my - 1;
for ($x = 0; $x < $mx; $x++) {
    $starts["{$x}|0|2"] = energise([$x, 0, 6]);
    $starts["{$x}|{$sy}|0"] = energise([$x, $sy, 4]);
}
for ($y = 0; $y < $my; $y++) {
    $starts["0|{$y}|1"] = energise([0, $y, 5]);
    $starts["{$sx}|{$y}|3"] = energise([$sx, $y, 7]);
}

sort($starts);
print end($starts) . "\n";
