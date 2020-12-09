<?php

require('libs/core.php');

function check_1($numbers, $max) {
    $array = array_slice($numbers, 0, $max);
    $i = $max;
    while ($i < count($numbers)) {
        $found = false;
        foreach ($array as $l1 => $n1) {
            foreach ($array as $l2 => $n2) {
                if (($n1 + $n2 == $numbers[$i]) && ($l1 != $l2)) {
                    $array[] = $numbers[$i];
                    $array = array_slice($array, 1);
                    $found = true;
                    break 2;
                }
            }
        }
        if (!$found) {
            print("Could not find {$numbers[$i]}\n");
            return $numbers[$i];
        }
        $i++;
    }
}

function check_2($numbers, $invalid) {
    for ($i=1; $i < count($numbers); $i++) {
        $array = [];
        for ($j = $i; $j > 0; $j--) {
            $array[] = $numbers[$j];
            $sum = array_sum($array);
            if ($sum == $invalid) {
                sort($array);
                $max = end($array);
                $min = reset($array);
                print "Sum is " . ($min + $max) . "\n";
                return;
            }
            if ($sum > $invalid) {
                break;
            }
        }
    }
}

$numbers = load_data("9.txt");

$invalid = check_1($numbers, 25);

check_2($numbers, $invalid);


