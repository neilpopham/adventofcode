<?php

require('libs/core.php');

function validate_1($passwords) {
    $total = 0;
    foreach ($passwords as $i => $line) {
        if (preg_match('/^(\d+)\-(\d+) (\w): (\w+)$/', $line, $matches)) {
            $count = substr_count($matches[4], $matches[3]);
            $valid = ($count >= $matches[1]) && ($count <= $matches[2]);
            if ($valid) {
                $total++;
            }
        }
    }
    print "\n{$total} are valid\n";
}

function validate_2($passwords) {
    $total = 0;
    foreach ($passwords as $i => $line) {
        if (preg_match('/^(\d+)\-(\d+) (\w): (\w+)$/', $line, $matches)) {
            $char1 = $matches[4][$matches[1] - 1];
            $char2 = $matches[4][$matches[2] - 1];
            $valid1 = $char1 == $matches[3];
            $valid2 = $char2 == $matches[3];
            $valid = ($valid1 xor $valid2);
            if ($valid) {
                $total++;
            }
        }
    }
    print "\n{$total} are valid\n";
}

$passwords = load_data("2.txt");

validate_1($passwords);

validate_2($passwords);
