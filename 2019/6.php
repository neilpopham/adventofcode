<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(6)->lines()->regex('/(\w+)\)(\w+)/');

print_r($data);

$orbits = [];
foreach ($data as $pairs) {
    if (!isset($orbits[$pairs[0]])) {
        $orbits[$pairs[0]] = [];
    }
    $orbits[$pairs[0]][$pairs[1]] = $pairs[1];
}

print_r($orbits);

foreach ($orbits as $children) {
    print_r($children);
    foreach (array_keys($orbits) as $parent) {
        print "{$parent}\n";
        if (in_array($parent, $children)) {
            print "found\n";
            continue;
        }
    }
    $root[] = $parent;
}

print "{$root}\n";


function find_orbits()
{

}

find_orbits();
