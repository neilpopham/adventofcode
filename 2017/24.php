<?php

require 'libs/aoc.php';

$data = new AdventOfCode\AdventOfCode()->input(day: 24)->lines()->regex('/(\d+)\/(\d+)/');

function find_pipe($pipe)
{
    global $data, $queue;
    [$bridge, $end, $strength] = $pipe;
    $options = array_filter(
        $data,
        fn ($v, $k) => !in_array($k, $bridge) && in_array($end, $v),
        ARRAY_FILTER_USE_BOTH
    );
    foreach ($options as $i => $pipe) {
        $queue[] = [
            array_merge($bridge, [$i]),
            $pipe[0] == $end ? $pipe[1] : $pipe[0],
            $strength + array_sum($pipe)
        ];
    }
}

$queue = [];
foreach ($data as $i => $pipe) {
    if ($pipe[0] == 0 || $pipe[1] == 0) {
        $queue[] = [
            [$i],
            $pipe[0] == 0 ? $pipe[1] : $pipe[0],
            array_sum($pipe)
        ];
    }
}

$combos = [];
do {
    $pipe = array_pop($queue);
    find_pipe($pipe);
    $combos[] = $pipe;
} while (count($queue));

usort($combos, fn ($a, $b) => $b[2] <=> $a[2]);

$best = reset($combos);
print $best[2] . "\n";

$combos = array_map(
    function ($v) {
        $v[3] = count($v[0]);
        return $v;
    },
    $combos
);

usort(
    $combos,
    function ($a, $b) {
        if ($a[3] == $b[3]) {
            return $b[2] <=> $a[2];
        }
        return $b[3] <=> $a[3];
    }
);

$best = reset($combos);
print $best[2] . "\n";
