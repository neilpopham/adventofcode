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
    $min = 999999;
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

    $big = array_slice($numbers, -4, 4, true);
    $lo = array_keys($big);
    $ln = array_values($big);
    $m = count($ln) - 1;
    $i = 1;
    while (true) {
        $n = $i * $ln[$m];
        $t = [];
        $u = [];
        $z = 0;
        for ($j = 0; $j < $m; $j++) {
            $t[$j] = $n + $lo[$j] - $lo[$m];
            $u[$j] = $t[$j] % $ln[$j];
            $z += $u[$j];
        }
        if ($z == 0) {
            $start = $n;
            break;
        }
        $i++;
    }

    $step = 1;
    foreach ($ln as $n) {
        $step *= $n;
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
