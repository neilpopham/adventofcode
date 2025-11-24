<?php

require 'libs/aoc.php';

$data = new AdventOfCode\AdventOfCode()->input(day: 25)->lines()->raw();

function pattern($line, $regex)
{
    preg_match($regex, $line, $matches);
    return array_slice($matches, 1);
}

[$state] = pattern($data[0], '/state (\w)/');
[$steps] = pattern($data[1], '/after (\d+) steps/');

$ins = [];
for ($i = 2; $i < count($data); $i++) {
    if (preg_match('/In state (\w):/', $data[$i], $matches)) {
        $s = $matches[1];
        $ins[$s] = [];
    } elseif (preg_match('/If the current value is (\d):/', $data[$i], $matches)) {
        $c = $matches[1];
        $ins[$s][$c] = [];
    } elseif (preg_match('/Write the value (\d)/', $data[$i], $matches)) {
        $ins[$s][$c][0] = $matches[1];
    } elseif (preg_match('/Move one slot to the (\w+)/', $data[$i], $matches)) {
        $ins[$s][$c][1] = $matches[1] == 'right' ? 1 : -1;
    } elseif (preg_match('/Continue with state (\w)/', $data[$i], $matches)) {
        $ins[$s][$c][2] = $matches[1];
    }
}

$p = 0;
$slots = [0];
for ($i = 0; $i < $steps; $i++) {
    [$value, $dir, $state] = $ins[$state][$slots[$p]];
    $slots[$p] = $value;
    $p += $dir;
    if (!isset($slots[$p])) {
        if ($dir == 1) {
            $slots[$p] = 0;
        } else {
            $slots = array_merge([0], $slots);
            $p = 0;
        }
    }
}

$checksum = array_reduce($slots, fn($t, $v) => $t + $v);
print $checksum . "\n";
