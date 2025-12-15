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

function follow($device, $fft, $dac)
{
    global $devices, $cache;
    $key = $device . $fft . $dac;
    if (isset($cache[$key])) {
        return $cache[$key];
    }
    if ($device == 'out') {
        return $fft && $dac ? 1 : 0;
    }
    if ($device == 'fft') {
        $fft = 1;
    }
    if ($device == 'dac') {
        $dac = 1;
    }
    if (false === isset($devices[$device])) {
        return 0;
    }
    $cache[$key] = 0;
    foreach ($devices[$device] as $device) {
        $cache[$key] += follow($device, $fft, $dac);
    }
    return $cache[$key];
}

print follow('you', 1, 1) . "\n";
print follow('svr', 0, 0) . "\n";
