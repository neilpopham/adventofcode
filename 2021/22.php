<?php

require('libs/core.php');

$data = load_data("22.txt");

foreach ($data as $key => $value) {
    if (preg_match('/^(on|off) x=([\-\d]+)\.\.([\-\d]+),y=([\-\d]+)\.\.([\-\d]+),z=([\-\d]+)\.\.([\-\d]+)$/', $value, $matches)) {
        $data[$key] = array_slice($matches, 1);
    }
}

function part1($data) {
    $cubes = [];

    foreach ($data as $instruction) {
        list($switch, $x1, $x2, $y1, $y2, $z1, $z2) = $instruction;
        for ($z = $z1; $z <= $z2; $z++) {
            if (($z < -50) || ($z > 50)) {
                continue;
            }
            if (!isset($cubes[$z])) {
                $cubes[$z] = [];
            }
            for ($y = $y1; $y <= $y2; $y++) {
                if (($y < -50) || ($y > 50)) {
                    continue;
                }
                if (!isset($cubes[$z][$y])) {
                    $cubes[$z][$y] = [];
                }
                for ($x = $x1; $x <= $x2; $x++) {
                    if (($x < -50) || ($x > 50)) {
                        continue;
                    }
                    $cubes[$z][$y][$x] = $switch == 'on' ? 1 : 0;
                }
            }
        }
    }

    $total = 0;
    foreach ($cubes as $z => $grid) {
        foreach ($grid as $y => $row) {
            $total += array_sum($row);
        }
    }
    return $total;
}

print part1($data);
print "\n";
