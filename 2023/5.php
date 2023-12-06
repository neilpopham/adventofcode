<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(5);

$data = $input->lines()->raw(false);

$seeds = [];
$maps = [];
$i = -1;
foreach ($data as $line) {
    if (empty($line)) {
        continue;
    } elseif (preg_match('/seeds: (.+)/', $line, $matches)) {
        $seeds = array_filter(explode(' ', $matches[1]));
    } elseif (preg_match('/(\w+)\-to\-(\w+) map/', $line, $matches)) {
        $i++;
        $maps[$i] = [
            'source' => $matches[1],
            'destination' => $matches[2],
            'ranges' => []
        ];
    } else {
        $maps[$i]['ranges'][] = array_filter(explode(' ', $line), fn($v) => $v != ' ');
    }
}

function map($value)
{
    global $maps;
    foreach ($maps as $m => $map) {
        foreach ($map['ranges'] as $range) {
            if ($value >= $range[1] && $value < $range[1] + $range[2]) {
                $value = $range[0] + ($value - $range[1]);
                break;
            }
        }
    }
    return $value;
}

$location = PHP_INT_MAX;
foreach ($seeds as $seed) {
    $location = min($location, map($seed));
}
print $location . "\n";

$min = PHP_INT_MAX;
for ($i = 0; $i < count($seeds); $i++) {
    $start = $seeds[$i++];
    $end = $start + $seeds[$i];
    for ($seed = $start; $seed < $end; $seed++) {
        $location = map($seed);
        if ($location < $min) {
            $min = $location;
        }
    }
}
print $min . "\n";


