<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(25);
$data = $input->raw();

$matches = preg_split('/\n\n/', $data);

$key = 0;
$lock = 0;
$keys = [];
$locks = [];

function get_lengths($grid)
{
    $lengths = array_fill(0, 6, 0);
    for ($y = 1; $y < 6; $y++) {
        for ($x = 0; $x < 5; $x++) {
            if ($grid[$y][$x] == '#') {
                $lengths[$x] = $y;
            }
        }
    }
    return $lengths;
}

foreach ($matches as $i => $data) {
    $data = explode("\n", $data);
    if ($data[0] == '#####') {
        $locks[$lock] = get_lengths($data);
        $lock++;
    } else {
        $keys[$key] = get_lengths(array_reverse($data));
        $key++;
    }
}

$total = 0;
foreach ($locks as $lock) {
    foreach ($keys as $key) {
        $valid = true;
        for ($c = 0; $c < 6; $c++) {
            if ($lock[$c] + $key[$c] >= 6) {
                $valid = false;
                break;
            }
        }
        if ($valid) {
            $total++;
        }
    }
}
print $total . "\n";
