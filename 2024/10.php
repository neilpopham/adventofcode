<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(10);
$data = $input->lines()->raw();

$data = array_map(fn($row) => str_split($row), $data);

$queue = [];

$offsets = [[0, -1], [1, 0], [0, 1], [-1, 0]];

function check($item, $unique)
{
    global $offsets, $data, $queue, $done;
    list($x, $y, $value, $id) = $item;
    $found = 0;
    foreach ($offsets as $o => $offset) {
        $nx = $x + $offset[0];
        $ny = $y + $offset[1];

        if (!isset($data[$ny][$nx])) {
            continue;
        }

        if ($data[$ny][$nx] == $value + 1) {
            if ($data[$ny][$nx] == 9) {
                if ($unique) {
                    if (isset($done["$nx|$ny|$id"])) {
                        continue;
                    }
                    $done["$nx|$ny|$id"] = 1;
                }
                $found++;
            } else {
                $queue[] = [$nx, $ny, $value + 1, $id];
            }
        }
    }

    return $found;
}

function process($zeros, $unique)
{
    global $queue, $done;
    $queue = $zeros;
    $done = [];
    $total = 0;
    $item = array_pop($queue);
    while ($item !== null) {
        $total += check($item, $unique);
        $item = array_pop($queue);
    }

    return $total;
}

$id = 0;
$zeros = [];
foreach ($data as $y => $row) {
    foreach ($row as $x => $value) {
        if ($value == 0) {
            $zeros[] = [$x, $y, 0, $id++];
        }
    }
}

print process($zeros, true) . "\n";
print process($zeros, false) . "\n";
