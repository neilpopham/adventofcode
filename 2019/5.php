<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(5)->csv();

function process($data, $input)
{
    $input = [$input];
    $output = [];

    $i = 0;
    while ($i < count($data)) {
        $ins = str_pad($data[$i], 5, '0', STR_PAD_LEFT);
        $op = $ins % 100;

        $values = [
            isset($data[$i + 1]) ? ($ins[2] == 1 ? $data[$i + 1] : $data[$data[$i + 1]] ?? 0) : null,
            isset($data[$i + 2]) ? ($ins[1] == 1 ? $data[$i + 2] : $data[$data[$i + 2]] ?? 0) : null,
        ];

        switch ($op) {
            case 1:
                if ($ins[0] == 0) {
                    $data[$data[$i + 3]] = $values[0] + $values[1];
                }
                $i += 4;
                break;
            case 2:
                if ($ins[0] == 0) {
                    $data[$data[$i + 3]] = $values[0] * $values[1];
                }
                $i += 4;
                break;
            case 3:
                if ($ins[2] == 0) {
                    $data[$data[$i + 1]] = array_pop($input);
                }
                $i += 2;
                break;
            case 4:
                $output[] = $ins[2] == 0 ? $data[$data[$i + 1]] : $data[$i + 1];
                $i += 2;
                break;
            case 5:
                if ($values[0] != 0) {
                    $i = $values[1];
                } else {
                    $i += 3;
                }
                break;
            case 6:
                if ($values[0] == 0) {
                    $i = $values[1];
                } else {
                    $i += 3;
                }
                break;
            case 7:
                if ($ins[0] == 0) {
                    $data[$data[$i + 3]] = $values[0] < $values[1] ? 1 : 0;
                }
                $i += 4;
                break;
            case 8:
                if ($ins[0] == 0) {
                    $data[$data[$i + 3]] = $values[0] == $values[1] ? 1 : 0;
                }
                $i += 4;
                break;
            case 99:
                $i = PHP_INT_MAX;
                break;
        }
    }

    return end($output);
}

print process($data, 1) . "\n";
print process($data, 5) . "\n";
