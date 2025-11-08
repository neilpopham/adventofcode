<?php

require 'libs/aoc.php';

$data = new AdventOfCode\AdventOfCode()->input(day: 7)->lines()->regex('/(\w+) \((\d+)\)(?: \-> (.+))*/');

$programs = [];
foreach ($data as $i => $row) {
    if (isset($row[2])) {
        $row[2] = explode(',', str_replace(' ', '', $row[2]));
    }
    $programs[$row[0]] = $row;
}

$options = array_filter(
    $programs,
    fn($v) => isset($v[2])
);

$options = array_filter(
    $options,
    function($v) use($options) {
        foreach($options as $o) {
            if (in_array($v[0], $o[2])) {
                return false;
            }
        }
        return true;
    }
);

$program = key($options);

print $program . "\n";

function weight(&$programs, $program)
{
    $current = $programs[$program];
    $weight = $current[1];
    if (isset($current[2])) {
        foreach ($current[2] as $name) {
            $weight += weight($programs, $name);
        }
    }
    $programs[$program][3] = $weight;
    return $weight;
}

weight($programs, $program);

$options = array_filter(
    $programs,
    fn($v) => isset($v[2])
);

function find_unbalanced($programs, $options)
{
    $unbalanced = [];
    foreach($options as $option) {
        $weights = array_map(
            fn ($name) => $programs[$name][3],
            $option[2]
        );
        $counts = [];
        foreach($weights as $weight) {
            $counts[$weight] = isset($counts[$weight]) ? $counts[$weight] + 1 : 1;
        }
        if (count($counts) > 1) {
            arsort($counts);
            $max = key($counts);
            foreach ($option[2] as $name) {
                $weight = $programs[$name][3];
                if ($counts[$weight] == 1) {
                    $unbalanced[$name] = $programs[$name];
                    $unbalanced[$name][4] = $max;
                    break;
                }
            }
        }
    }
    return $unbalanced;
}

do {
    $options = find_unbalanced($programs, $options);
} while (count($options) > 1);

$option = reset($options);

print ($option[1] - $option[3] + $option[4]) . "\n";
