<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(20)->lines()->raw();

function sgn($value)
{
    return $value <=> 0;
}

foreach ($data as $key => $value) {
    $data[$key] = [$value, $key];
}

$positions = $data;
foreach ($data as $key => $value) {
    if ($value[0] == 0) {
        continue;
    }
    $value[0] = $value[0] % (count($positions) - 1);
    $positions[$key][1] += (0.5 * sgn($value[0]) + $value[0]);
    if ($positions[$key][1] < 0) {
        $positions[$key][1] = count($data) + $positions[$key][1];
    } elseif ($positions[$key][1] >= count($data)) {
        $positions[$key][1] = $positions[$key][1] - count($data);
    }
    uasort($positions, fn($a, $b) => $a[1] <=> $b[1]);
    $c = 0;
    foreach ($positions as $p => $pos) {
        $positions[$p][1] = $c++;
    }
}

$positions = array_map(fn($n) => $n[0], array_values($positions));

function get_pos($data, $diff)
{
    $zero = array_search(0, $data);
    $pos = ($zero + $diff) % count($data);
    return $data[$pos];
}

print get_pos($positions, 1000) + get_pos($positions, 2000) + get_pos($positions, 3000);
print "\n";
