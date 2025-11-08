<?php

require 'libs/aoc.php';

$data = new AdventOfCode\AdventOfCode()->input(day: 10)->raw();

$lengths = explode(',', $data);
$list = range(0, 255);
$p = 0;
$skip = 0;
$max = count($list);

foreach ($lengths as $length) {
    $tmp = [];
    $key = $p;
    for ($i = 0; $i < $length; $i++) {
        $tmp[$key] = $list[$key];
        $key = ($key + 1) % $max;
    }
    $keys = array_keys($tmp);
    $reversed = array_reverse(array_values($tmp));
    $new = array_combine($keys, $reversed);
    foreach ($new as $key => $value) {
        $list[$key] = $value;
    }
    $p = ($p + $length + $skip) % $max;
    $skip++;
}

print array_product(array_slice($list, 0, 2)) . "\n";

function combine($array) {
    $x = $array[0];
    for ($i = 1; $i < count($array); $i++) {
        $x = $x ^ $array[$i];
    }
    return $x;
}

$lengths = array_map(fn($v) => ord($v), str_split($data));
$lengths = array_merge($lengths, [17, 31, 73, 47, 23]);
$list = range(0, 255);
$p = 0;
$skip = 0;
$max = count($list);

for ($t = 0; $t < 64; $t++) {
    foreach ($lengths as $length) {
        $tmp = [];
        $key = $p;
        for ($i = 0; $i < $length; $i++) {
            $tmp[$key] = $list[$key];
            $key = ($key + 1) % $max;
        }
        $keys = array_keys($tmp);
        $reversed = array_reverse(array_values($tmp));
        $new = array_combine($keys, $reversed);
        foreach ($new as $key => $value) {
            $list[$key] = $value;
        }
        $p = ($p + $length + $skip) % $max;
        $skip++;
    }
}

$blocks = [];
for ($i = 0; $i < 256; $i += 16) {
    $blocks[] = str_pad(
        dechex(combine(array_slice($list, $i, 16))),
        2,
        '0',
        STR_PAD_LEFT
    );
}

print implode('', $blocks);
