<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(3);

$data = $input->lines()->raw();

$numbers = [];
$symbols = [];
foreach ($data as $y => $row) {
    if (preg_match_all('/\d+/', $row, $matches, PREG_OFFSET_CAPTURE)) {
        foreach ($matches[0] as $match) {
            list($number, $x) = $match;
            $numbers[$y][$x] = $number;
        }
    }
    if (preg_match_all('/[^\d\.]+/', $row, $matches, PREG_OFFSET_CAPTURE)) {
        foreach ($matches[0] as $match) {
            list($symbol, $x) = $match;
            $symbols["{$y}|{$x}"] = $symbol;
        }
    }
}

$total = 0;
foreach ($numbers as $y => $row) {
    foreach ($row as $x => $number) {
        $valid = false;
        for ($i = 0; $i < strlen($number); $i++) {
            for ($dy = -1; $dy <= 1; $dy++) {
                for ($dx = -1; $dx <= 1; $dx++) {
                    $cy = $y + $dy;
                    $cx = $x + $i + $dx;
                    $id = "{$cy}|{$cx}";
                    if (isset($symbols[$id])) {
                        $valid = true;
                        if ($symbols[$id] == '*') {
                            $gears[$id][] = $number;
                        }
                        break 3;
                    }
                }
            }
        }
        if ($valid) {
            $total += $number;
        }
    }
}
print $total . "\n";

$total = 0;
foreach ($gears as $numbers) {
    if (count($numbers) != 2) {
        continue;
    }
    $total += array_product($numbers);
}
print $total . "\n";
