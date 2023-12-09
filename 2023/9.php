<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(9);

$data = $input->lines()->raw();

$data = array_map(fn($v) => explode(' ', $v), $data);

function get_total($data, $reverse = false)
{
    $total = 0;
    foreach ($data as $s => $sequence) {
        if ($reverse) {
            $sequence = array_reverse($sequence);
        }
        $diffs = [$sequence];
        $d = 0;
        do {
            for ($i = 1; $i < count($diffs[$d]); $i++) {
                $diffs[$d + 1][] = $diffs[$d][$i] - $diffs[$d][$i - 1];
            }
            $d++;
            $zeros = array_filter($diffs[$d], fn($v) => $v === 0);
        } while (count($diffs[$d]) !== count($zeros));
        $diffs[$d][] = 0;
        for ($i = $d; $i > 0; $i--) {
            $value = end($diffs[$i - 1]) + end($diffs[$i]);
            $diffs[$i - 1][] = $value;
            if ($i == 1) {
                $total += $value;
            }
        }
    }
    return $total;
}

print get_total($data) . "\n";
print get_total($data, true) . "\n";
