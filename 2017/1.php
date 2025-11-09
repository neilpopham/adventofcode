<?php

require 'libs/aoc.php';

$data = new AdventOfCode\AdventOfCode()->input(day: 1)->raw();

$data .= $data[0];

preg_match_all('/(\d)\1+/', $data, $matches);

$total = array_sum(
    array_map(
        fn($v) => $v[0] * (strlen($v) - 1),
        $matches[0]
    )
);

print $total . "\n";

$len = strlen($data);

$a = substr($data, 0, $len / 2);
$b = substr($data, $len / 2);

$total = 0;
for ($i = 0; $i < strlen($a) - 1; $i++) {
    if ($a[$i] == $b[$i]) {
        $total += 2 * $a[$i];
    }
}

print $total . "\n";
