<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(7);
$data = $input->lines()->regex('/(\d+): (.*)/');

foreach ($data as $i => $line) {
    $data[$i][1] = explode(' ', trim($line[1]));
}

function calculate($target, $start, $values, $operators)
{
    foreach ($operators as $j => $operator) {
        if ($operator == '0') {
            $start += $values[$j];
        } elseif ($operator == '1') {
            $start *= $values[$j];
        } else {
            $start = intval("{$start}{$values[$j]}");
        }
        if ($start > $target) {
            return false;
        }
    }
    return $start == $target;
}

function process($data, $base)
{
    $total = 0;
    foreach ($data as $i => $equation) {
        list($target, $values) = $equation;

        $numbers = count($values);
        $basemax = str_repeat($base - 1, $numbers - 1);
        $max = intval($basemax, $base);

        $start = array_shift($values);
        $values = array_values($values);

        for ($i = 0; $i <= $max; $i++) {
            $basepadded = str_pad(base_convert($i, 10, $base), $numbers - 1, '0', STR_PAD_LEFT);
            $operators = str_split($basepadded);
            $success = calculate($target, $start, $values, $operators);
            if ($success) {
                $total += $target;
                continue 2;
            }
        }
    }
    return $total;
}

print process($data, 2) . "\n";
print process($data, 3) . "\n";
