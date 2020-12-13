<?php

require('libs/core.php');

function check_1($data) {
    list($arrival, $buses) = $data;
    $buses = array_filter(explode(",", $buses), function($n) { return $n != "x"; });
    $closest = [];
    $checking = true;
    $m = 1;
    while (count($closest) < count($buses)) {
        foreach ($buses as $bus) {
            if (isset($closest[$bus])) {
                continue;
            }
            $time = $m * $bus;
            if ($time >= $arrival) {
                $closest[$bus] = $time;
            }
        }
        $m++;
    }
    $min = PHP_INT_MAX;
    foreach($closest as $bus => $time) {
        if ($time - $arrival < $min) {
            $min = $time - $arrival;
            $number = $bus;
        }
    }
    print ($number * $min) . "\n";
}

function check_2($data) {
    list($arrival, $buses) = $data;
    $buses = explode(",", $buses);
    $numbers = [];
    foreach ($buses as $key => $value) {
        if ($value != "x") {
            $numbers[$key] = $value;
        }
    }
    asort($numbers);
    $count = count($numbers);
    $max_index = array_key_last($numbers);

    $biggies = array_slice($numbers, -4, 4, true);
    $big_offsets = array_keys($biggies);
    $big_numbers = array_values($biggies);
    $max = count($big_numbers) - 1;

    $i = 1;
    while (true) {
        $number = $i * $big_numbers[$max];
        $mod_total = 0;
        for ($n = 0; $n < $max; $n++) {
            $time = $number + $big_offsets[$n] - $big_offsets[$max];
            $mod_total += $time % $big_numbers[$n];
        }
        if ($mod_total == 0) {
            $start = $number;
            break;
        }
        $i++;
    }

    $step = 1;
    foreach ($big_numbers as $number) {
        $step *= $number;
    }

    while (true) {
        $found = 0;
        foreach($numbers as $offset => $bus) {
            $t = $start + $offset - $max_index;
            if ($t % $bus == 0) {
                $found++;
            } else {
                continue;
            }
        }
        if ($found == $count) {
            print ($start - $max_index) . "\n";
            return;
        }
        $start += $step;
    }
}

$data = load_data("13.txt");

check_1($data);

check_2($data);
