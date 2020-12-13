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
    $max = end($numbers);
    $min = reset($numbers);
    $count = count($numbers);

    $start = $min; // 1068781; // $min;
    //$start = floor(100000000000000/$min) * $min;

    $ts = microtime(true);
    while (true) {
        $found = 0;
        foreach($numbers as $offset => $bus) {
            if (($start + $offset) % $bus == 0) {
                $found++;
            } else {
                continue;
            }
        }
        if ($found == $count) {
            $te = microtime(true);
            print "{$start}\n";
            print "Timer " . ($te - $ts) . "\n";
            break;
        }
        $start += $min;
    }
}

function check_3($data) {
    list($arrival, $buses) = $data;
    $buses = explode(",", $buses);
    $numbers = [];
    foreach ($buses as $key => $value) {
        if ($value != "x") {
            $numbers[$key] = $value;
        }
    }
    asort($numbers);
    $max = end($numbers);
    $min = reset($numbers);
    $count = count($numbers);

    foreach ($numbers as $bus) {
        $next[$bus] = $bus;
    }

    $start = $min; // 1068781; // $min;

    //$start = floor(100000000000000/$min) * $min;

    $ts = microtime(true);
    while (true) {
        //print "{$start}\n100000000000000\n";
        /*
                     100000000000000
        if ($start > 10687810) {
            foreach ($numbers as $i => $bus) {
                print "{$i}: {$bus} next {$next[$bus]}\n";
            }
            exit;
        }
        */
        $found = 0;
        foreach($numbers as $offset => $bus) {
            $goal = $start + $offset;
            if ($next[$bus] < $goal) {
                $next[$bus] += $bus;
            }
            if ($next[$bus] == $goal) {
                $found++;
            } else {
                continue;
            }
        }

        if ($found == $count) {
            $te = microtime(true);
            print_r($next);
            print "Timer " . ($te - $ts) . "\n";
            break;
        }
        $start += $min;
    }
}

function check_4($data) {
    list($arrival, $buses) = $data;
    $buses = explode(",", $buses);
    $numbers = [];
    foreach ($buses as $key => $value) {
        if ($value != "x") {
            $numbers[$key] = $value;
        }
    }
    asort($numbers);
    $max = end($numbers);
    $min = reset($numbers);
    $count = count($numbers);
    $max_index = array_search($max, $numbers);
    $start = $max;
    $ts = microtime(true);
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
            $te = microtime(true);
            print ($start - $max_index) . "\n";
            print "Timer " . ($te - $ts) . "\n";
            return;
        }
        $start += $max;
    }
}

function check_5($data) {
    list($arrival, $buses) = $data;
    $buses = explode(",", $buses);
    $numbers = [];
    foreach ($buses as $key => $value) {
        if ($value != "x") {
            $numbers[$key] = $value;
        }
    }
    asort($numbers);
    $max = end($numbers);
    $min = reset($numbers);
    $count = count($numbers);
    $max_index = array_search($max, $numbers);

    $big = array_slice($numbers, -2, 2, true);
    $offsets = array_keys($big);
    $step = $big[$offsets[0]] * $big[$offsets[1]];

    $start = $big[$offsets[1]];
    $i = 1;
    while ($i < $big[$offsets[0]]) {
        $n = $i * $big[$offsets[1]];
        $t = $n + $offsets[0] - $offsets[1];
        $m = $t % $big[$offsets[0]];
        //print "n is {$n} . t is {$t} m is {$m} \n";
        if ($m == 0) {
            $start = $n;
            break;
        }
        $i++;
    }

    //exit("start is {$start} step is {$step} \n");

    //$step = $max;
    //$start = 649; $max; // 649; // $step;

    $ts = microtime(true);
    while (true) {
        $found = [];
        foreach($numbers as $offset => $bus) {
            $t = $start + $offset - $max_index;
            if ($t % $bus == 0) {
                $found[$bus] = true;
            }
        }

        if (isset($found[401]) && isset($found[571])) {
            print "{$start}\n100000000000000\n";
        }

        if (count($found) == $count) {
            $te = microtime(true);
            print ($start - $max_index) . "\n";
            print "Timer " . ($te - $ts) . "\n";
            return;
        }
        $start += $step;
    }
}

function check_6($data) {
    list($arrival, $buses) = $data;
    $buses = explode(",", $buses);
    $numbers = [];
    foreach ($buses as $key => $value) {
        if ($value != "x") {
            $numbers[$key] = $value;
        }
    }
    asort($numbers);
    $max = end($numbers);
    $min = reset($numbers);
    $count = count($numbers);
    $max_index = array_search($max, $numbers);

    $big = array_slice($numbers, -2, 2, true);
    $offsets = array_keys($big);
    $step = $big[$offsets[0]] * $big[$offsets[1]];

    $start = $big[$offsets[1]];
    $i = 1;
    while ($i < $big[$offsets[0]]) {
        $n = $i * $big[$offsets[1]];
        $t = $n + $offsets[0] - $offsets[1];
        $m = $t % $big[$offsets[0]];
        if ($m == 0) {
            $start = $n;
            break;
        }
        $i++;
    }

    $ts = microtime(true);
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
            $te = microtime(true);
            print ($start - $max_index) . "\n";
            print "Timer " . ($te - $ts) . "\n";
            return;
        }
        $start += $step;
    }
}


function check_7($data) {
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

$data = load_data("_13.txt");

check_1($data);

check_2($data);
check_3($data);
check_4($data);
check_5($data);
check_6($data);

check_7($data);