<?php

require('libs/core.php');

function check_1($data) {
    $max = end($data);
    $data[] = $max + 3;
    $current = 0;
    $diffs = [0, 0, 0, 0];
    foreach($data as $i => $adapter) {
        $diff = $adapter - $current;
        if ($diff >= 1 and $diff <= 3) {
            $diffs[$diff]++;
            $current = $adapter;
        }
    }
    $sum = $diffs[1] * $diffs[3];
    print "{$sum}\n";
}

function permutations($key, $data) {
    static $total = [];
    if (isset($total[$key])) {
        return $total[$key];
    }
    $i = $key + 1;
    if (!isset($data[$i])) {
        return 1;
    }
    $total[$key] = 0;
    while(isset($data[$i]) && (($data[$i] - $data[$key]) <= 3)) {
        $total[$key] += permutations($i, $data);
        $i++;
    }
    return $total[$key];
}

function check_2($data) {
    $max = end($data);
    $data = array_merge([0], $data, [$max + 3]);
    print permutations(0, $data) . "\n";
}

$data = load_data("10.txt");

sort($data);

check_1($data);

check_2($data);
