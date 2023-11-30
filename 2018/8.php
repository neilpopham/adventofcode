<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(8);

$data = $input->raw();

$data = explode(' ', $data);

function part1()
{
    global $data, $index;

    $children = $data[$index++];
    $metas = $data[$index++];
    $sum = 0;

    for ($c = 0; $c < $children; $c++) {
        $sum += part1();
    }

    for ($m = 0; $m < $metas; $m++) {
        $sum += $data[$index++];
    }

    return $sum;
}

$index = 0;
$total = part1();

print $total . "\n";

function part2()
{
    global $data, $index;

    $children = $data[$index++];
    $metas = $data[$index++];
    $sum = 0;
    $values = [];

    for ($c = 0; $c < $children; $c++) {
        $values[$c] = part2();
    }

    for ($m = 0; $m < $metas; $m++) {
        $meta = $data[$index++];
        if ($children) {
            $sum += $values[$meta - 1] ?? 0;
        } else {
            $sum += $meta;
        }
    }
    return $sum;
}

$index = 0;
$total = part2();

print $total . "\n";
