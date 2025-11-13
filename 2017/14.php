<?php

require 'libs/aoc.php';

use AdventOfCode\Set as Set;

$data = new AdventOfCode\AdventOfCode()->input(day: 14)->raw();

function combine($bits)
{
    return array_reduce($bits, fn($t, $v) => $t ^= $v, 0);
}

function knothash($data)
{
    $lengths = array_map(fn($v) => ord($v), str_split($data));
    $lengths = array_merge($lengths, [17, 31, 73, 47, 23]);
    $list = range(0, 255);
    $p = 0;
    $skip = 0;
    $max = count($list);

    for ($t = 0; $t < 64; $t++) {
        foreach ($lengths as $length) {
            $tmp = [];
            $key = $p;
            for ($i = 0; $i < $length; $i++) {
                $tmp[$key] = $list[$key];
                $key = ($key + 1) % $max;
            }
            $keys = array_keys($tmp);
            $reversed = array_reverse(array_values($tmp));
            $new = array_combine($keys, $reversed);
            foreach ($new as $key => $value) {
                $list[$key] = $value;
            }
            $p = ($p + $length + $skip) % $max;
            $skip++;
        }
    }

    $blocks = [];
    for ($i = 0; $i < 256; $i += 16) {
        $blocks[] = str_pad(
            dechex(combine(array_slice($list, $i, 16))),
            2,
            '0',
            STR_PAD_LEFT
        );
    }
    return implode('', $blocks);
}

$rows = [];
$total = 0;
for ($i = 0; $i < 128; $i++) {
    $input = "{$data}-{$i}";
    $hash = knothash($input);
    $bits = array_map(
        fn ($v) => str_pad(base_convert($v, 16, 2), 4, '0', STR_PAD_LEFT),
        str_split($hash)
    );
    $row = implode('', $bits);
    $rows[] = $row;
    $total += strlen(str_replace('0', '', $row));
}

print $total . "\n";

function uuid($x, $y)
{
    return str_pad($x, 3, '0', STR_PAD_LEFT) . str_pad($y, 3, '0', STR_PAD_LEFT);
}

$groups = 0;
$offsets = [[0, -1], [1, 0], [0, 1], [-1, 0]];
$used = new Set();
foreach ($rows as $y => $row) {
    for ($x = 0; $x < 128; $x++) {
        $bit = $row[$x];
        if ($bit == 0) {
            continue;
        }
        if ($used->has(uuid($x, $y))) {
            continue;
        }
        $groups++;
        $queue = [[$x, $y]];
        do {
            [$cx, $cy] = array_pop($queue);
            $used->add(uuid($cx, $cy));
            foreach ($offsets as $offset) {
                $nx = $cx + $offset[0];
                if  ($nx < 0 || $nx > 127) {
                    continue;
                }
                $ny = $cy + $offset[1];
                if  ($ny < 0 || $ny > 127) {
                    continue;
                }
                $key = uuid($nx, $ny);
                $bit = $rows[$ny][$nx];
                if ($bit == 1) {
                    if (false === $used->has($key)) {
                        $queue[] = [$nx, $ny];
                    }
                }
            }
        } while (count($queue));
    }
}

print $groups . "\n";
