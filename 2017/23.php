<?php

require 'libs/aoc.php';

$data = new AdventOfCode\AdventOfCode()->input(day: 23)
    ->lines()->regex('/(set|sub|mul|jnz) (\w+) ([-\w]+)/');

function register($v)
{
    global $register;
    return $register[$v] ?? 0;
}
function getvalue($v)
{
    global $register;
    return filter_var($v, FILTER_VALIDATE_INT) ? $v : $register[$v] ?? 0;
}

$total = 0;
$register = [];
$p = 0;
do {
    [$ins, $a, $b] = $data[$p];
    $dp = 1;
    switch ($ins) {
        case 'set':
            $register[$a] = getvalue($b);
            break;
        case 'sub':
            $register[$a] = register($a) - getvalue($b);
            break;
        case 'mul':
            $register[$a] = register($a) * getvalue($b);
            $total++;
            break;
        case 'jnz':
            if (getvalue($a) != 0) {
                $dp = getvalue($b);
            }
            break;
    }
    $p += $dp;
} while (isset($data[$p]));

print $total . "\n";

$register = array_combine(
    range('a', 'h'),
    array_fill(0, 8, 0)
);
$register['a'] = 1;
$p = 0;
do {
    [$ins, $a, $b] = $data[$p];
    $dp = 1;
    switch ($ins) {
        case 'set':
            $register[$a] = getvalue($b);
            break;
        case 'sub':
            $register[$a] = register($a) - getvalue($b);
            break;
        case 'mul':
            $register[$a] = register($a) * getvalue($b);
            break;
        case 'jnz':
            if (getvalue($a) != 0) {
                $dp = getvalue($b);
            }
            break;
    }
    $p += $dp;
    print implode(',', $register) . "\n";
} while (isset($data[$p]));
