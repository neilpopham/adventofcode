<?php

require 'libs/aoc.php';

use AdventOfCode\Set as Set;

$data = new AdventOfCode\AdventOfCode()->input(day: 12)->lines()->regex('/(\d+) <\-> (.+)/');

$data = array_map(
    function ($row) {
        $row[1] = explode(',', str_replace(' ', '', $row[1]));
        return $row;
    },
    $data
);

function find_pipes($program): Set
{
    global $data;
    $queue = [];
    foreach ($program[1] as $id) {
        $queue[] = $id;
    }

    $found = new Set([$program[0]]);

    while ($queue) {
        $id = array_pop($queue);
        $found->add($id);
        $program = $data[$id];
        foreach ($program[1] as $id) {
            if (false === $found->has($id)) {
                $queue[] = $id;
            }
        }
    }

    return $found;
}

$found = find_pipes($data[0]);

print $found->size() . "\n";

$groups[0] = $found;

foreach ($data as $id => $program) {
    if (false === $found->has($id)) {
        $group = find_pipes($program);
        foreach ($group->entries() as $id) {
            $found->add($id);
        }
        $groups[] = $group;
    }
}

print count($groups) . "\n";
