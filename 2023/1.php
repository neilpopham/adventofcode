<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(1);

$data = $input->lines()->raw();

$total = 0;
foreach ($data as $line) {
    $line = preg_replace('/[a-z]/', '', $line);
    $number = $line[0] . $line[-1];
    $total += (int) $number;
}
print $total . "\n";

$search = [
    '/(o)(n)(e)/',
    '/(t)(w)(o)/',
    '/(t)(hre)(e)/',
    '/(f)(ou)(r)/',
    '/(f)(iv)(e)/',
    '/(s)(i)(x)/',
    '/(s)(eve)(n)/',
    '/(e)(igh)(t)/',
    '/(n)(in)(e)/'
];
$replace = array_map(
    fn($n) => '${1}' . ($n + 1) . '${3}',
    array_keys($search)
);
$search[] = '/[a-z]/';
$replace[] = '';
$total = 0;
foreach ($data as $line) {
    $line = preg_replace($search, $replace, $line);
    $number = $line[0] . $line[-1];
    $total += (int) $number;
}
print $total . "\n";
