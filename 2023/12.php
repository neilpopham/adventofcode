<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(12);
// $input = (new AdventOfCode())->example(12, 1);

$data = $input->lines()->regex('/(.+) ([\d,]+)/');

foreach ($data as $key => $line) {
    if (strpos($line[0], '?') === false) {
        unset($data[$key]);
        continue;
    }
    // print_r($line);

    $data[$key][0] = str_replace(['.', '#'], ['0', '1'], $line[0]);

    // $data[$key][2] = array_filter(explode('0', $data[$key][0]));
    $data[$key][1] = explode(',', $line[1]);
    // print_r($data[$key]);

    $chars = $data[$key][0];

    $length = strlen($chars);
    // $max = str_repeat('1', $length);
    // var_dump($max, bindec($max));
    $max = bindec(str_repeat('1', $length));
    // $bits = str_split($group);
    // print_r($bits);
    for ($n = 1; $n <= $max; $n++) {
        $option = str_pad(decbin($n), $length, '0', STR_PAD_LEFT);
        // print $x . "\n";
        for ($o = 0; $o < $length; $o++) {
            if ($chars[$o] == '1') {
                $option[$o] = '1';
            } elseif ($chars[$o] == '0') {
                $option[$o] = '0';
            }
        }
        $data[$key][2][$option] = $option;
    }
    $data[$key][2] = array_keys($data[$key][2]);

    $data[$key][3] = 0;
    foreach ($data[$key][2] as $option) {
        $parts = array_values(
            array_map(
                fn($v) => strlen($v),
                array_filter(explode('0', $option))
            )
        );
        // print_r($data[$key][1]);
        // print_r($parts);
        // print "\n";
        if ($parts == $data[$key][1]) {
            $data[$key][3]++;
            // var_dump('MATCH');
        }
        // sleep(1);
    }

    unset($data[$key][2]);

    // print_r($data[$key]);
    // exit;

    // var_dump($data[$key][4]);



    // foreach ($data[$key][2] as $i => $group) {
    //     if (strpos($group, '?') === false) {
    //         continue;
    //     }
    //     $data[$key][3] = [];
    //     $length = strlen($group);
    //     $max = str_repeat('1', $length);
    //     var_dump($max, bindec($max));
    //     $max = bindec(str_repeat('1', $length));
    //     $bits = str_split($group);
    //     print_r($bits);
    //     for ($n = 1; $n <= $max; $n++) {
    //         $option = str_pad(decbin($n), $length, '0', STR_PAD_LEFT);
    //         // print $x . "\n";
    //         for ($o = 0; $o < $length; $o++) {
    //             if ($group[$o] == '1') {
    //                 $option[$o] = '1';
    //             }
    //         }
    //         $data[$key][3][$option] = $option;
    //     }
    // }


    // for ($pos = 0; $pos < strlen($line[0]); $pos++) {
    //     // $line[0]
    // }

    // $counts = count_chars($line[0], 1);
    // print_r($counts);

    // $corrupt = $counts[63] ?? 0;

    // if (preg_match_all('/\?/', $line[0], $matches, PREG_OFFSET_CAPTURE)) {
    //     print_r($matches);

    //     foreach ($matches[0] as $match) {
    //         $pos = $match[1]
    //     }
    // }

    // for ($i = 0; $i < $corrupt; $i++) {
    //     // $line[0]
    // }
}

// print_r($data);

$total = array_reduce($data, fn($t, $v) => $t + $v[3], 0);
print $total . "\n";

// $total = 0;
// foreach ($data as $key => $value) {
//     $total += $value[4];
//     var_dump($value[4], $total);
// }
// print $total . "\n";
