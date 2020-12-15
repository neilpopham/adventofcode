<?php

function check($data, $max) {
    $numbers = [];
    $list = explode(",", $data);
    $i = count($list) + 1;
    $last = array_pop($list);
    foreach($list as $j => $number) {
        $numbers[$number] = [$j + 1];
    }
    while ($i <= $max) {
        if (isset($numbers[$last])) {
            $number = ($numbers[$last][1] ?? $i) - $numbers[$last][0];
        } else {
            $number = 0;
            $numbers[$last] = [$i - 1];
        }
        if (isset($numbers[$number])) {
            $numbers[$number] = [end($numbers[$number]), $i];
        }
        $last = $number;
        $i++;
    }
    print "{$number}\n";
}

$data = "1,0,15,2,10,13";

check($data, 2020);

check($data, 30000000);
