<?php

require 'libs/aoc.php';

$input = new AdventOfCode\AdventOfCode()->input(10)->lines();

$data = $input->regex('/\[([\.#]+)\] (.+) {(.+)}/');

$data = array_map(
    function ($x) {
        preg_match_all('/\((.+?)\)/', $x[1], $matches);
        $buttons = array_map(fn($x) => explode(',', $x), $matches[1]);
        return [
            strlen($x[0]),
            bindec(str_replace(['.', '#'], ['0', '1'], $x[0])),
            $buttons,
            explode(',', $x[2])
        ];
    },
    $data
);

$data = array_map(
    function ($x) {
        foreach ($x[2] as $i => $buttons) {
            $bin = str_repeat('0', $x[0]);
            foreach ($buttons as $p) {
                $bin[$p] = '1';
            }
            $x[4][$i] = bindec($bin);
        }
        return $x;
    },
    $data
);

function toggle($sequence, $buttons, $complete)
{
    global $queue, $states;
    [$state, $route] = $sequence;
    foreach ($buttons as $b => $button) {
        $new = $state ^ $button;
        if ($new == $complete) {
            return array_merge($route, [$b]);
        } else {
            if (!isset($states[$new])) {
                $states[$new] = 1;
                $queue[] = [$new, array_merge($route, [$b])];
            }
        }
    }
    return false;
}

$states = [];
$total = 0;
foreach ($data as $d => [$count, $state, $a, $b, $buttons]) {
    $queue = [[0, []]];
    $states = [];
    do {
        $sequence = array_shift($queue);
        if ($route = toggle($sequence, $buttons, $state)) {
            $total += count($route);
            $sequence = null;
        }
    } while ($sequence !== null);
}
print $total . "\n";

function joltage($sequence, $buttons, $joltages)
{
    global $queue, $states;
    if (empty($sequence)) {
        return false;
    }
    foreach ($buttons as $b => $indexes) {
        [$values, $route] = $sequence;
        foreach ($indexes as $index) {
            $values[$index]++;
        }
        if ($values == $joltages) {
            return array_merge($route, [$b]);
        } else {
            $key = implode('|', $values);
            if (isset($states[$key])) {
                continue;
            }
            $continue = true;
            foreach ($values as $index => $value) {
                if ($value > $joltages[$index]) {
                    $continue = false;
                    break;
                }
            }
            if ($continue) {
                $states[$key] = 1;
                $queue[] = [$values, array_merge($route, [$b])];
            }
        }
    }
    return false;
}

$states = [];
$total = 0;
foreach ($data as $d => [$count, $a, $buttons, $joltages, $b]) {
    $queue = [[array_fill(0, $count, 0), []]];
    $states = [];
    do {
        $sequence = array_shift($queue);
        if ($route = joltage($sequence, $buttons, $joltages)) {
            $total += count($route);
            $sequence = null;
        }
    } while ($sequence !== null);
}
print $total . "\n";
