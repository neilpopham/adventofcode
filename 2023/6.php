<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(6);

$data = $input->lines()->regex('/\w+:\s+(.+)/');

function numbers2array($value)
{
    return explode(' ', preg_replace('/\s+/', ' ', trim($value)));
}

$times = numbers2array($data[0][0]);
$distances = numbers2array($data[1][0]);

function find($distance, $time)
{
    $start = floor($time / 2);
    $current = 0;
    $total = 1;
    $diff = 1;
    while ($total > $current) {
        $current = $total;
        foreach ([$diff, -$diff] as $offset) {
            if (($start + $offset) * ($time - ($start + $offset)) > $distance) {
                $total++;
            }
        }
        $diff++;
    }
    return $total;
}

$product = 1;
foreach ($distances as $race => $distance) {
    $time = $times[$race];
    $product *= find($distance, $time);
}
print $product . "\n";

$time = str_replace(' ', '', $data[0][0]);
$distance = str_replace(' ', '', $data[1][0]);

print find($distance, $time) . "\n";
