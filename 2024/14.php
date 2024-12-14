<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(14);
$data = $input->lines()->regex('/p=(\-?\d+),(\-?\d+) v=(\-?\d+),(\-?\d+)/');

$width = 101;
$height = 103;

$mx = ($width - 1) / 2;
$my = ($height - 1) / 2;

function part_1($data)
{
    global $width, $height, $mx, $my;
    $length = count($data);
    for ($t = 0; $t < 100; $t++) {
        for ($i = 0; $i < $length; $i++) {
            $data[$i][0] = ($data[$i][0] + $data[$i][2] + $width) % $width;
            $data[$i][1] = ($data[$i][1] + $data[$i][3] + $height) % $height;
        }
    }
    $quadrant = ['00' => 0, '10' => 0, '01' => 0, '11' => 0];
    foreach ($data as $robot) {
        if ($robot[0] == $mx || $robot[1] == $my) {
            continue;
        }
        $qx = $robot[0] < $mx ? 0 : 1;
        $qy = $robot[1] < $my ? 0 : 1;
        $quadrant["{$qx}{$qy}"]++;
    }
    return array_product($quadrant);
}

function part_2($data)
{
    global $width, $height;
    $length = count($data);
    $t = 1;
    while (true) {
        $grid = [];

        for ($i = 0; $i < $length; $i++) {
            $data[$i][0] = ($data[$i][0] + $data[$i][2] + $width) % $width;
            $data[$i][1] = ($data[$i][1] + $data[$i][3] + $height) % $height;
            $grid[$data[$i][1]][$data[$i][0]] = 1;
        }

        $sum = array_reduce($grid, fn($t, $v) => $t += array_sum($v));
        $valid = $sum == $length;
        if ($valid) {
            return $t;
        }

        $t += 1;
    }
}

print part_1($data) . "\n";
print part_2($data) . "\n";
