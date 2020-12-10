<?php

require('libs/core.php');

function check_1($data) {
    $max = end($data);
    $data[] = $max + 3;
    $current = 0;
    $diffs = [0, 0, 0, 0];
    $chain = [];
    foreach($data as $i => $adapter) {
        $diff = $adapter - $current;
        if ($diff >= 1 and $diff <= 3) {
            $chain[] = $adapter;
            $diffs[$diff]++;
            $current = $adapter;
        }
    }
    $sum = $diffs[1] * $diffs[3];
    print "{$sum}\n";
}

function permutations($adapter, $data) {
    static $total = [];
    if (isset($total[$adapter])) {
        return $total[$adapter];
    }
    $key = array_search($adapter, $data);
    $i = $key + 1;
    if (!isset($data[$i])) {
        return 1;
    }
    $total[$adapter] = 0;
    while(isset($data[$i]) && (($data[$i] - $adapter) <= 3)) {
        $total[$adapter] += permutations($data[$i], $data);
        $i++;
    }
    return $total[$adapter];
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
