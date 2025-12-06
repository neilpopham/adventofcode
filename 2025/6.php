<?php

require 'libs/aoc.php';

$input = new AdventOfCode\AdventOfCode()->input(6);

$input->raw = rtrim($input->raw);
$input = $input->lines(false);

function dosum($sum, $operator)
{
    $operations = [
        'add' => fn($t, $v) => $t + $v,
        'mul' => fn($t, $v) => $t * $v,
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

$total = 0;
$max = strlen($data[0]) - 1;
$numbers = [];
for ($c = $max; $c >= 0; $c--) {
    $numbers[$c] = '';
    for ($r = 0; $r < count($data); $r++) {
        $value = $data[$r][$c] ?? ' ';
        if ($value == ' ') {
            continue;
        }
        if (in_array($value, ['+', '*'])) {
            $total += dosum($numbers, $value);
            $numbers = [];
            $c--;
        } else {
            $numbers[$c] .= $value;
        }
    }
}
print $total . "\n";
