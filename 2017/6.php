<?php

require 'libs/aoc.php';

$data = new AdventOfCode\AdventOfCode()->input(day: 6)->raw();
$data = explode("\t", $data);

function cycle($data)
{
    $values = $data;
    arsort($values);
    $n = reset($values);
    $p = key($values);
    $data[$p] = 0;
    $p++;
    for ($i = 0; $i < $n; $i++) {
        if (!isset($data[$p])) {
            $p = 0;
        }
        $data[$p]++;
        $p++;
    }
    return $data;
}

$history = [];
do {
    $history[] = $data;
    $unique = true;
    $data = cycle($data);
    foreach ($history as $step) {
        if ($data == $step) {
            $unique = false;
        }
    }
} while ($unique);

print count($history) . "\n";

$goal = $data;
$cycles = 0;
do {
    $data = cycle($data);
    $cycles++;
} while ($data != $goal);

print $cycles . "\n";
