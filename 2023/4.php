<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(4);

$data = $input->lines()->regex('/Card\s+(\d+):([\d\s]+)\|([\d\s]+)/');

function numbers2array($value)
{
    return array_filter(explode(' ', $value));
}

$total = 0;
foreach ($data as $key => $card) {
    $data[$key][1] = numbers2array($card[1]);
    $data[$key][2] = numbers2array($card[2]);
    $matches = array_intersect($data[$key][1], $data[$key][2]);
    $data[$key][3] = count($matches);
    $total += ($data[$key][3] ? 1 << ($data[$key][3] - 1) : 0);
}
print $total . "\n";

$counts = [];

function find_count($index)
{
    global $data, $counts;
    if (isset($counts[$index])) {
        return $counts[$index];
    }
    $card = $data[$index];
    $count = 1;
    for ($i = 0; $i < $card[3]; $i++) {
        $count += find_count($card[0] + $i);
    }
    $counts[$index] = $count;
    return $count;
}

$total = 0;
foreach ($data as $key => $card) {
    $total += find_count($key);
}
print $total . "\n";
