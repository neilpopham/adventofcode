<?php

require 'libs/aoc.php';

$data = new AdventOfCode\AdventOfCode()->input(day: 15)->lines()->regex('/Generator ([AB]) starts with (\d+)/');

$generators = [$data[0][1], $data[1][1]];
$factors = [16807, 48271];
$modulo = 2147483647;
$sixteen = [];
$total = 0;
for ($p = 0; $p < 40000000; $p++) {
    for ($i = 0; $i < 2; $i++) {
        $generators[$i] *= $factors[$i];
        $generators[$i] %= $modulo;
        $sixteen[$i] = $generators[$i] & 65535;
    }
    if ($sixteen[0] == $sixteen[1]) {
        $total++;
    }
}

print $total . "\n";

$generators = [$data[0][1], $data[1][1]];
$total = 0;
$tested = 0;
$dividers = [4, 8];
$sixteen = [];
do {
    for ($i = 0; $i < 2; $i++) {
        do {
            $generators[$i] *= $factors[$i];
            $generators[$i] %= $modulo;
        } while ($generators[$i] % $dividers[$i] > 0);
        $sixteen[$i] = $generators[$i] & 65535;
    }
    if ($sixteen[0] == $sixteen[1]) {
        $total++;
    }
    $tested++;
} while ($tested < 5000000);

print $total . "\n";
