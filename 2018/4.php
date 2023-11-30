<?php

require 'libs/api.php';

$input = (new AdventOfCode())->input(4);

$data = $input->lines()->raw();
sort($data);

$current = 0;
$totals = [];
$minutes = [];

foreach ($data as $row) {
    if (preg_match('/Guard #(\d+) begins shift$/', $row, $matches)) {
        $current = (int) $matches[1];
        if (!isset($minutes[$current])) {
            $totals[$current] = 0;
            $minutes[$current] = [];
        }
    } elseif (preg_match('/^\[(\d+)\-(\d+)\-(\d+) (\d+):(\d+)\] falls asleep$/', $row, $matches)) {
        $begin = (int) $matches[5];
    } elseif (preg_match('/^\[(\d+)\-(\d+)\-(\d+) (\d+):(\d+)\] wakes up$/', $row, $matches)) {
        $end = (int) $matches[5];
        for ($i = $begin; $i < $end; $i++) {
            $minutes[$current][$i] = ($minutes[$current][$i] ?? 0) + 1;
        }
        $totals[$current] += ($end - $begin);
    }
}
#
arsort($totals);
$guard = key($totals);

$minute = $minutes[$guard];
arsort($minute);
$minute = key($minute);

print ($guard * $minute) . "\n";

$max = 0;
foreach ($minutes as $id => $values) {
    foreach ($values as $no => $value) {
        if ($value > $max) {
            $max = $value;
            $guard = $id;
            $minute = $no;
        }
    }
}

print ($guard * $minute) . "\n";
