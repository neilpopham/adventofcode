<?php

require 'libs/aoc.php';

$input = new AdventOfCode\AdventOfCode()->input(2);
$data = $input->lines();

$checksum = 0;
foreach ($data as $row) {
    $numbers = explode(' ', preg_replace('/\s+/', ' ', subject: $row));
    sort($numbers);
    $checksum += end($numbers) - reset($numbers);
}

print $checksum . "\n";

$checksum = 0;
foreach ($data as $row) {
    $numbers = explode(' ', preg_replace('/\s+/', ' ', subject: $row));
    foreach ($numbers as $n1) {
        foreach ($numbers as $n2) {
            if ($n1 == $n2) {
                continue;
            }
            $d = $n1 / $n2;
            if (intval($d) == $d) {
                break 2;
            }
        }
    }
    $checksum += $d;
}

print $checksum . "\n";
