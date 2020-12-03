<?php

require('libs/core.php');

function check($trees, $dx = 3, $dy = 1) {
    $total = 0;
    $x = $dx;
    $width = strlen($trees[0]);
    for ($y = $dy; $y < count($trees); $y += $dy) {
        if ($trees[$y][$x] == '#') {
            $total++;
        }
        $x += $dx;
        $x = $x % $width;
    }
    print "\n{$total} trees\n";
    return $total;
}

$trees = load_data("3.txt");

$total1 = check($trees, 1, 1);
$total2 = check($trees, 3, 1);
$total3 = check($trees, 5, 1);
$total4 = check($trees, 7, 1);
$total5 = check($trees, 1, 2);

$total = $total1 * $total2 * $total3 * $total4 * $total5;

print "\n{$total} trees in all\n";
