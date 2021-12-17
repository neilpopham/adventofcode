<?php

require('libs/core.php');

//target area: x=20..30, y=-10..-5

$data = load_file("17.txt");

$r = '([\-\d]+)\.\.([\-\d]+)';
preg_match('/^target area: x=' . $r . ', y=' . $r . '$/', $data, $matches);
$x1 = min($matches[1], $matches[2]);
$x2 = max($matches[1], $matches[2]);
$y1 = min($matches[3], $matches[4]);
$y2 = max($matches[3], $matches[4]);

$total = 0;
$highest = 0;

for ($sy = 100; $sy > -100; $sy--) {
    $my = $sy;
    for ($sx = 500; $sx > 0; $sx--) {
        $mx = $sx;
        $x = 0;
        $y = 0;
        $dx = $sx;
        $dy = $sy;
        $max = 0;
        while ($y > $y1) {
            $x += $dx;
            $y += $dy;
            if ($y > $max) {
                $max = $y;
            }
            if ($x >= $x1 && $x <= $x2 && $y >= $y1 && $y <= $y2) {
                if ($max > $highest) {
                    $highest = $max;
                }
                $total++;
                break;
            }
            if ($dx > 0) {
                $dx--;
            }
            $dy--;
        }
    }
}

print "maximum height: {$highest}\n";
print "total:          {$total}\n";
