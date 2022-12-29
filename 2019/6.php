<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(6)->lines()->regex('/(\w+)\)(\w+)/');

$orbits = [];
foreach ($data as $pairs) {
    if (!isset($orbits[$pairs[0]])) {
        $orbits[$pairs[0]] = [];
    }
    $orbits[$pairs[0]][$pairs[1]] = $pairs[1];
}

function process($parent, $count)
{
    global $orbits, $g;
    $g[$parent] = $count;
    if (!isset($orbits[$parent])) {
        return;
    }
    foreach ($orbits[$parent] as $child) {
        process($child, $g[$parent] + 1);
    }
}

$g = [];
process('COM', 0);

print array_sum($g);
print "\n";

function process2($parent, $path)
{
    global $orbits, $g;
    $g[$parent] = (empty($path) ? $path : "{$path}/") . $parent;
    if (!isset($orbits[$parent])) {
        return;
    }
    foreach ($orbits[$parent] as $child) {
        process2($child, $g[$parent]);
    }
}

$g = [];
process2('COM', '');

$you = explode('/', $g['YOU']);
$san = explode('/', $g['SAN']);

$diff1 = array_diff($san, $you);
$diff2 = array_diff($you, $san);

print count($diff1) - 1 + count($diff2) - 1;
print "\n";
