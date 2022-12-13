<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(6)->lines()->regex('/(\w+)\)(\w+)/');

// print_r($data);

// $parents = [];
// foreach ($data as $pairs) {
//     if (!isset($orbits[$pairs[0]])) {
//         $orbits[$pairs[0]] = [];
//     }
//     $orbits[$pairs[0]][$pairs[1]] = $pairs[1];
// }
// print_r($parents);

$orbits = [];
foreach ($data as $pairs) {
    if (!isset($orbits[$pairs[0]])) {
        $orbits[$pairs[0]] = [];
    }
    $orbits[$pairs[0]][$pairs[1]] = $pairs[1];
}

// print_r($orbits);

function find_tree($orbits, $parent, $path)
{
    $x = ["{$path}/{$parent}"];
    if (false === isset($orbits[$parent])) {
        return $x;
    }
    foreach ($orbits[$parent] as $child) {
        $x = array_merge($x, find_tree($orbits, $child, $x[0]));
        // print_r($x);
        // exit;
    }
    return $x;
}

$tree = [];
foreach (array_keys($orbits) as $parent) {
    // print "{$parent}\n";
    $tree = array_merge($tree, find_tree($orbits, $parent, ''));
    // print_r($tree);
}

// print_r($tree);
$tree = array_values(array_filter($tree, fn($t) => !preg_match('/^\/\w+$/', $t)));
print_r($tree);
exit;
