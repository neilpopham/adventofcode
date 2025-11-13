<?php

require 'libs/aoc.php';

$data = new AdventOfCode\AdventOfCode()->input(day: 18)
    ->lines()->regex('/(snd|set|add|mul|mod|rcv|jgz) (\w+)(?: ([-\w]+))*/');

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

$register = ['snd' => null];
$p = 0;
do {
    [$ins, $a] = $data[$p];
    $dp = 1;
    switch ($ins) {
        case 'snd':
            $register['snd'] = getvalue($a);
            break;
        case 'set':
            $b = $data[$p][2];
            $register[$a] = getvalue($b);
            break;
        case 'add':
            $b = $data[$p][2];
            $register[$a] = register($a) + getvalue($b);
            break;
        case 'mul':
            $b = $data[$p][2];
            $register[$a] = register($a) * getvalue($b);
            break;
        case 'mod':
            $b = $data[$p][2];
            $register[$a] = register($a) % getvalue($b);
            break;
        case 'rcv':
            if (getvalue($a) > 0) {
                $dp = count($data) + 1;
            }
            break;
        case 'jgz':
            $b = $data[$p][2];
            if (getvalue($a) > 0) {
                $dp = getvalue($b);
            }
            break;
    }
    $p += $dp;
} while (isset($data[$p]));

print $register['snd'] . "\n";

function getvalue2($i, $v)
{
    global $register;
    return filter_var($v, FILTER_VALIDATE_INT) ? $v : $register[$i][$v] ?? 0;
}


$register = [
    ['p' => 0, 'queue' => []],
    ['p' => 1, 'queue' => []],
];

$total = 0;
$p = [0, 0];
do {
    $lock = true;
    for ($i = 0; $i < 2; $i++) {
        $rp = $p[$i];
        [$ins, $a] = $data[$rp];
        $dp = 1;
        switch ($ins) {
            case 'snd':
                if ($i == 1) {
                    $total++;
                }
                $register[$i ^ 1]['queue'][] = getvalue2($i, $a);
                break;
            case 'set':
                $b = $data[$rp][2];
                $register[$i][$a] = getvalue2($i, $b);
                break;
            case 'add':
                $b = $data[$rp][2];
                $register[$i][$a] = ($register[$i][$a] ?? 0) + getvalue2($i, $b); // getvalue2 now needs $i
                break;
            case 'mul':
                $b = $data[$rp][2];
                $register[$i][$a] = ($register[$i][$a] ?? 0) * getvalue2($i, $b);
                break;
            case 'mod':
                $b = $data[$rp][2];
                $register[$i][$a] = ($register[$i][$a] ?? 0) % getvalue2($i, $b);
                break;
            case 'rcv':
                if (count($register[$i]['queue']) == 0) {
                    $dp = 0;
                } else {
                    $register[$i][$a] = array_shift($register[$i]['queue']);
                }
                break;
            case 'jgz':
                $b = $data[$rp][2];
                if (getvalue2($i, $a) > 0) {
                    $dp = getvalue2($i, $b);
                }
                break;
        }
        $lock = $lock && ($dp == 0);
        $p[$i] += $dp;
    }
} while ($lock === false);

print $total . "\n";