<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(12)->lines()->raw();

foreach ($data as $r => $line) {
    if (false !== $c = strpos($line, 'S')) {
        $S = [$c, $r];
    }
    if (false !== $c = strpos($line, 'E')) {
        $E = [$c, $r];
    }
}

$h = ['S' => ord('a'), 'E' => ord('z')];
foreach (range('a', 'z') as $char) {
    $h[$char] = ord($char);
}
$map = [[0, -1], [1, 0], [0, 1], [-1, 0]];
$mx = strlen($data[0]) - 1;
$my = count($data) - 1;

function process($p, $x, $y)
{
    global $data, $map, $h, $g, $mx, $my;
    $q = [];
    $s = $h[$data[$y][$x]];
    foreach ($map as $offset) {
        $px = $x + $offset[0];
        if ($px < 0 || $px > $mx) {
            continue;
        }
        $py = $y + $offset[1];
        if ($py < 0 || $py > $my) {
            continue;
        }
        $char = $data[$py][$px];
        $ps = $h[$char];
        $pg = $g[$y][$x] + 1;
        if ($p == 1) {
            $valid = (($pg < ($g[$py][$px] ?? PHP_INT_MAX)) && ($ps < $s + 2));
        } else {
            $valid = (($pg < ($g[$py][$px] ?? PHP_INT_MAX)) && ($ps > $s - 2));
        }
        if ($valid) {
            $g[$py][$px] = $pg;
            $q[] = [$px, $py];
        }
    }
    return $q;
}

$g = array_fill(0, count($data), []);
$g[$S[1]][$S[0]] = 0;
$q = process(1, $S[0], $S[1]);

$cell = current($q);
while (false === is_null($cell)) {
    $q = array_merge($q, process(1, $cell[0], $cell[1]));
    $cell = array_shift($q);
}

print $g[$E[1]][$E[0]] . "\n";

$g = array_fill(0, count($data), []);
$g[$E[1]][$E[0]] = 0;
$q = process(2, $E[0], $E[1]);

$cell = current($q);
while (false === is_null($cell)) {
    $options = process(2, $cell[0], $cell[1]);
    foreach ($options as $o) {
        if ($data[$o[1]][$o[0]] == 'a') {
            print $g[$o[1]][$o[0]] . "\n";
            exit;
        }
    }
    $q = array_merge($q, $options);
    $cell = array_shift($q);
}
