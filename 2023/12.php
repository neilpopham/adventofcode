<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(12);

$data = $input->lines()->regex('/(.+) ([\d,]+)/');

foreach ($data as $key => $line) {
    if (strpos($line[0], '?') === false) {
        unset($data[$key]);
        continue;
    }
    $data[$key][0] = str_replace(['.', '#'], ['0', '1'], $line[0]);
    $data[$key][1] = explode(',', $line[1]);

    $chars = $data[$key][0];
    $length = strlen($chars);

    $zeros = bindec(str_replace('?', '1', $data[$key][0]));
    $ones = bindec(str_replace('?', '0', $data[$key][0]));
    $max = bindec(str_repeat('1', $length));
    $max &= $zeros;

    for ($n = 1; $n <= $max; $n++) {
        $decimal = $n;
        $decimal &= $zeros;
        $decimal |= $ones;
        $option = str_pad(decbin($decimal), $length, '0', STR_PAD_LEFT);
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
        if ($parts == $data[$key][1]) {
            $data[$key][3]++;
        }
    }

    unset($data[$key][2]);
}

$total = array_reduce($data, fn($t, $v) => $t + $v[3], 0);

print $total . "\n";
