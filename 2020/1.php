<?php

require('libs/core.php');

function find_2($numbers) {
    foreach ($numbers as $l1 => $n1) {
        foreach ($numbers as  $l2 => $n2) {
            if (($n1 + $n2 == 2020) && ($l1 != $l2)) {
                print "{$n1} + {$n2} = 2020. {$n1} x {$n2} = ";
                print $n1 * $n2;
                print "\n";
                return;
            }
        }
    }
}

function find_3($numbers) {
    foreach ($numbers as $l1 => $n1) {
        foreach ($numbers as  $l2 => $n2) {
            foreach ($numbers as  $l3 => $n3) {
                if (($n1 + $n2 + $n3 == 2020) && ($l1 != $l2) && ($l1 != $l3) && ($l2 != $l3)) {
                    print "{$n1} + {$n2} + {$n3} = 2020. {$n1} x {$n2} x {$n3} = ";
                    print $n1 * $n2 * $n3;
                    print "\n";
                    return;
                }
            }
        }
    }
}

$numbers = load_data("1.txt");

find_2($numbers);

find_3($numbers);
