<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(22);
$data = $input->lines()->raw();

function mix($n, $s)
{
    return $n ^ $s;
}

function prune($n)
{
    return $n % 16777216;
}

function format_change($value)
{
    return $value < 0 ? strval($value) : '+' . $value;
}

foreach ($data as $buyer => &$secret) {
    $prices[$buyer] = [$secret % 10];
    for ($i = 0; $i < 2000; $i++) {
        $secret = prune(mix(64 * $secret, $secret));
        $secret = prune(mix(intval($secret / 32), $secret));
        $secret = prune(mix(2048 * $secret, $secret));

        $prices[$buyer][] = $secret % 10;
    }
}
print array_sum($data) . "\n";

$sequences = [];
$changes = [];
foreach ($prices as $buyer => $price) {
    $changes[$buyer] = [];
    $c = [];
    for ($i = 1; $i < count($price); $i++) {
        $c[] = format_change($price[$i] - $price[$i - 1]);
        if ($i < 4) {
            continue;
        }
        $sequence = implode('', array_slice($c, -4));
        if (isset($changes[$buyer][$sequence])) {
            continue;
        }
        $changes[$buyer][$sequence] = $prices[$buyer][$i];
        $sequences[$sequence] = 1;
    }
}

$sequences = array_keys($sequences);
$max = 0;
foreach ($sequences as $sequence) {
    $sum = 0;
    foreach ($changes as $buyer => $values) {
        if (isset($values[$sequence])) {
            $sum += $values[$sequence];
        }
    }
    $max = max($max, $sum);
}
print $max . "\n";
