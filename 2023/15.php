<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(15);

$data = explode(',', $input->raw());

function algo($string)
{
    return array_reduce(
        str_split($string),
        function ($current, $value) {
            $current += ord($value);
            $current *= 17;
            return $current % 256;
        },
        0
    );
}

print array_reduce($data, fn($t, $v) => $t + algo($v), 0) . "\n";

$boxes = array_fill(0, 256, []);
$labels = [];
foreach ($data as $key => $value) {
    if (preg_match('/(\w+)=(\d)/', $value, $matches)) {
        list(, $label, $lens) = $matches;
        $index = algo($label);
        $boxes[$index][$label] = $lens;
        $labels[$label] = $index;
    } elseif (preg_match('/(\w+)\-/', $value, $matches)) {
        $label = $matches[1];
        $index = algo($label);
        if (isset($labels[$label])) {
            $index = $labels[$label];
            unset($boxes[$index][$label]);
            unset($labels[$label]);
        }
    }
}

$total = 0;
foreach ($boxes as $b => $contents) {
    $lenses = array_values($contents);
    foreach ($lenses as $l => $lens) {
        $total += ($b + 1) * ($l + 1) * $lens;
    }
}
print $total . "\n";
