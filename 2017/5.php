<?php

require 'libs/aoc.php';

$data = new AdventOfCode\AdventOfCode()->input(day: 5)->lines()->raw();

function execute($data, $incrementor)
{
    $i = 0;
    $p = 0;
    while (isset($data[$p])) {
        $d = $data[$p];
        $data[$p] = $incrementor($data[$p]);
        $p += $d;
        $i++;
    }

    print $i . "\n";
}

execute($data, fn ($v) => $v + 1);
execute($data, fn ($v) => $v + ($v < 3 ? 1 : -1));
