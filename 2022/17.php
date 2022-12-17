<?php
require 'libs/api.php';

$jets = (new AdventOfCode())->input(17)->raw();

$rocks = [
    ['####'],
    ['.#.','###','.#.'],
    ['..#','..#','###'],
    ['#','#','#','#'],
    ['##','##'],
];

foreach ($rocks as $r => $row) {
    foreach ($row as $y => $string) {
        $array = [];
        for ($x = 0; $x < strlen($string); $x++) {
            if ($string[$x] == '#') {
                $array[$x] = $x;
            }
        }
        $rocks[$r][$y] = $array;
    }
}

function dump_rocks()
{
    global $rock, $set, $my, $ry, $rx;
    for ($y = $my; $y >= 0; $y--) {
        for ($x = 0; $x < 7; $x++) {
            $s = isset($set[$y][$x]) ? '#' : '.';
            foreach ($rock as $oy => $row) {
                foreach ($row as $ox) {
                    if (($y == $ry - $oy) && ($x == $rx + $ox)) {
                        $s = '@';
                    }
                }
            }
            print $s;
        }
        print "\n";
    }
    print "\n";
}

$rx = 2;
$ry = 3;
$my = 3;
$rn = 0;
$rock = $rocks[0];
$set = [];
$j = 0;
$jm = strlen($jets);

while (true) {
    $done = false;

    foreach ($rock as $oy => $row) {
        foreach ($row as $ox) {
            if (($ry - $oy < 0) || (isset($set[$ry - $oy][$rx + $ox]))) {
                $done = true;
                $ry++;
            }
        }
    }

    if ($done) {
        foreach ($rock as $oy => $row) {
            foreach ($row as $ox) {
                $set[$ry - $oy][$rx + $ox] = 1;
            }
        }

        $rock = $rocks[++$rn % 5];

        $rx = 2;
        $ry = (2 + count($rock) + count($set));
        $my = $ry;

        if ($rn == 2022) {
            exit(count($set) . "\n");
        }
    } else {
        $cx = $rx;
        $d = $jets[$j % $jm];
        $rx += ($d == '>') ? 1 : -1;

        foreach ($rock as $oy => $row) {
            foreach ($row as $ox) {
                if (($rx + $ox < 0) || ($rx + $ox > 6) || (isset($set[$ry - $oy][$rx + $ox]))) {
                    $rx = $cx;
                }
            }
        }

        $j++;
        $ry--;
    }
}
