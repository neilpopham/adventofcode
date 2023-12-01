<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(1);

$data = $input->lines()->raw();

$total = 0;
foreach ($data as $line) {
    $line = preg_replace('/[a-z]/', '', $line);
    $number = $line[0] . $line[-1];
    $total += $number;
}
print $total . "\n";

$total = 0;
foreach ($data as $line) {
    $numbers = [
        null,
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
    $search = [];
    $replace = [];
    for ($n = 1; $n < count($numbers); $n++) {
        $search[] = $numbers[$n];
        $replace[] = '${1}' . $n . '${3}';
    }
    $search[] = '/[a-z]/';
    $replace[] = '';
    $line = preg_replace($search, $replace, $line);
    $number = $line[0] . $line[-1];
    $total += $number;
}
print $total . "\n";
