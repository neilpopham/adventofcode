<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(6);

function get_unique($data, $len)
{
    $max = strlen($data) - $len;
    for ($i = 0; $i < $max; $i++) {
        $chars = count_chars(substr($data, $i, $len), 1);
        if (count($chars) == $len) {
            return $i + $len;
        }
    }
}

print get_unique($data, 4) . "\n";
print get_unique($data, 14) . "\n";
