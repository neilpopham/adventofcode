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

function check_2($data) {
    $memory = [];
    $mask = [];
    foreach ($data as $i => $line) {
        if (preg_match('/^mask = (.+)$/', $line, $matches)) {
            $mask = str_split($matches[1]);
        } elseif (preg_match('/^mem\[(\d+)\] = (\d+)$/', $line, $matches)) {
            list(, $address, $number) = $matches;
            $binary = str_pad(decbin($address), 36, "0", STR_PAD_LEFT);
            foreach ($mask as $bit => $value) {
                if ($value != "0") {
                    $binary[$bit] = $value;
                }
            }
            $addresses = [""];
            for ($i = 0; $i < 36; $i++) {
                $count = count($addresses);
                if ($binary[$i] == "X") {
                    for ($a = 0; $a < $count; $a++) {
                        $addresses[] = $addresses[$a] . '0';
                        $addresses[$a] .= '1';
                    }
                } else {
                    for ($a = 0; $a < $count; $a++) {
                        $addresses[$a] .= $binary[$i];
                    }
                }
            }
            foreach ($addresses as $binary) {
                $memory[bindec($binary)] = $number;
            }
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

check_2($data);
