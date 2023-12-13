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
    if (preg_match_all('/\?/', $data[$key][0], $matches, PREG_OFFSET_CAPTURE)) {
        $options = [];
        $length = count($matches[0]);
        $max = pow(2, $length);
        for ($n = 0; $n < $max; $n++) {
            $binary = str_pad(decbin($n), $length, '0', STR_PAD_LEFT);
            $d = 0;
            $options[$n] = $data[$key][0];
            foreach ($matches[0] as $p) {
                $options[$n][$p[1]] = $binary[$d];
                $d++;
            }
        }
        $data[$key][2] = 0;
        foreach ($options as $option) {
            $parts = array_values(
                array_map(
                    fn($v) => strlen($v),
                    array_filter(explode('0', $option))
                )
            );
            if ($parts == $data[$key][1]) {
                $data[$key][2]++;
            }
        }
    }
}

$total = array_reduce($data, fn($t, $v) => $t + $v[2], 0);

print $total . "\n";
