<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(8);
$data = $input->lines()->raw();

$data = array_map(fn($row) => str_split($row), $data);

$transmitters = [];
foreach ($data as $y => $row) {
    foreach ($row as $x => $value) {
        if ($value != '.') {
            $transmitters[$value][] = [$x, $y];
        }
    }
}

function find_antinodes($data, $transmitters, $iterate)
{
    $antinodes = [];
    foreach ($transmitters as $char => $coords) {
        foreach ($coords as $i => $source) {
            foreach ($coords as $j => $c) {
                if ($i == $j) {
                    continue;
                }

                $nx = $c[0];
                $ny = $c[1];

                $dx = $nx - $source[0];
                $dy = $ny - $source[1];

                if ($iterate) {
                    $antinodes["{$nx}|{$ny}"] = 1;
                }

                do {
                    $nx += $dx;
                    $ny += $dy;

                    if (isset($data[$ny][$nx])) {
                        $antinodes["{$nx}|{$ny}"] = 1;
                    }
                } while ($iterate && isset($data[$ny][$nx]));
            }
        }
    }
    return count($antinodes);
}

print find_antinodes($data, $transmitters, false) . "\n";
print find_antinodes($data, $transmitters, true) . "\n";
