<?php

require 'libs/aoc.php';

$input = new AdventOfCode\AdventOfCode()->input(11)->lines();

$data = array_map(
    function ($x) {
        $x[1] = explode(' ', $x[1]);
        return $x;
    },
    $input->regex('/(\w+): ([\w ]+)/')
);

$devices = [];
foreach ($data as $device) {
    $devices[$device[0]] = $device[1];
}

function follow($path)
{
    global $queue, $devices;
    if (empty($path)) {
        return;
    }
    $current = end($path);
    foreach ($devices[$current] as $device) {
        $new = array_merge($path, [$device]);
        if ($device == 'out') {
            return $new;
        }
        $queue[] = $new;
    }
}

$total = 0;
$queue = [['you']];
do {
    $path = array_pop($queue);
    if ($route = follow($path)) {
        $total++;
    }
} while ($path !== null);
print $total . "\n";
