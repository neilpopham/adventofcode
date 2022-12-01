<?php

require('libs/core.php');

$data = load_data("_23.txt");

for ($i = 0; $i < count($data); $i++) {
    $walls[] = array_fill(0, strlen($data[0]), 1);
}

foreach ($data as $y => $value) {
    for ($x = 0; $x < strlen($value); $x++) {
        if (preg_match('/^(A|B|C|D)$/', $value[$x], $matches)) {
            $walls[$y][$x] = 0;
            $amphipod[] = [$x, $y, $matches[1], 0];
        }
        if ($value[$x] == '.') {
            $walls[$y][$x] = 0;
        }
    }
}

foreach (range('A', 'D') as $char) {
    $meta[$char] = [
        'cost' => pow(10, ord($char) - 65)
    ];
    for ($y = 2; $y <= 3; $y++) {
        $meta[$char]['targets'][] = [ord($char) - 62, $y];
    }
}

foreach ($walls as $key => $value) {
    print implode('', $value) . "\n";
}
print "\n";

print_r($amphipod);
print_r($meta);

/*
Need to start with one on top row
Possibly look for one where bottom row is correct
If there is an empty target fill it
Is amp blocked (in row 3 with another in row 2)
Can only stay where it is if it's not blocking the wrong type
*/

function get_available() {
    foreach ($walls as $y => $row) {
        foreach ($row as $x => $available) {
            # code...
        }
    }
}

function is_situated($x, $y, $type) {
    global $meta;
    $targets = $meta[$type]['targets'];
    foreach ($targets as $target) {
        if ($target[0] == $x && $target[y] == $x) {
            return true;
        }
    }
    return false;
}

$queue = [];
foreach ($amphipod as $a => $info) {
    list($ax, $ay, $type, $situated) = $info;
    if (!$situated && $ay == 3) {
        $queue[] = $a;
    }
}

print_r($queue);

$a = array_shift($queue);
list($ax, $ay, $type, $situated) = $amphipod[$a];
$move = false;
$targets = $meta[$type]['targets'];
foreach ($targets as $target) {
    list($tx, $ty) = $target;
    if ($walls[$ty][$tx] == 0) {
        $move = $target;
    }
}
if (false === $move) {

}
