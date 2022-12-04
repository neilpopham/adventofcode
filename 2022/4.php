<?php
require 'libs/api.php';

$data = (new AdventOfCode())->input(4)->lines()->regex('/^(\d+)\-(\d+),(\d+)\-(\d+)$/');

$total = 0;
foreach ($data as $point) {
    if ((($point[0] >= $point[2]) && ($point[1] <= $point[3]))
        || (($point[2] >= $point[0]) && ($point[3] <= $point[1]))
    ) {
        $total++;
    }
}
print "{$total}\n";

$total = 0;
foreach ($data as $point) {
    if (($point[2] > $point[1]) || ($point[3] < $point[0])
        || ($point[0] > $point[3]) || ($point[1] < $point[2])
    ) {
        continue;
    }
    $total++;
}
print "{$total}\n";
