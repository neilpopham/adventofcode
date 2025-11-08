<?php

$number = 368078;

$i = 1;
do {
    $i += 2;
} while (pow($i, 2) < $number);

$c = pow($i - 2, 2);
$x = $y = floor($i / 2);

$offsets = [[0,-1], [-1,0], [0,1], [1,0]];
$o = 0;
$d = 0;

while ($c != $number) {
    if ($d == $i - 1) {
        $o++;
        $d = 0;
    }
    $x += $offsets[$o][0];
    $y += $offsets[$o][1];
    $c++;
    $d++;
}

$distance = abs($x) + abs($y);

print $distance . "\n";
