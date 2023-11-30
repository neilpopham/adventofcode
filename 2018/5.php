<?php

require 'libs/api.php';

$data = (new AdventOfCode())->input(5)->raw();

function part1($data)
{
    $i = 0;
    $max = strlen($data) - 1;

    while ($i < $max) {
        $i++;

        $a = min(ord($data[$i - 1]), ord($data[$i]));
        $b = max(ord($data[$i - 1]), ord($data[$i]));

        if ($b - $a == 32) {
            $data = substr($data, 0, $i - 1) . substr($data, $i + 1);
            $i = max($i - 2, 0);
            $max = strlen($data) - 1;
        }
    }
    return strlen($data);
}


print part1($data) . "\n";

$lengths = [];
foreach (range('a', 'z') as $char) {
    $lengths[$char] = part1(preg_replace("/{$char}/i", '', $data));
}

asort($lengths);

print reset($lengths) . "\n";
