<?php

require('libs/core.php');

$data = load_data("25.txt");

$east = [];
$south = [];

foreach ($data as $y => $value) {
    for ($x = 0; $x < strlen($value); $x++) {
        if ($value[$x] == '>') {
            $east[$y][$x] = 1;
        }
        if ($value[$x] == 'v') {
            $south[$y][$x] = 1;
        }
    }
}

function print_grid($east, $south, $data) {
    for ($y = 0; $y < count($data); $y++) {
        for ($x = 0; $x < strlen($data[0]); $x++) {
            if (isset($east[$y][$x])) {
                print ">";
            } elseif (isset($south[$y][$x])) {
                print "v";
            } else {
                print ".";
            }
        }
        print "\n";
    }
    print "\n";
}

function next_east($x, $data) {
    $x++;
    if ($x == strlen($data[0])) {
        $x = 0;
    }
    return $x;
}

function next_south($y, $data) {
    $y++;
    if ($y == count($data)) {
        $y = 0;
    }
    return $y;
}

print_grid($east, $south, $data);

$turn = 0;
do {
    $moved = false;
    $new_east = [];
    foreach ($east as $y => $row) {
        foreach (array_keys($row) as $x) {
            $nx = next_east($x, $data);
            if (!isset($east[$y][$nx]) && !isset($south[$y][$nx])) {
                $new_east[] = [$x, $y, $nx];
                $moved = true;
            }
        }
    }
    foreach ($new_east as $value) {
        list($x, $y, $nx) = $value;
        $east[$y][$nx] = 1;
        unset($east[$y][$x]);
    }
    $new_south = [];
    foreach ($south as $y => $row) {
        foreach (array_keys($row) as $x) {
            $ny = next_south($y, $data);
            if (!isset($east[$ny][$x]) && !isset($south[$ny][$x])) {
                $new_south[] = [$x, $y, $ny];
                $moved = true;
            }
        }
    }
    foreach ($new_south as $value) {
        list($x, $y, $ny) = $value;
        $south[$ny][$x] = 1;
        unset($south[$y][$x]);
    }
    $turn++;
} while ($moved);

print_grid($east, $south, $data);

print "{$turn} turns\n";
