<?php

require 'libs/aoc.php';

$data = new AdventOfCode\AdventOfCode()->input(day: 13)->lines()->regex('/(\d+): (\d+)/');
// $data = new AdventOfCode\AdventOfCode()->example(13, 0)->lines()->regex('/(\d+): (\d+)/');

$scanners = [];
$max = 0;
foreach ($data as $row) {
    $scanners[$row[0]] = (object) ['len' => $row[1], 'max' => $row[1] - 1, 'pos' => 0, 'dir' => 1];
    $max = $row[0];
}

function run($scanners, $start)
{
    global $max;
    $severity = 0;
    for ($layer = $start; $layer <= $max; $layer++) {
        foreach ($scanners as $i => $scanner) {
            if ($i == $layer && $scanner->pos == 0) {
                $severity += $i * $scanner->len;
            }
            $scanner->pos += $scanner->dir;
            if ($scanner->pos == $scanner->max) {
                $scanner->dir = -1;
            } elseif ($scanner->pos == 0) {
                $scanner->dir = 1;
            }
        }
    }
    return $severity;
}

$severity = run($scanners, 0);
print $severity . "\n";

$start = 0;
do {
    $scanners = [];
    foreach ($data as $row) {
        $scanners[$row[0]] = (object) ['len' => $row[1], 'max' => $row[1] - 1, 'pos' => 0, 'dir' => 1];
    }
    // var_dump($start);
    $severity = run($scanners, --$start);
} while ($severity > 0);

print $start . "\n";
