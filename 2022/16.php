<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(16)->lines()
    ->regex('/Valve ([A-Z]+) has flow rate=(\d+); tunnels* leads* to valves* (.+)/');

$valves = [];
foreach ($data as $key => $value) {
    $valve = $value;
    $valve[2] = explode(', ', $value[2]);
    $valves[$valve[0]] = $valve;
}

uasort($valves, fn($a, $b) => $b[1] <=> $a[1]);

function process($a, &$g)
{
    global $valves;
    $q = [];
    $pg = $g[$a] + 1;
    foreach ($valves[$a][2] as $valve) {
        if ($pg < ($g[$valve] ?? PHP_INT_MAX)) {
            $g[$valve] = $pg;
            $q[] = $valve;
        }
    }
    return $q;
}

foreach (array_keys($valves) as $v) {
    $g = [$v => 0];
    $q = process($v, $g);
    $valve = current($q);
    while (false === is_null($valve)) {
        $q = array_merge($q, process($valve, $g));
        $valve = array_shift($q);
    }
    $valves[$v][3] = $g;
}

$useful = array_map(
    fn($v) => $v[0],
    array_filter($valves, fn($v) => $v[1] > 0)
);

function check($a, $time, $path)
{
    global $useful, $valves, $g;
    $q = [];
    foreach ($useful as $b) {
        if (strpos($path, $b) === false) {
            $t = $time - $valves[$a][3][$b] - 1;
            if ($t > 0) {
                $pressure = ($g[$path] ?? 0) + $valves[$b][1] * $t;
                $move = $path . $b;
                if ($pressure > ($g[$move] ?? 0)) {
                    $g[$move] = ($g[$path] ?? 0) + $valves[$b][1] * $t;
                    $q[] = [$b, $t, $move];
                }
            }
        }
    }
    return $q;
}

$g = [];
$q = check('AA', 30, '');
$next = current($q);
while (false === is_null($next)) {
    list($a, $time, $path) = $next;
    $q = array_merge($q, check($a, $time, $path));
    $next = array_shift($q);
}
arsort($g);
print_r($g);
print reset($g) . "\n";
