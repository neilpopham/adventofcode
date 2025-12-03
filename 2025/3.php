<?php

require 'libs/aoc.php';

$input = new AdventOfCode\AdventOfCode()->input(3)->lines();

$data = $input->raw();

function largest($digits)
{
    for ($i = 9; $i > 0; $i--) {
        if (false !== $p = strpos($digits, $i)) {
            return [$i, $p];
        }
    }
}

$total = 0;
foreach ($data as $batteries) {
    [$d1, $p] = largest(substr($batteries, 0, -1));
    [$d2, $p] = largest(substr($batteries, $p + 1));
    $total += ($d1 * 10) + $d2;
}
print $total . "\n";

$total = 0;
foreach ($data as $batteries) {
    $digits = '';
    $o = 0;
    for ($i = -11; $i <= 0; $i++) {
        [$d, $p] = largest(substr($batteries, $o, $i ?: null));
        $digits .= $d;
        $o += $p + 1;
    }
    $total += (int) $digits;
}
print $total . "\n";