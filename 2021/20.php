<?php

require('libs/core.php');

$data = load_data("20.txt");

$algo = array_shift($data);
$data = array_values(array_filter($data));

function get_default($turn, $algo) {
    return ($turn % 2 == 0) ? $algo[0] : '.';
}

function process_pixel($x, $y, $data, $default) {
    $pixels = '';
    for ($oy = -1; $oy <= 1; $oy++) {
        for ($ox = -1; $ox <= 1; $ox++) {
            $value = $data[$y + $oy][$x + $ox] ?? $default;
            $pixels .= ($value == '#' ? '1' : '0');
        }
    }
    return bindec($pixels);
}

function process_image($data, $algo, $default) {
    $data = array_map(fn($x) => "{$default}{$x}{$default}", $data);
    $blank = str_repeat($default, strlen(end($data)));
    array_unshift($data, $blank);
    array_push($data, $blank);
    $processed = [];
    for ($y = 0; $y < count($data); $y++) {
        $processed[$y] = '';
        for ($x = 0; $x < strlen($data[$y]); $x++) {
            $index = process_pixel($x, $y, $data, $default);
            $processed[$y][$x] = $algo[$index];
        }
    }
    return $processed;
}

function parts($data, $algo, $turns) {
    for ($turn = 1; $turn <= $turns; $turn++) {
        $default = get_default($turn, $algo);
        $data = process_image($data, $algo, $default);
    }
    $total = 0;
    foreach ($data as $y => $row) {
        $total += substr_count($row, '#');
    }
    print "total: {$total}\n";
}

parts($data, $algo, 2);
parts($data, $algo, 50);
