<?php

require 'libs/aoc.php';

$input = new AdventOfCode\AdventOfCode()->input(6)->lines();

function dosum($sum, $operator)
{
    $operations = [
        'add' => fn(int $t, int $v): int => $t + $v,
        'mul' => fn(int $t, int $v): int => $t * $v,
    ];
    $start = $operator == '+' ? 0 : 1;
    $function = $operator == '+' ? 'add' : 'mul';
    return array_reduce($sum, $operations[$function], $start);
}

$data = array_map(
    fn ($x) => explode('|', preg_replace('/ +/', '|', trim($x))),
    $input->raw()
);

$sums = [];
foreach ($data as $c => $col) {
    foreach ($col as $r => $value) {
        $sums[$r][$c] = $value;
    }
}

$total = 0;
foreach ($sums as $sum) {
    $operator = array_pop($sum);
    $total += dosum($sum, $operator);
}
print $total . "\n";

$data = $input->raw();

$cols = [];
$operators = str_split(end($data));
foreach ($operators as $col => $value) {
    if ($value == ' ') {
        continue;
    }
    $cols[] = $col;
}
$max = 0;
foreach ($data as $line) {
    $max = max($max, strlen(substr($line, end($cols))));
}
$cols[] = count($operators) + $max;

$sums = [];
$operators = [];
$maxrow = count($data) - 1;
for ($c = 1; $c < count($cols); $c++) {
    $c1 = $cols[$c - 1];
    $c2 = $cols[$c];
    $number = [];
    foreach ($data as $row => $line) {
        if ($row == $maxrow) {
            $operators[] = $line[$c1];
            break;
        }
        for ($i = $c1; $i < $c2 - 1; $i++) {
            $number[$i] = ($number[$i] ?? '') . $line[$i];
        }
    }
    $sums[] = $number;
}

$total = 0;
foreach ($sums as $i => $sum) {
    $operator = $operators[$i];
    $total += dosum($sum, $operator);
}
print $total . "\n";
