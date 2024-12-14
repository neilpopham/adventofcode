<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(11);
$data = $input->raw();

$data = array_map(fn($v) => intval($v), explode(' ', $data));

function process($n, $step)
{
    if ($step == 0) {
        return 1;
    }
    global $cache;
    if (!isset($cache[$n][$step])) {
        $s = strval($n);
        if ($n == 0) {
            $result = process(1, $step - 1);
        } elseif (strlen($s) % 2 == 0) {
            $split = array_map(fn($v) => intval($v), str_split($s, strlen($s) / 2));
            $result = process($split[0], $step - 1) + process($split[1], $step - 1);
        } else {
            $result = process($n * 2024, $step - 1);
        }
        $cache[$n][$step] = $result;
    }
    return $cache[$n][$step];
}

function blink($data, $blinks)
{
    $cache = [];
    $total = 0;
    foreach ($data as $value) {
        $total += process($value, $blinks);
    }
    return $total;
}

print blink($data, 25) . "\n";
print blink($data, 75) . "\n";
