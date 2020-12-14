<?php

require('libs/core.php');

function check_1($data) {
    $memory = [];
    $mask = [];
    foreach ($data as $i => $line) {
        if (preg_match('/^mask = (.+)$/', $line, $matches)) {
            $mask = array_filter(str_split($matches[1]), function($v) { return $v != "X"; });
        } elseif (preg_match('/^mem\[(\d+)\] = (\d+)$/', $line, $matches)) {
            list(, $address, $number) = $matches;
            $binary = str_pad(decbin($number), 36, "0", STR_PAD_LEFT);
            foreach ($mask as $bit => $value) {
                $binary[$bit] = $value;

            }
            $memory[$address] = bindec($binary);
        }
    }
    $sum = 0;
    foreach ($memory as $address => $value) {
        $sum += $value;
    }
    print "{$sum}\n";
}

$data = load_data("14.txt");

check_1($data);
