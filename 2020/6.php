<?php

require('libs/core.php');

function get_groups($data) {
    $groups = [];
    $index = 0;
    foreach ($data as $i => $line) {
        if (empty(trim($line))) {
            $index++;
        } else {
            $groups[$index][] = $line;
        }
    }
    return $groups;
}

function check_1($data) {
    $total = 0;
    foreach ($data as $combined) {
        $combined = implode("", $combined);
        $total += strlen(count_chars($combined, 3));
    }
    print "{$total}\n";
}

function check_2($data) {
    $total = 0;
    foreach ($data as $group) {
        $shared = array_keys(count_chars($group[0], 1));
        foreach ($group as $answers) {
            $chars = array_keys(count_chars($answers, 1));
            $shared = array_intersect($shared, $chars);
        }
        $total += count($shared);
    }
    print "{$total}\n";
}

$data = load_data("6.txt");

$data = get_groups($data);

check_1($data);

check_2($data);
