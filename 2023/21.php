<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(21);

$data = $input->lines()->raw();

foreach ($data as $y => $line) {
    if (false !== $x = strpos($line, 'S')) {
        break;
    }
}

function move($x, $y, $h)
{
    global $data, $g, $queue, $mx, $my;

    if (isset($g["{$x}|{$y}"])) {
        return;
    }

    $g["{$x}|{$y}"] = $h;

    foreach ([[0, -1], [1, 0], [0, 1], [-1, 0]] as $offset) {
        $dx = $x + $offset[0];
        $dy = $y + $offset[1];
        if ($h < MAX && $dx >= 0 && $dy >= 0 && $dx < $mx && $dy < $my && $data[$dy][$dx] == '.') {
            $queue[] = [$dx, $dy, $h + 1];
        }
    }
}

define('MAX', 64);
$mx = strlen($data[0]);
$my = count($data);
$g = [];
$h = [];
$queue = [[$x, $y, 0]];
$sx = $x;
$sy = $y;

while (count($queue)) {
    list($x, $y, $h) = array_shift($queue);
    move($x, $y, $h);
}

$even = array_filter(
    $g,
    function ($k) use ($sx, $sy) {
        list($x, $y) = explode('|', $k);
        return (abs((int) $x - $sx) + abs((int) $y - $sy)) % 2 == 0;
    },
    ARRAY_FILTER_USE_KEY
);
print count($even) . "\n";
