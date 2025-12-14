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


function follow($devices, $path, $fft, $dac)
{
    global $cache;
    if (empty($path)) {
        return;
    }
    $current = end($path);
    $key = $current . $fft . $dac;
    if (isset($cache[$key])) {
        return $cache[$key];
    }
    if ($current == 'out') {
        return $fft && $dac ? 1 : 0;
    }
    if ($current == 'fft') {
        $fft = 1;
    }
    if ($current == 'dac') {
        $dac = 1;
    }
    $cache[$key] = 0;
    if (false === isset($devices[$current])) {
        return 0;
    }
    foreach ($devices[$current] as $device) {
        $new = array_merge($path, [$device]);
        $cache[$key] += follow($devices, $new, $fft, $dac);
    }
    return $cache[$key];
}

print follow($devices, ['svr'], 0, 0) . "\n";
