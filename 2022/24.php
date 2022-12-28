<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(24)->lines()->raw();

$min = [0, 0];
$max = [strlen($data[0]) - 3, count($data) - 3];
$count = [$max[0] + 1, $max[1] + 1];
$s = [0, -1];
$e = [$max[0], $max[1] + 1];
$map = ['>' => [1, 0], 'v' => [0, 1], '<' => [-1, 0], '^' => [0, -1]];

$blizzards = [];
foreach ($data as $y => $row) {
    for ($x = 0; $x < strlen($row); $x++) {
        if (isset($map[$row[$x]])) {
            $blizzards[] = [$x - 1, $y - 1, $row[$x]];
        }
    }
}

function new_pos($p, $o, $t, $max)
{
    $d = ($p + $o * $t) % $max;
    return $d < 0 ? $max + $d : $d;
}

function process($posx, $posy, $t, $path)
{
    global $blizzards, $count, $max, $e, $g;

    if (isset($g["{$posx}|{$posy}|{$t}"])) {
        return [];
    }

    $g["{$posx}|{$posy}|{$t}"] = $t;
    $map = ['>' => [1, 0], 'v' => [0, 1], 'x' => [0, 0], '<' => [-1, 0], '^' => [  0, -1]];
    $b = [];
    $q = [];

    foreach ($blizzards as $blizzard) {
        list($x, $y, $dir) = $blizzard;
        $o = $map[$dir];
        $x = new_pos($x, $o[0], $t, $count[0]);
        $y = new_pos($y, $o[1], $t, $count[1]);
        $b["{$x}|{$y}"] = 1;
    }

    foreach ($map as $m => $offset) {
        $px = $posx + $offset[0];
        $py = $posy + $offset[1];

        if ($px == $e[0] && $py == $e[1]) {
            $q[] = [$px, $py, $t, $path . $m, 0];
            continue;
        }

        if ($px < 0 || $px > $max[0] || $py < 0 || $py > $max[1]) {
            continue;
        }

        if (!isset($b["{$px}|{$py}"])) {
            $man = abs($e[0] - $px) + abs($e[1] - $py);
            $q[] = [$px, $py, $t, $path . $m, $man];
        }
    }

    uasort($q, fn($a, $b) => $a[4] <=> $b[4]);
    return $q;
}

$g = [];
$h = [];
$q = process($s[0], $s[1], 1, 'x');
$cell = array_shift($q);
while (false === is_null($cell)) {
    $q = array_merge($q, process($cell[0], $cell[1], $cell[2] + 1, $cell[3]));
    $cell = array_shift($q);
    if ($cell && $cell[0] == $e[0] && $cell[1] == $e[1]) {
        print "{$cell[2]}\n";
        exit;
    }
}
