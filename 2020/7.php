<?php

require('libs/core.php');

function can_contain($bag, $bags) {
    if (array_key_exists("shiny gold", $bag)) {
        return true;
    }
    foreach (array_keys($bag) as $colour) {
        if (isset($bags[$colour]) && can_contain($bags[$colour], $bags) === true) {
            return true;
        }
    }
}

function total_bags($bag, $bags) {
    $t = 0;
    foreach($bag as $colour => $number) {
        if (isset($bags[$colour])) {
            $t += $number + ($number * total_bags($bags[$colour], $bags));
        }
    }
    return $t;
}

function check_1($bags) {
    $total = 0;
    foreach ($bags as $contains) {
        $can = can_contain($contains, $bags);
        if ($can) {
            $total++;
        }
    }
    print "{$total} matching\n";
}

function check_2($bags) {
    $total = total_bags($bags["shiny gold"], $bags);
    print "{$total} in total\n";
}

$data = load_data("7.txt");

$bags = [];
foreach ($data as $rule) {
    if (preg_match_all('/(?:(\d) )*(\w+ \w+) bags*/', $rule, $matches)) {
        print_r($matches);
        $bags[$matches[2][0]] = [];
        for ($i = 1; $i < count($matches[2]); $i++) {
            $bags[$matches[2][0]][$matches[2][$i]] = $matches[1][$i] ?: 0;
        }
    }
}

check_1($bags);

check_2($bags);







