<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(1)->lines();

$fuel = 0;
foreach ($data as $mass) {
    $fuel += floor($mass / 3) - 2;
}
print "{$fuel}\n";

$fuel = 0;
foreach ($data as $mass) {
    $value = $mass;
    while ($value > 0) {
        $value = floor($value / 3) - 2;
        if ($value > 0) {
            $fuel += $value;
        }
    }
}
print "{$fuel}\n";
