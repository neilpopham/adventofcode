<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(5)->lines(false);

$info = [];
$index = 0;
foreach ($data as $line) {
    if (empty($line)) {
        $index++;
    } else {
        $info[$index][] = $line;
    }
}

$stacks = [];
$raw = [];
$indexes = str_split(str_replace(' ', '', array_pop($info[0])));

for ($i = count($info[0]) - 1; $i >= 0; $i--) {
    $raw = str_split($info[0][$i], 4);
    foreach ($raw as $key => $value) {
        if (preg_match('/\[(\w)\]/', $raw[$key], $matches)) {
            $stacks[$indexes[$key]][] = $matches[1];
        }
    }
}

ksort($stacks);

$moves = [];
foreach ($info[1] as $key => $value) {
    if (preg_match('/move (\d+) from (\d+) to (\d+)/', $value, $matches)) {
        $moves[] = array_slice($matches, 1);
    }
}

function part_1($stacks, $moves)
{
    foreach ($moves as $move) {
        list($num, $s, $e) = $move;
        for ($m = 0; $m < $num; $m++) {
            $crate = array_pop($stacks[$s]);
            $stacks[$e][] = $crate;
        }
    }

    $result = '';
    foreach ($stacks as $key => $value) {
        $result .= end($value);
    }
    print "{$result}\n";
}

function part_2($stacks, $moves)
{
    $stacks = array_map(fn($v) => implode('', $v), $stacks);
    foreach ($moves as $move) {
        list($num, $s, $e) = $move;
        $pack = substr($stacks[$s], -$num);
        $stacks[$s] = substr($stacks[$s], 0, strlen($stacks[$s]) - $num);
        $stacks[$e] .= $pack;
    }

    $result = '';
    foreach ($stacks as $key => $value) {
        $result .= substr($value, -1);
    }
    print "{$result}\n";
}

part_1($stacks, $moves);
part_2($stacks, $moves);
