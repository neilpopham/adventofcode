<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(1);

$data = $input->lines()->raw();

$value = array_sum($data);

print $value . "\n";

$current = 0;
$previous = [0 => 1];
while (true) {
    foreach ($data as $value) {
        $current += $value;
        if (isset($previous["x{$current}"])) {
            print $current . "\n";
            exit;
        }
        $previous["x{$current}"] = 1;
    }
}
